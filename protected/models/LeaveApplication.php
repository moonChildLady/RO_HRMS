<?php

/**
 * This is the model class for table "LeaveApplication".
 *
 * The followings are the available columns in table 'LeaveApplication':
 * @property integer $id
 * @property string $staffCode
 * @property string $startDate
 * @property string $endDate
 * @property string $type
 * @property integer $duration
 * @property integer $reasonID
 * @property string $reasonRemarks
 * @property integer $commentID
 * @property string $commentRemarks
 * @property integer $attachmentID
 * @property string $createDate
 * @property string $createdBy
 *
 * The followings are the available model relations:
 * @property Staff $staffCode0
 * @property ContentTable $reason
 * @property ContentTable $comment
 * @property Attachments $attachment
 * @property Staff $createdBy0
 */
class LeaveApplication extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	
	public $Fullname;
	public $attachment;
	//public $ApprovalStatus;
	public $ApproveDropdown;
	public $LeaveBalanceLabel;
	public $DurationDayLabel;
	
	
	public function tableName()
	{
		return 'LeaveApplication';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staffCode, startDate, endDate, reasonID, endDateType, startDateType', 'required', 'on'=>'create'),
			array('startDate, endDate, reasonID, endDateType, startDateType', 'required', 'on'=>'update'),
			array('startDate, endDate', 'required', 'on'=>'export'),
			array('startDate, endDate, reasonID, endDateType, startDateType', 'required', 'on'=>'createbystaff'),
			
			array('endDate','compare','compareAttribute'=>'startDate','operator'=>'>=','message'=>'Start Date must be less than End Date', 'on'=>'create'),
			array('endDate','compare','compareAttribute'=>'startDate','operator'=>'>=','message'=>'Start Date must be less than End Date', 'on'=>'createbystaff'),
			
			
			array('endDate', 'checkOverLap', 'on'=>'createbystaff'),
			array('reasonID', 'checkDateLimit', 'on'=>'createbystaff'),
			
			array('endDate', 'checkDateLimit', 'on'=>'createbystaff'),
			array('endDate', 'checkMarriageDateLimit', 'on'=>'createbystaff'),
			
			array('ApproveDropdown', 'required', 'message'=>'Please Choose','on'=>'approval'),
			array('HRStatus', 'required', 'on'=>'HRStatusupdate'),
			
			//array('duration, reasonID, commentID, attachmentID', 'numerical', 'integerOnly'=>true),
			//array('staffCode, createdBy, approvedBy, refNo, ApproveDropdown', 'length', 'max'=>100),
			
			array('reasonRemarks, commentRemarks, staffCode, startDate, ndDate, reasonID, commentID, endDateType, startDateType, HRStatus', 'safe'),
			array('attachment', 'file', 'types'=>'jpg, png, pdf, jpeg', 'maxSize'=>1024 * 1024 * 5, 'tooLarge'=>'File has to be smaller than 5MB', 'safe' => false, 'allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, startDate, endDate, duration, reasonID, reasonRemarks, commentID, commentRemarks, attachmentID, createDate, createdBy, attachment, approvedBy, approvedDate, refNo, ApproveDropdown, Fullname, status, HRStatus', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'staffCode0' => array(self::BELONGS_TO, 'Staff', 'staffCode'),
			'reason' => array(self::BELONGS_TO, 'ContentTable', 'reasonID'),
			'comment' => array(self::BELONGS_TO, 'ContentTable', 'commentID'),
			'HRStatus0' => array(self::BELONGS_TO, 'ContentTable', 'HRStatus'),
			'attachments' => array(self::BELONGS_TO, 'Attachments', 'attachmentID'),
			'createdBy0' => array(self::BELONGS_TO, 'Staff', 'createdBy'),
			'approvedBy0' => array(self::BELONGS_TO, 'Staff', 'approvedBy'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'staffCode' => 'Staff Code',
			'startDate' => 'Start Date',
			'endDate' => 'End Date',
			'startDateType' => 'Start Date Timeslot',
			'endDateType' => 'End Date Timeslot',
			'duration' => 'Duration',
			'reasonID' => 'Reason',
			'reasonRemarks' => 'Reason Remarks',
			'commentID' => 'Comment',
			'commentRemarks' => 'Comment Remarks',
			'attachmentID' => 'Attachment',
			'createDate' => 'Application Date',
			'createdBy' => 'Created By',
			'Fullname' => 'Fullname',
			'attachment' => 'Attachment',
			'approvedBy' =>'Approved By',
			'approvedDate' => 'Approved Date',
			'ApprovalStatus' => 'Approval Status',
			'LeaveBalance' => 'Leave Balance',
			'refNo' => 'Ref. No',
			'ApproveDropdown'=>'Approval Action',
			'LeaveBalanceLabel'=>'Balance',
			'DurationDayLabel'=>'Duration',
			'status'=>'Status',
			'HRStatus'=>'Original Supporting Doc'
			
			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($status)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$model = LeaveApplication::model()->findAll($criteria);
		
		$allListApproved = array();
		$allListNotApproved = array();
		foreach($model as $i=>$data){
			
			if($this->isApproved($data->id, $data->staffCode)){
				$allListApproved[] = $data->id;
			}else{
				$allListNotApproved[] = $data->id;
			}
		}
		
		
		
		
		unset($criteria);
		$criteria=new CDbCriteria;
		
		
		
		
		
		
		$sort = new CSort();
		$criteria->with = array("staffCode0");
		$criteria->compare('id',$this->id);
		$criteria->compare('t.staffCode',$this->staffCode,true);
		$criteria->compare('startDate',$this->startDate,true);
		$criteria->compare('refNo',$this->refNo,true);
		$criteria->compare('startDateType',$this->startDateType,true);
		$criteria->compare('endDateType',$this->endDateType,true);
		$criteria->compare('endDate',$this->endDate,true);
		$criteria->compare('approvedBy',$this->approvedBy,true);
		$criteria->compare('approvedDate',$this->approvedDate,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('reasonID',$this->reasonID);
		$criteria->compare('reasonRemarks',$this->reasonRemarks,true);
		$criteria->compare('commentID',$this->commentID);
		$criteria->compare('commentRemarks',$this->commentRemarks,true);
		$criteria->compare('attachmentID',$this->attachmentID);
		$criteria->compare('createDate',$this->createDate,true);
		$criteria->compare('createdBy',$this->createdBy,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('HRStatus',$this->HRStatus,true);
		$criteria->compare('concat(staffCode0.surName, " ",staffCode0.givenName)',$this->Fullname,true);
		
		
		
		if($status == "notapproved"){
			$criteria->addInCondition('t.id', $allListNotApproved);
			$criteria->addCondition('status != "CANCEL"');
		}
		$criteria->addCondition('left(t.staffCode,3) != "999"');
		$sort->defaultOrder= array(
			'id'=>CSort::SORT_DESC,
			//'id'=>CSort::SORT_ASC,
			
            
        );
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			 
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LeaveApplication the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function getReasonwithRemarks(){
		
		if($this->reasonRemarks!=""){
			$remarks = "<br>Remarks: ".$this->reasonRemarks;
		}else{
			$remarks = "";
		}
		return $this->reason->content.$remarks;
	}
	
	public function getCommentwithRemarks(){
		
		$string = "";
		if($this->commentID !=""){
			$string .= $this->comment->content;
		}
		
		if($this->commentRemarks!=""){
			$remarks = "<br>Remarks: ".$this->commentRemarks;
		}else{
			$remarks = "";
		}
		return $string.$remarks;
	}
	
	public function getStartDateSlot(){
		return date("Y-m-d", strtotime($this->startDate))." ".$this->startDateType;
	}
	
	public function getEndDateSlot(){
		return date("Y-m-d", strtotime($this->endDate))." ".$this->endDateType;
	}
	
	public function userListView(){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("status = :status");
		$criteria->params = array(
			':staffCode'=>Yii::app()->user->getState('staffCode'),
			':status'=>'ACTIVE'
		);
		$criteria->compare('startDate',$this->startDate,true);
		$criteria->compare('reasonID',$this->reasonID);
		$criteria->compare('endDate',$this->endDate,true);
		$criteria->order = "createDate DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function manageApproval($status){
		$criteria = new CDbCriteria;
		$criteria->addCondition("approver = :approver");
		$criteria->addCondition(":date between startDate and endDate");
		$criteria->params = array(
			':approver'=>Yii::app()->user->getState('staffCode'),
			':date'=>date('Y-m-d H:i:s')
		);
		
		$criteria->order = "id DESC";
		
		$model = Approvers::model()->findAll($criteria);
		
		$needtoApprove = array();
		
		foreach($model as $i=>$approver){
			array_push($needtoApprove, $approver->staffCode);
		}
		
		
		$criteria2 = new CDbCriteria;
		$criteria2->addCondition("approver = :approver");
		//$criteria2->addCondition("createDate between :startDate and :endDate");
		$criteria2->params = array(
			':approver'=>Yii::app()->user->getState('staffCode'),
			//':startDate'=>$model->startDate,
			//':endDate'=>$model->endDate,
		);
		
		$ApprovalLogModel = ApprovalLog::model()->findAll($criteria2);
		
		
		$approved = array();
		
		foreach($ApprovalLogModel as $i=>$ApprovalLog){
			array_push($approved, $ApprovalLog->leaveApplicationID);
		}
		
		
		
		
		
		$ids = array();
		
		foreach($model as $i=>$approver){
			
			//if(in_array($approver->staffCode, $needtoApprove)){
			
				$criteria3 = new CDbCriteria;
				//$criteria3->with = array("staffCode0");
				$criteria3->addCondition("createDate between :startDate and :endDate");
				$criteria3->addCondition("status = :status");
				$criteria3->addCondition("staffCode = :staffCode");
				
				$criteria3->params = array(
					':status'=>'ACTIVE',
					':startDate'=>$approver->startDate,
					':endDate'=>$approver->endDate,
					':staffCode'=>$approver->staffCode,
				);
				$criteria3->addNotInCondition("id", $approved);
			$leaveModel = LeaveApplication::model()->findAll($criteria3);
			
			foreach($leaveModel as $j=>$leaves){
				array_push($ids, $leaves->id);
			}
			//echo $approver->id."<br>";
			//}
		}
		
		
		
		$criteria1 = new CDbCriteria;
		$criteria1->with = array("staffCode0");
		$criteria1->addCondition("status = :status");
		$criteria1->params = array(
			':status'=>'ACTIVE'
		);
		
		if($status=="approved"){
			$criteria1->addInCondition("t.id", $approved);
		}else{
			//$criteria1->addNotInCondition("t.id", $approved);
			$criteria1->addInCondition("t.id", $ids);
			
		}
		
		
		
		
		
		
		
		
		//$criteria1->addInCondition("t.staffCode", $needtoApprove);
		
		$criteria1->compare('concat(staffCode0.surName, staffCode0.givenName)',$this->Fullname,true);
		$criteria1->compare('t.staffCode',$this->staffCode,true);
		$criteria1->compare('refNo',$this->refNo,true);
		$criteria1->compare('startDate',$this->startDate,true);
		$criteria1->compare('endDate',$this->endDate,true);
		$criteria1->compare('reasonID',$this->reasonID);
		
		$criteria1->order = "createDate DESC, t.staffCode";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria1,
		));
	}
	
	
	public function isApproved($leaveID, $staffCode){
		
		$array = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition("leaveApplicationID = :leaveApplicationID");
		$criteria->params = array(
			':leaveApplicationID'=>$leaveID
		);
		$model=ApprovalLog::model()->findAll($criteria);
		
		foreach($model as $i=>$approver){
			if($approver->status == "APPROVED"){
				array_push($array, $approver->approver);
			}
		}
		$leaveModel = LeaveApplication::model()->findByPK($leaveID);
		$isApproved = $this->checkApprover($staffCode, $array, $leaveModel);
		
		return $isApproved;
		
		
	}
	
	public function checkApprover($staffCode, $array, $leaveModel=null){
		
		
		
		$criteria1 = new CDbCriteria;
		$criteria1->addCondition("staffCode = :staffCode");
		$criteria1->addCondition(":date between startDate and endDate");
		$criteria1->params = array(
			':staffCode'=>$staffCode,
			':date'=>$leaveModel->createDate
		);
		
		//$criteria1->order = "position ASC";
		//$criteria1->group = "approver";
		$approvers=Approvers::model()->findAll($criteria1);
		$apprvoed = true;
		foreach($approvers as $i=>$approver){
			if(in_array($approver->approver, $array)){
				$apprvoed = $apprvoed&&true;
			}else{
				$apprvoed = $apprvoed&&false;
			}
		}
		
		return $apprvoed;
	}
	
	
	public function getApprovalStatus(){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("leaveApplicationID = :leaveApplicationID");
		$criteria->params = array(
			':leaveApplicationID'=>$this->id
		);
		$model=ApprovalLog::model()->findAll($criteria);
		//$leaveModel = LeaveApplication::model()->findByPK($this->id);
		$criteria1 = new CDbCriteria;
		$criteria1->addCondition("staffCode = :staffCode");
		$criteria1->addCondition("resigned = :resigned");
		$criteria1->params = array(
			':staffCode'=>$this->staffCode,
			':resigned'=>'NO',
		);
		
		$userModel = Users::model()->find($criteria1);
		
		
		$str = "";
		$exist = array();
		if($model){	
			foreach($model as $i=>$log){
				if($log->status =="APPROVED"){
							$label = "success";
							if($userModel){
								$text = "Approved";
							}else{
								$text = "Approved via signed slip";
							}
						}else{
							$label = "danger";
							if($userModel){
								$text = "Rejected";
							}else{
								$text = "Rejected via signed slip";
							}
						}
			$str .= '<p><span class="label label-'.$label.'">'.$text.' '.$log->approver0->Fullname.'</span></p>';
			array_push($exist, $log->approver);
			}
		}
		
		
		$criteria1 = new CDbCriteria;
		$criteria1->addCondition("staffCode = :staffCode");
		$criteria1->addCondition(":date between startDate and endDate");
		$criteria1->params = array(
			':staffCode'=>$this->staffCode,
			':date'=>$this->createDate
		);
		$criteria1->order = "position ASC";
		//$criteria1->group = "approver";
		$approvers=Approvers::model()->findAll($criteria1);
		
			$label = "warning";
			$text = "Pending";
			foreach($approvers as $i=>$approver){ 
			
			if(!in_array($approver->approver, $exist)){
				
				$str .= '<p><span class="label label-'.$label.'">'.$text.' '.$approver->approver0->Fullname.'</span></p>';
			}
			}
		
			return $str;
		
	}
	
	public function checkOverLap(){
		
		/* $endDate = $attribute;
		$startDate = $params['startDate'];
		$staffCode =  */
		
		$startDate = $this->startDate;
		$endDate = $this->endDate;
		//$type = $this->reasonID;
		
		$criteria = new CDbCriteria;
		//$criteria->addCondition("startDate between :startDate and :endDate OR endDate between :startDate and :endDate");
		//$criteria->compare("endDate between :startDate1 and :endDate2", true, 'OR');
		$criteria->addCondition(":startDate <= startDate");
		$criteria->addCondition(":endDate >= endDate");
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("status = :status");
		$criteria->addCondition("reasonID = :reasonID");
		
		$criteria->params = array(
			':startDate'=>$startDate,
			':endDate'=>$endDate,
			':status'=>'ACTIVE',
			':reasonID'=>$this->reasonID,
			':staffCode'=>Yii::app()->user->getState('staffCode')
			
		);
		$model = LeaveApplication::model()->findAll($criteria);
		
		if($model){
			//$this->addError('startDate', 'Your  vacation is overlapped with others!');
			$this->addError('endDate', 'Your vacation is overlapped, please check again.');
		}
	}
	
	public function checkDateLimit(){
		
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>Yii::app()->user->getState('staffCode')
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		$d1 = new DateTime(date('Y-m-d'));
		$d2 = new DateTime($StaffEmployment->startDate);
		$diff = $d2->diff($d1);
		
		
		$total = ($diff->y/6 > 1)?1:0;
		
		$startDate = $this->startDate;
		$endDate = $this->endDate;
		$type = $this->reasonID;
		
		$d11 = new DateTime($startDate);
		$d22 = new DateTime($endDate);
		$diff1 = $d22->diff($d11)->format("%a");
		
		if($diff1 > $total && $type=="128"){
			$this->addError('endDate', 'no more than '.($total+1).' days');
		}
	}
	
	public function checkMarriageDateLimit(){
		
		$isProbation = false;
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>Yii::app()->user->getState('staffCode')
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		
		if($StaffEmployment->probationEndDate==""){
			$d1 = new DateTime(date('Y-m-d'));
			$d2 = new DateTime($StaffEmployment->startDate);
			$diff = $d2->diff($d1);
			
			
			
			if($diff->m+($diff->y*12) < 3 ){
				$isProbation = true;
			}
		}else{
			if($StaffEmployment->probationEndDate > date('Y-m-d')){
				$isProbation = true;
			}
		}
		
		if($this->reasonID != '110' && $this->reasonID != '66' && $this->reasonID != '68'){
			if($isProbation){
				$this->addError('endDate', 'You are still in probation peroid.');
			}
		}
		
		/* if($isProbation){
			
			$this->addError('endDate', 'You are still in probation peroid.');
		}else {*/
			
			$criteria = new CDbCriteria;
			$criteria->addCondition("staffCode = :staffCode");
			$criteria->addCondition("status = :status");
			$criteria->addCondition("reasonID = 129");
			$criteria->params = array(
			':status'=>'ACTIVE',
			':staffCode'=>Yii::app()->user->getState('staffCode')
			);
			
			$model = LeaveApplication::model()->findAll($criteria);
			$applied = 0;
			foreach($model as $i=>$leave){
				
				$datetime1 = new DateTime($leave->startDate);
				$datetime2 = new DateTime($leave->endDate);
				$interval1 = $datetime1->diff($datetime2);
				$interval = $interval1->format('%a')+1;
				$applied += $interval;
			}
			
			$total = 3;
			
			$startDate = $this->startDate;
			$endDate = $this->endDate;
			$type = $this->reasonID;
			
			$d11 = new DateTime($startDate);
			$d22 = new DateTime($endDate);
			$diff1 = $d22->diff($d11)->format("%a");
			
			if($diff1 > $total && $type=="129"){
				$this->addError('endDate', 'no more than '.($total).' days');
			}
			
			if($diff1 > ($total-$applied) && $type=="129"){
				$this->addError('endDate', 'no more than '.($total-$applied).' days');
			}
		//}
	}
	
	public function checkALLimit(){
		
		
		
	}
	
	public function getLeaveBalance(){
		//LeaveBalance
		//StaffDuty
		//Holidays
		
		$addition = 0;
		$days = 0;
		static $remaning = 0;
		static $durition = 0;
		
		
		$criteria = new CDbCriteria;
		//$criteria->addCondition("balanceDate > :endDate");
		//$criteria->addCondition(":endDate >= endDate");
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			//':endDate'=>$this->endDate,
			//':endDate'=>$endDate,
			':staffCode'=>$this->staffCode
			
		);
		$model = LeaveBalance::model()->find($criteria);
		
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		//$model = LeaveApplication::model()->findByPk($this->id);
		
		$datetime1 = new DateTime($this->startDate);
		$datetime2 = new DateTime($this->endDate);
		$interval = $datetime1->diff($datetime2);
		
		$startDateType = $this->startDateType;
		$endDateType = $this->endDateType;
		
		
		
			if($startDateType == $endDateType){
				if($startDateType != "ALL" && $endDateType != "ALL"){
					$addition += 0.5;
				}
			}else{
				$addition += 0.5;
			}
			
			if($interval->days >= 1){
				if($startDateType=="AM" && $endDateType == "PM"){
					$addition += 1;
				}
				if($startDateType=="ALL" && $endDateType == "ALL"){
					$addition += 1;
				}
				
				if($startDateType=="PM" && $endDateType == "AM"){
					$addition -= 0.5;
				}
				/* if($startDateType=="ALL" && $endDateType == "AM"){
					$addition += 0.5;
				} */
				/* if($startDateType=="PM" && $endDateType == "ALL"){
					$addition += 0.5;
				} */
			}
			if($interval->days == 0){
				if($startDateType=="ALL" && $endDateType == "ALL"){
					$addition += 1;
				}
			}
		$criteria4 = new CDbCriteria;
		$criteria4->addCondition("staffCode = :staffCode");
		$criteria4->params = array(
			':staffCode'=>$model->staffCode
		);
		$alternateGroup = AlternateGroup::model()->find($criteria4);
		unset($criteria4);
		
		
		$criteria4 = new CDbCriteria;
		$criteria4->addCondition("groupID = :groupID");
		$criteria4->params = array(
			':groupID'=>$alternateGroup->groupID
		);
		$StaffGroup = StaffGroup::model()->find($criteria4);
		
		//includeing holiday
		$period = new DatePeriod(
     new DateTime($this->startDate),
     new DateInterval('P1D'),
     new DateTime($this->endDate)
	 );
	 foreach ($period as $key => $value) {
		$criteria1 = new CDbCriteria;
		$criteria1->with = array('holidays');
		$criteria1->addCondition("holidays.eventDate = :eventDate");
		$criteria1->addCondition("groupName = :groupName");
		$criteria1->params = array(
			':eventDate'=>$value->format('Y-m-d'),
			//':groupID'=>$StaffEmployment->Basis,
			':groupName'=>$StaffGroup->groupName,
			//':staffCode'=>Yii::app()->user->getState('staffCode')
			
		);
		//$criteria1->group = 'eventDate';
		$isholiday = HolidaysGroup::model()->find($criteria1);
		//$isholiday = Holidays::model()->find($criteria1);
		
		unset($criteria1);	
			if($isholiday){
				$addition -= 1;
			}else{
				if($StaffEmployment->Basis==63){
				if(date('N', strtotime($value->format('Y-m-d'))) == 7){
					$addition -= 1;
				}
				}
				if($StaffEmployment->AlternateGroup0){
				if(date('N', strtotime($value->format('Y-m-d'))) == 6){
					$criteria1 = new CDbCriteria;
					$criteria1->addCondition("dutyDate = :dutyDate");
					$criteria1->addCondition("groupID = :groupID");
					$criteria1->params = array(
						':dutyDate'=>$value->format('Y-m-d'),
						':groupID'=>$StaffEmployment->AlternateGroup0->alternateGroupID,
					);
					$AlternateDuty = AlternateDuty::model()->find($criteria1);
					$oneDay = array("96","97","98","100");
					if(!$AlternateDuty){
						if(in_array($StaffEmployment->AlternateGroup0->groupID, $oneDay)){
							//$addition -= 1;
						}else{
							$addition -= 1;
						}
					}else{
						
						if($interval->days > 0){
							$addition -= 0.5;
						}
					}
				}
				}
			}
	 }
	
	//entitlement
	$begin = (date('Y')=="2018")?new DateTime( '2018-03-22' ):new DateTime( date('Y').'-01-01' );
	$end = new DateTime(date('Y-m-d'));
	$calcurrentDay = $begin->diff($end);

	$entitlement = (14/365)*($calcurrentDay->days+1);
	
	
		if($this->reasonID == "66" || $this->reasonID == "83" || $this->startDate < '2018-03-22') {
			$durition += 0;
		}else{
			$durition += $interval->days+$addition;
		}
		//$remaning = ($model->balance+round($entitlement,2))-$durition;
		$remaning = ($model->balance+round($entitlement,2))-$durition;
		//$remaning -= $days;
		
		return $remaning;
	}
	
	public function getDurationDay(){
		$addition = 0;
		$days = 0;
		$specialStaffForAllDay = array("539");
		
		$criteria = new CDbCriteria;
		//$criteria->addCondition("balanceDate > :endDate");
		//$criteria->addCondition(":endDate >= endDate");
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			//':endDate'=>$this->endDate,
			//':endDate'=>$endDate,
			':staffCode'=>$this->staffCode
			
		);
		//$model = LeaveBalance::model()->find($criteria);
		
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		$datetime1 = new DateTime($this->startDate);
		$datetime2 = new DateTime($this->endDate);
		$interval1 = $datetime1->diff($datetime2);
		$interval = $interval1->format('%a');
		
		$startDateType = $this->startDateType;
		$endDateType = $this->endDateType;
		
			if($interval == 0){
				if($startDateType=="AM" && $endDateType == "AM"){
					$addition += 0.5;
				}
				if($startDateType=="PM" && $endDateType == "PM"){
					$addition += 0.5;
				}
				if($startDateType=="ALL" && $endDateType == "ALL"){
					$addition += 1;
				}
				if($startDateType=="AM" && $endDateType == "PM"){
					$addition += 1;
				}
				
			}
			
			if($interval >= 1){
				if($startDateType=="ALL" && $endDateType == "ALL"){
					$addition += 1;
				}
				if($startDateType=="AM" && $endDateType == "AM"){
					$addition += 0.5;
				}
				if($startDateType=="PM" && $endDateType == "PM"){
					$addition += 0.5;
				}
				
				if($startDateType=="ALL" && $endDateType == "AM"){
					$addition += 0.5;
				}
				if($startDateType=="ALL" && $endDateType == "PM"){
					$addition += 1;
				}
				if($startDateType=="AM" && $endDateType == "ALL"){
					$addition += 1;
				}
				if($startDateType=="PM" && $endDateType == "ALL"){
					$addition += 0.5;
				}
				/* if($startDateType=="PM" && $endDateType == "AM"){
					$addition += 0.5;
				} */
				if($startDateType=="AM" && $endDateType == "PM"){
					$addition += 1;
				}
				
			}
		
		
		/* $criteria4 = new CDbCriteria;
		$criteria4->addCondition("staffCode = :staffCode");
		$criteria4->params = array(
			':staffCode'=>$this->staffCode
		);
		$alternateGroup = AlternateGroup::model()->find($criteria4);
		unset($criteria4);
		
		
		$criteria4 = new CDbCriteria;
		$criteria4->addCondition("groupID = :groupID");
		$criteria4->params = array(
			':groupID'=>$alternateGroup->groupID
		);
		$StaffGroup = StaffGroup::model()->find($criteria4); */
		
		$period = new DatePeriod(new DateTime($this->startDate),new DateInterval('P1D'),$datetime2->modify('+1 day'));
		foreach ($period as $key => $value) {
			
			unset($criteria1);
				$criteria1 = new CDbCriteria;
				$criteria1->addCondition("staffCode = :staffCode");
				$criteria1->addCondition("status = :status");
				$criteria1->addCondition("currentYear = :currentYear");
				$criteria1->params = array(
					':currentYear'=>$value->format('Y'),
					//':groupID'=>$StaffEmployment->Basis,
					':staffCode'=>$this->staffCode,
					':status'=>'YES',
					//':staffCode'=>Yii::app()->user->getState('staffCode')
					
				);
				
				//$criteria1->group = 'eventDate';
				$AlternateGroup = AlternateGroup::model()->find($criteria1);
				
		if($AlternateGroup){		
				unset($criteria4);
		
		
		$criteria4 = new CDbCriteria;
		$criteria4->addCondition("groupID = :groupID");
		$criteria4->params = array(
			':groupID'=>$AlternateGroup->groupID
		);
		$StaffGroup = StaffGroup::model()->find($criteria4);
			
		if($this->reasonID!=66  && $this->reasonID != 130 && $this->reasonID != 129){	
			
		$criteria1 = new CDbCriteria;
		$criteria1->with = array('holidays');
		$criteria1->addCondition("holidays.eventDate = :eventDate");
		$criteria1->addCondition("groupName = :groupName");
		$criteria1->params = array(
			':eventDate'=>$value->format('Y-m-d'),
			//':groupID'=>$StaffEmployment->Basis,
			':groupName'=>$StaffGroup->groupName,
			//':staffCode'=>Yii::app()->user->getState('staffCode')
			
		);
		//$criteria1->group = 'eventDate';
		$isholiday = HolidaysGroup::model()->find($criteria1);
		unset($criteria1);	
			if($isholiday){
				if($endDateType=="AM"){
					$addition -= 0.5;
				}elseif($startDateType=="PM"){
					$addition -= 0.5;
				}else{
					$addition -= 1;
				}
			}else{
				if($StaffEmployment->Basis==63){
				if(date('N', strtotime($value->format('Y-m-d'))) == 7){
					$oneDaySunday = array("96");
					if(in_array($AlternateGroup->groupID, $oneDaySunday)){
						
					}else{
						$addition -= 1;
					}
				}
				}
				
				
				
				
				
				if($StaffEmployment->AlternateGroup0){
				if(date('N', strtotime($value->format('Y-m-d'))) == 6){
				
				
				/*
if($StaffEmployment->AlternateGroup0->alternateGroupID == "3"){
					$addition += 0.5;
				}
*/
					$criteria1 = new CDbCriteria;
					$criteria1->addCondition("dutyDate = :dutyDate");
					$criteria1->addCondition("groupID = :groupID");
					$criteria1->params = array(
						':dutyDate'=>$value->format('Y-m-d'),
						':groupID'=>$StaffEmployment->AlternateGroup0->alternateGroupID,
					);
					$AlternateDuty = AlternateDuty::model()->find($criteria1);
					$oneDay = array("96","97","98","124");
					if(in_array($AlternateGroup->groupID, $oneDay)){
						
						
						if($StaffEmployment->AlternateGroup0->alternateGroupID !=99 && !$AlternateDuty){
								$addition -= 1;
						}
						
						if($StaffEmployment->AlternateGroup0->alternateGroupID ==0){
								$addition += 1;
						}
						
					}else{
					if(!$AlternateDuty){
						
						/* if($alternateGroup->groupID == "125"){
							$addition += 0.5;
						} */
						if($AlternateGroup->alternateGroupID == "0"){
							$addition += 0.5;
							
							/* if(in_array($this->staffCode, $specialStaffForAllDay)){ //spiecal staff
								$addition += 0.5;
							} */
							
						}
						if($interval == 0){
							if($startDateType=="AM" && $endDateType == "AM"){
								$addition -= 0.5;
							}
							if($startDateType=="PM" && $endDateType == "PM"){
								$addition -= 0.5;
							}
							if($startDateType=="ALL" && $endDateType == "ALL"){
								$addition -= 1;
							}
							if($startDateType=="AM" && $endDateType == "PM"){
								$addition -= 1;
							}
							
							
							if($AlternateGroup->alternateGroupID == "0"){
							//$addition += 0.5;
							
							if(in_array($this->staffCode, $specialStaffForAllDay)){ //spiecal staff
								$addition += 0.5;
							}
							
						}
							
						}
						
						if($interval >= 1){
							
						if(date('Y-m-d', strtotime($this->endDate)) != $value->format('Y-m-d')){	
							
							if($startDateType=="ALL" && $endDateType == "ALL"){
								$addition -= 1;
							}
						if($startDateType=="AM" && $endDateType == "AM"){
							$addition -= 1;
						}
						if($startDateType=="PM" && $endDateType == "PM"){
							$addition -= 1;
						}
						if($startDateType=="ALL" && $endDateType == "AM"){
							$addition -= 1;
						}
						if($startDateType=="ALL" && $endDateType == "PM"){
							$addition -= 1;
						}
						if($startDateType=="AM" && $endDateType == "ALL"){
							$addition -= 1;
						}
						if($startDateType=="PM" && $endDateType == "ALL"){
							$addition -= 1;
						}
						if($startDateType=="AM" && $endDateType == "PM"){
							$addition -= 1;
						}
						}else{
							$addition -= 0.5;
						}
						}
					}else{
						
						if($interval == 0){
				
				if($startDateType=="PM" && $endDateType == "PM"){
					$addition += 0;
				}
				if($startDateType=="ALL" && $endDateType == "ALL"){
					$addition -= 0.5;
				}
				if($startDateType=="AM" && $endDateType == "PM"){
					$addition -= 0.5;
				}
				
				}
				
				if($interval >= 1){
				if($startDateType=="ALL" && $endDateType == "ALL"){
					$addition -= 0.5;
				}
				if($startDateType=="AM" && $endDateType == "AM"){
					$addition -= 0.5;
				}
				if($startDateType=="AM" && $endDateType == "PM"){
					$addition -= 0.5;
				}
				if($startDateType=="PM" && $endDateType == "PM"){
					$addition -= 0.5;
				}
				/* if($startDateType=="PM" && $endDateType == "AM"){
					$addition -= 0.5;
				} */
				if($startDateType=="ALL" && $endDateType == "PM"){
					$addition -= 0.5;
				}
				if($startDateType=="AM" && $endDateType == "ALL"){
					$addition -= 0.5;
				}
				
				
				
				if($startDateType=="PM" && $endDateType == "ALL"){
					$addition -= 0.5;
				}
				
				}
						
						
						
						
					}
					}
				}
				}
			}
			
		}
		

		}else{
			$days = "0";
		}

		
		}
		$days = $interval+$addition;
		
		return $days;
	}
}
