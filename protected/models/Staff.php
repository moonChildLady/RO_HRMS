<?php

/**
 * This is the model class for table "Staff".
 *
 * The followings are the available columns in table 'Staff':
 * @property integer $id
 * @property string $staffCode
 * @property string $surName
 * @property string $givenName
 * @property string $nickName
 * @property string $chineseName
 * @property string $email
 * @property string $gender
 *
 * The followings are the available model relations:
 * @property StaffEmployment[] $staffEmployments
 */
class Staff extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Staff';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('staffCode, surName, givenName', 'required'),
			array('staffCode','unique', 'message'=>'This Staff Code already exists.'),
			array('staffCode, surName, nickName, HKID, mobilePhone', 'length', 'max'=>100),
			array('givenName, chineseName, email', 'length', 'max'=>200),
			array('gender', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, staffCode, surName, givenName, nickName, chineseName, email, gender, dob, HKID, mobilePhone, whiteCard', 'safe'),
			array('id, staffCode, surName, givenName, nickName, chineseName, email, gender, whiteCard', 'safe', 'on'=>'search'),
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
            'approvals' => array(self::HAS_MANY, 'Approval', 'staffCode'),
            'approvals1' => array(self::HAS_MANY, 'Approval', 'immediateSupervisor'),
            'approvals2' => array(self::HAS_MANY, 'Approval', 'departmentHead'),
            'approvals3' => array(self::HAS_MANY, 'Approval', 'FinalApprover'),
            'approvalLogs' => array(self::HAS_MANY, 'ApprovalLog', 'approver'),
            'approvers' => array(self::HAS_MANY, 'Approvers', 'staffCode'),
            'approvers1' => array(self::HAS_MANY, 'Approvers', 'approver'),
            'attendanceRecords' => array(self::HAS_MANY, 'AttendanceRecords', 'staffCode'),
            'deptHeads' => array(self::HAS_MANY, 'DeptHead', 'staffCode'),
            'leaveApplications' => array(self::HAS_MANY, 'LeaveApplication', 'staffCode'),
            'leaveApplications1' => array(self::HAS_MANY, 'LeaveApplication', 'createdBy'),
            'leaveApplications2' => array(self::HAS_MANY, 'LeaveApplication', 'approvedBy'),
            'leaveBalances' => array(self::HAS_MANY, 'LeaveBalance', 'staffCode'),
            'staffDuties' => array(self::HAS_MANY, 'StaffDuty', 'staffCode'),
            'staffEmployments' => array(self::BELONGS_TO, 'StaffEmployment', array('staffCode'=>'staffCode')),
            'CWRStaff0' => array(self::BELONGS_TO, 'CWRStaff', array('staffCode'=>'staffCode')),
            'users' => array(self::HAS_MANY, 'Users', 'staffCode'),
            'alternateGroups' => array(self::HAS_MANY, 'AlternateGroup', 'staffCode'),
            'timeSlotStaff' => array(self::HAS_MANY, 'TimeSlotStaff', 'staffCode'),
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
			'surName' => 'Sur Name',
			'givenName' => 'Given Name',
			'nickName' => 'Preferred name',
			'chineseName' => 'Chinese Name',
			'email' => 'Email',
			'gender' => 'Gender',
			'Fullname' => 'Fullname',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('staffCode',$this->staffCode,true);
		$criteria->compare('surName',$this->surName,true);
		$criteria->compare('givenName',$this->givenName,true);
		$criteria->compare('nickName',$this->nickName,true);
		$criteria->compare('chineseName',$this->chineseName,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('whiteCard',$this->whiteCard,true);
		$criteria->compare('concat(staffCode, surName, givenName)',$this->FullnamewithStaffCode,true);
		//FullnamewithStaffCode
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Staff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFullname(){
	
		/* $nickName = (!empty($this->nickName))?", ".$this->nickName:"";	
		return $this->surName." ".$this->givenName.$nickName; */
		
		return $this->surName." ".$this->givenName;
	}
	
	public function getFullnamewithStaffCode(){
		$nickName = (!empty($this->nickName))?", ".$this->nickName:"";

		$name = $this->surName." ".$this->givenName;
		$employmentStatus = "(current)";
		if($this->staffEmployments){
			if($this->staffEmployments->endDate !="" && date('Y-m-d H:i:s') >= $this->staffEmployments->endDate ){
				$employmentStatus = "(terminated)";
			}else{
				$employmentStatus = "(current)";
			}
		}else{
			$employmentStatus = "(please check)";
		}
		
		//return $name." ".$employmentStatus;
		
		return $this->staffCode." ".$this->surName." ".$this->givenName." ".$nickName." ".$employmentStatus;
	}
}
