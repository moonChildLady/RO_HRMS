<?php

class LeaveApplicationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
			'rights'
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	/* public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','getAttachment'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','view','create','update','getAttachment'),
				'users'=>array('@'),
				//'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} */
	
	/* public function allowedActions(){
	
		return 'admin,delete,view,create,update,getAttachment';
	} */
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewApproval($id)
	{
		
		
		
		$criteria = new CDbCriteria;
		$staffCode = Yii::app()->user->staffCode;
		
		
		
		
		
		$leaveModel = $this->loadModel($id);
		
				//$params = array('Approvers'=>$Approvers->approver);
		
		if(Yii::app()->user->checkAccess('eLeave Approver') && !Yii::app()->user->checkAccess('admin')){
			
			
		$ApproversCriteria = new CDbCriteria;
		$ApproversCriteria->addCondition("approver = :approver");
		//$ApproversCriteria->addCondition("staffCode = :staffCode");
		$ApproversCriteria->params = array(
			':approver'=>$staffCode,
			//':staffCode'=>$leaveModel->staffCode,
			);
		
		
		$Approvers = Approvers::model()->findAll($ApproversCriteria);
			
		$staffs = array();
		foreach($Approvers as $i=>$Approver){
			array_push($staffs, $Approver->staffCode);
		}
			
			$criteria->addCondition("id = :id");
			$criteria->params = array(
				':id'=>$id,
			);

			$criteria->addInCondition("staffCode", $staffs);
						
			
		}
		
		
		if(Yii::app()->user->checkAccess('Leave application') && !Yii::app()->user->checkAccess('admin')){
		$criteria->addCondition("id = :id");
		$criteria->params = array(
			':id'=>$id,
		);
		
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params[":staffCode"] = $staffCode;
		
		}
		if(Yii::app()->user->checkAccess('eLeave Admin') || Yii::app()->user->checkAccess('eLeave Admin 2')){
			$criteria = new CDbCriteria;
			$criteria->addCondition("id = :id");
			$criteria->params = array(
			':id'=>$id,
			);
		}
		
		
		$model = LeaveApplication::model()->find($criteria);
		
		
		
		if(!$model){
			throw new CHttpException(404,'The requested page does not exist.');
		}else{
			$model->scenario = "approval";
		}
		//$this->sentLeaveMail($model);
		$approvalLog = $this->loadApprovalLog($id);
		
		$checkApprovalLogExist = $this->checkApprovalLogExist($model->id);
		
		$approvers = $this->loadApprovalers($model->staffCode, $model->createDate);
		
		if(isset($_POST['LeaveApplication']) && Yii::app()->user->checkAccess('eLeave Approver'))
		{
			$model->attributes=$_POST['LeaveApplication'];
			
			if($model->save()){
				$ApprovalLog = new ApprovalLog;
				$ApprovalLog->approver = Yii::app()->user->getState('staffCode');
				$ApprovalLog->leaveApplicationID = $model->id;
				$ApprovalLog->status = $_POST['LeaveApplication']['ApproveDropdown'];
				$ApprovalLog->save();
				
				
				if($this->isApproved($model->id, $model->staffCode)){
					$this->sentLeaveMail($model);
				}
				
				if($ApprovalLog->status == "REJECTED"){
					$this->sentRejectedMail($model);
				}
				
				
				Yii::app()->user->setFlash('success', "Data Saved Successfully!");
			}else{
				Yii::app()->user->setFlash('error', "Data saved Failed!");
			}
			
			$this->redirect(array('LeaveApplication/ViewApproval','id'=>$model->id));
		}
		
		$this->render('viewApproval',array(
			'model'=>$model,
			'approvalLog'=>$approvalLog,
			'approvers'=>$approvers,
			'checkApprovalLogExist'=>$checkApprovalLogExist
		));
		
		
		
		
	}
	
	public function actionView($id){
		
		
		$criteria = new CDbCriteria;
		$staffCode = Yii::app()->user->staffCode;
		$criteria->addCondition("id = :id");
		$criteria->params = array(
			':id'=>$id,
		);
		
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params[":staffCode"] = $staffCode;
		$model = LeaveApplication::model()->find($criteria);
		$approvalLog = $this->loadApprovalLog($id);
		
		$checkApprovalLogExist = $this->checkApprovalLogExist($model->id);
		$approvers = $this->loadApprovalers($model->staffCode, $model->createDate);
		$this->render('view',array(
			'model'=>$model,
			'approvalLog'=>$approvalLog,
			'approvers'=>$approvers,
			'checkApprovalLogExist'=>$checkApprovalLogExist
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		//throw new CHttpException(500,'The application is closed.');
		$model=new LeaveApplication;
		$model->scenario = "create";
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['LeaveApplication']))
		{
			$model->attributes=$_POST['LeaveApplication'];
			
			$model->createdBy = Yii::app()->user->getState('staffCode');
			$model->attachment = CUploadedFile::getInstance($model,'attachment');
			$filePath = "/var/www/attachments/".uniqid().".".strtolower(pathinfo($model->attachment, PATHINFO_EXTENSION));
			if($model->save()){
				
				$model->scenario = "create";
				
				
				if(date('Y', strtotime($model->startDate)) >=2020 ){
					$LeaveApplicationRef = new LeaveApplicationRef;
					$LeaveApplicationRef->applicationID = $model->id;
					$LeaveApplicationRef->save();
					
					$ref = date('Y', strtotime($model->startDate)).($LeaveApplicationRef->id+10000);
				}else{
					$ref = date('Y', strtotime($model->startDate)).($model->id+10000);
				}
				
				$model->refNo = $ref;
				$model->save();
				
				if($model->attachment && $model->attachment->saveAs($filePath)){
					$AttachmentsModel = new Attachments;
					$AttachmentsModel->fileLocation = $filePath;
					
					if($AttachmentsModel->save()){
						$model->attachmentID = $AttachmentsModel->id;
						$model->save();
					}
				}
				
				
				if($model->reasonID == 66){
					$this->sentSickLeaveEmail($model);
				}
				
				if($model->reasonID == 66 && $model->attachmentID == ""){
				}else{
				$Approvalers = $this->loadApprovalers($model->staffCode, $model->startDate);
				if($Approvalers){
				foreach($Approvalers as $i=>$Approvaler){

				$approvalLog = new ApprovalLog;
				$approvalLog->leaveApplicationID = $model->id;
				$approvalLog->approver = $Approvaler->approver;
				$approvalLog->status = "APPROVED";
				$approvalLog->save();
				}
				}else{
					$approvalLog = new ApprovalLog;
					$approvalLog->leaveApplicationID = $model->id;
					$approvalLog->approver = '242';
					$approvalLog->status = "APPROVED";
					$approvalLog->save();
				}
				}
				//$this->redirect(array('view','id'=>$model->id));
				$this->redirect(array('LeaveApplication/admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionApplyLeveApplication($id)
	{
		
		
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("CURDATE() between startDate and endDate");
		$criteria->addCondition("id = :id");
		$criteria->params = array(
			":id"=>$id
		);
		$LeaveApplicationApply = LeaveApplicationApply::model()->find($criteria);
		if(!$LeaveApplicationApply){
			throw new CHttpException(500,'The application is closed.');
		}
		
		
		$model=new LeaveApplication;
		$model->checkOverLap();
		$model->checkDateLimit();
		$model->scenario = "createbystaff";
		
		
		
			
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		$criteria1 = new CDbCriteria;
		//$criteria->with = array("staffCodeEmploy");
		$criteria1->addCondition("staffCode = :staffCode");
		$criteria1->params = array(
			':staffCode'=>Yii::app()->user->getState('staffCode'),
		);
		
		$modelUser = Users::model()->find($criteria1);
		
		if(isset($_POST['LeaveApplication']))
		{
			$model->attributes=$_POST['LeaveApplication'];
			
			$model->createdBy = Yii::app()->user->getState('staffCode');
			$model->staffCode = Yii::app()->user->getState('staffCode');
			$model->attachment = CUploadedFile::getInstance($model,'attachment');
			$filePath = "/var/www/attachments/".uniqid().".".strtolower(pathinfo($model->attachment, PATHINFO_EXTENSION));
			
			if($model->save()){
				//$newModel = $this->loadModel($model->id);
				//$model->scenario = "createbystaff";
				if(date('Y', strtotime($model->startDate)) >=2020 ){
					$LeaveApplicationRef = new LeaveApplicationRef;
					$LeaveApplicationRef->applicationID = $model->id;
					$LeaveApplicationRef->save();
					
					$ref = date('Y', strtotime($model->startDate)).($LeaveApplicationRef->id+10000);
				}else{
					$ref = date('Y').($model->id+10000);
				}
				
				$model->refNo = $ref;
				$model->save();
				if($model->attachment && $model->attachment->saveAs($filePath)){
					$AttachmentsModel = new Attachments;
					$AttachmentsModel->fileLocation = $filePath;
					
					if($AttachmentsModel->save()){
						$model->attachmentID = $AttachmentsModel->id;
						$model->save();
					}
				}
				
				$this->sentComfirmation($model);
				
				if($model->reasonID == 66){
					$this->sentSickLeaveEmail($model);
				}
				
				Yii::app()->user->setFlash('success', "Data Saved Successfully!");
				$this->redirect(array('view','id'=>$model->id));
			}else{
				Yii::app()->user->setFlash('error', "Data saved Failed!");
				print_r($model->getErrors());
				exit;
			}
			
		}
		
		$this->render('applyleave',array(
			'model'=>$model,
			'modelUser'=>$modelUser,
			'LeaveApplicationApply'=>$LeaveApplicationApply,
		));	
			
	}
	
	
	
	public function actionCreatebystaff()
	{
		//if(!Yii::app()->user->checkAccess('admin')){
		/* if(!Yii::app()->user->getState('staffCode')=='9999999'){
			throw new CHttpException(500,'The application is closed.');
		} */
		$type = Yii::app()->request->getParam('type', null);
		$month = Yii::app()->request->getParam('month', 1);
		$model=new LeaveApplication;
		$model->checkOverLap();
		$model->checkDateLimit();
		if($type=="128"){
			$model->scenario = "createbystaff";
		}
		if($type=="129"){
			$model->scenario = "createbystaff";
		}
		if($type==null){
		$model->scenario = "createbystaff";
		}
		if($type=="130"){
			$model->scenario = "birthdayleave";
		}
		
		
		
			
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
		$criteria1 = new CDbCriteria;
		//$criteria->with = array("staffCodeEmploy");
		$criteria1->addCondition("staffCode = :staffCode");
		$criteria1->params = array(
			':staffCode'=>Yii::app()->user->getState('staffCode'),
		);
		
		$modelUser = Users::model()->find($criteria1);
		
		if(isset($_POST['LeaveApplication']))
		{
			$model->attributes=$_POST['LeaveApplication'];
			if($type=="130"){
				$model->endDate = $_POST['LeaveApplication']['startDate'];
				$model->endDateType = $_POST['LeaveApplication']['startDateType'];
			}
			$model->createdBy = Yii::app()->user->getState('staffCode');
			$model->staffCode = Yii::app()->user->getState('staffCode');
			$model->attachment = CUploadedFile::getInstance($model,'attachment');
			$filePath = "/var/www/attachments/".uniqid().".".strtolower(pathinfo($model->attachment, PATHINFO_EXTENSION));
			
			if($model->save()){
				//$newModel = $this->loadModel($model->id);
				//$model->scenario = "createbystaff";
				//LeaveApplicationRef
				if(date('Y', strtotime($model->startDate)) >=2020 ){
					$LeaveApplicationRef = new LeaveApplicationRef;
					$LeaveApplicationRef->applicationID = $model->id;
					$LeaveApplicationRef->save();
					
					$ref = date('Y', strtotime($model->startDate)).($LeaveApplicationRef->id+10000);
				}else{
					$ref = date('Y').($model->id+10000);
				}
				
				$model->refNo = $ref;
				$model->save();
				if($model->attachment && $model->attachment->saveAs($filePath)){
					$AttachmentsModel = new Attachments;
					$AttachmentsModel->fileLocation = $filePath;
					
					if($AttachmentsModel->save()){
						$model->attachmentID = $AttachmentsModel->id;
						$model->save();
					}
				}
				
				$this->sentComfirmation($model);
				
				if($model->reasonID == 66){
					$this->sentSickLeaveEmail($model);
				}
				
				Yii::app()->user->setFlash('success', "Data Saved Successfully!");
				$this->redirect(array('view','id'=>$model->id));
			}else{
				Yii::app()->user->setFlash('error', "Data saved Failed!");
				print_r($model->getErrors());
				exit;
			}
			
		}
		
		if($month<9){
		
		$this->render('createbystaff',array(
			'model'=>$model,
			'modelUser'=>$modelUser,
		));
		}else{
			$this->render('createbystaff2',array(
			'model'=>$model,
			'modelUser'=>$modelUser,
		));
		}	
			
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	 
	public function actionUpdateOSD($id){
		$type = Yii::app()->request->getParam('type', null);
		if(!Yii::app()->user->checkAccess('eLeave OSD')){
			throw new CHttpException(403,'Sorry, you cannot update in this moment!');
		}else{
			$model=$this->loadModel($id);
			$model->scenario = "HRStatusupdate";
		}

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		//HRStatus
		if(isset($_POST['LeaveApplication']))
		{
			$model->attributes=$_POST['LeaveApplication'];
			
			if($model->save()){
				Yii::app()->user->setFlash('success', "<strong>Success!</strong> Update Successfully.");
				$this->redirect(array('updateOSD','id'=>$model->id));
			}
			
		}
		
		$this->render('updateOSD',array(
			'model'=>$model,
			//'modelUser'=>$modelUser,
		));
	}
	
	public function actionUpdate($id)
	{
		$type = Yii::app()->request->getParam('type', null);
		if($this->checkApprovalLogExist($id) && !Yii::app()->user->checkAccess('admin')){
			throw new CHttpException(403,'Sorry, you cannot update in this moment!');
		}else{
			$model=$this->loadModel($id);
		}

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		$criteria1 = new CDbCriteria;
		//$criteria->with = array("staffCodeEmploy");
		$criteria1->addCondition("staffCode = :staffCode");
		$criteria1->params = array(
			':staffCode'=>Yii::app()->user->getState('staffCode'),
		);
		
		$modelUser = Users::model()->find($criteria1);
		if(isset($_POST['LeaveApplication']))
		{
			$model->attributes=$_POST['LeaveApplication'];
			if($type=="130"){
				$model->endDate = $_POST['LeaveApplication']['startDate'];
				$model->endDateType = $_POST['LeaveApplication']['startDateType'];
			}
			$model->attachment = CUploadedFile::getInstance($model,'attachment');
			$filePath = "/var/www/attachments/".uniqid().".".strtolower(pathinfo($model->attachment, PATHINFO_EXTENSION));
			if($model->save()){
				if($model->attachment && $model->attachment->saveAs($filePath)){
					$AttachmentsModel = new Attachments;
					$AttachmentsModel->fileLocation = $filePath;
					
					if($AttachmentsModel->save()){
						$model->attachmentID = $AttachmentsModel->id;
						$model->save();
					}
				}
					
			$this->sentComfirmation($model, 'update');	
			}
			if(Yii::app()->user->checkAccess('eLeave Admin') || Yii::app()->user->checkAccess('admin') ){
				$this->redirect(array('ViewApproval','id'=>$model->id));
			}else{
				$this->redirect(array('view','id'=>$model->id));
			}
			//$this->redirect(array('LeaveApplication/admin'));
		}

		$this->render('update',array(
			'model'=>$model,
			'modelUser'=>$modelUser,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
		
		//$this->loadApprovalLog($id)->deleteAll();
		//if(Yii::app()->user->checkAccess("admin")){
		if($this->checkApprovalLogExist($id) && !Yii::app()->user->checkAccess('admin')){
			throw new CHttpException(403,'Sorry, you cannot update in this moment!');
		}else{
			
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("leaveApplicationID = :leaveApplicationID");
		$criteria->params = array(
			':leaveApplicationID'=>$id
		);
		//ApprovalLog::model()->deleteAll($criteria);
		//$this->sentComfirmation($this->loadModel($id), 'delete');	
		//$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->status = 'CANCEL';
		if($model->save()){
			$this->sentComfirmation($this->loadModel($id), 'delete');
		}
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		}
		//}
	}

	/**
	 * Lists all models.
	 */
	/* public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('LeaveApplication');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	} */

	/**
	 * Manages all models.
	 */
	 
	
	
	public function actionAdmin()
	{
		//echo Yii::app()->user->name;
		//var_dump(Yii::app()->user);
		$model=new LeaveApplication('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LeaveApplication']))
			$model->attributes=$_GET['LeaveApplication'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function getLeaveApplication($staffCode, $date){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("status = :status");
		$criteria->addCondition(":date between startDate and endDate");
		$criteria->params = array(
			':staffCode'=>$staffCode,
			':status'=>'ACTIVE',
			':date'=>$date
		);
		$LeaveApplication = LeaveApplication::model()->findAll($criteria);
				
		return $LeaveApplication;
	}
	
	public function getWeekType($staffCode, $date){
		
		
		$Week = "SW";
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			
			':staffCode'=>$staffCode
			
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		$year = date('Y', strtotime($date));
		
		$criteria4 = new CDbCriteria;
		$criteria4->addCondition("staffCode = :staffCode");
		$criteria4->addCondition("currentYear = :currentYear");
		$criteria4->params = array(
			':staffCode'=>$staffCode,
			':currentYear'=>$year,
			
		);
		$alternateGroup = AlternateGroup::model()->find($criteria4);
		unset($criteria4);
		
		if($alternateGroup){
		
				if(date('N', strtotime($date) == 6)){
				
				
				/* if($StaffEmployment->AlternateGroup0->alternateGroupID == "3"){
					$addition += 0.5;
				} */
				
					$criteria1 = new CDbCriteria;
					$criteria1->addCondition("dutyDate = :dutyDate");
					$criteria1->addCondition("groupID = :groupID");
					//$criteria1->addCondition("status = :status");
					$criteria1->params = array(
						':dutyDate'=>$date,
						':groupID'=>$StaffEmployment->AlternateGroup0->alternateGroupID,
						//':status'=>'YES',
					);
					$AlternateDuty = AlternateDuty::model()->find($criteria1);
					
					if($AlternateDuty){
						$Week = "LW";
					}
					
					if($alternateGroup->alternateGroupID==0){
						$Week = "LW";
					}
					
				}
		}else{
			$Week = "Not set";
		}
		
		
		return $Week;
	}
	/* public function getLeaveBalance($staffCode, $date){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition('DATE_FORMAT(balanceDate, "%Y") = :balanceDate');
		$criteria->params = array(
			
			//':endDate'=>$endDate,
			':staffCode'=>$staffCode,
			':balanceDate'=>date('Y', strtotime($date)),
			
		);
		//$criteria-
		$leaveBalance = LeaveBalance::model()->find($criteria);
		
		return $leaveBalance->balance;
	} */
	public function getTotalAL($staffCode){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			
			':staffCode'=>$staffCode
			
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		$da1 = new DateTime();
		$da2 = new DateTime($StaffEmployment->startDate);
		$diffY = $da2->diff($da1);
		//echo $diff->y;
		if($StaffEmployment->Basis==62){
			if($diffY->y<=2){
				$ALtotal=7;
			}else{
				$ALtotal=7+($diffY->y-2);
			}
		}else{
			$ALtotal = 14;
		}
		
		return $ALtotal;
	}
	
	public function getHoliday($staffCode, $date){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			
			':staffCode'=>$staffCode
			
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		$year = date('Y', strtotime($date));
		
		$criteria4 = new CDbCriteria;
		$criteria4->addCondition("staffCode = :staffCode");
		$criteria4->params = array(
			':staffCode'=>$staffCode
		);
		$alternateGroup = AlternateGroup::model()->find($criteria4);
		unset($criteria4);
		
		if($alternateGroup){
		$criteria4 = new CDbCriteria;
		$criteria4->addCondition("groupID = :groupID");
		$criteria4->params = array(
			':groupID'=>$alternateGroup->groupID
		);
		$StaffGroup = StaffGroup::model()->find($criteria4);
		
		$criteria1 = new CDbCriteria;
		$criteria1->with = array('holidays');
		$criteria1->addCondition("holidays.eventDate = :eventDate");
		$criteria1->addCondition("groupName = :groupName");
		$criteria1->params = array(
			':eventDate'=>$date,
			//':groupID'=>$StaffEmployment->Basis,
			':groupName'=>$StaffGroup->groupName,
			//':staffCode'=>Yii::app()->user->getState('staffCode')
			
		);
		//$criteria1->group = 'eventDate';
		$isholiday = HolidaysGroup::model()->find($criteria1);
		}else{
			$isholiday = false;
		}
		return $isholiday;
	}
	
	public function actionExportData(){
		
		
		if($_FILES){
		ob_clean();
			Yii::import('ext.phpexcel.XPHPExcel');
			$objPHPExcel_ = XPHPExcel::createPHPExcel();
			$file = $_FILES['xlsfile']["tmp_name"];
			$name = $_FILES['xlsfile']['name'];
			$inputFileType = PHPExcel_IOFactory::identify($file);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			
			$objPHPExcel = $objReader->load($file);
			
			
			$objPHPExcel->createSheet(1);
			$objPHPExcel->getSheet(1)->setTitle('new');
			$newSheet = $objPHPExcel->setActiveSheetIndex(1);
			
			
			$sheet = $objPHPExcel->setActiveSheetIndex(0);
			$highestColumn = $sheet->getHighestColumn();
			$highestRow = $sheet->getHighestRow();
			
			$month1 = preg_replace("/[^0-9-]/", "", $sheet->getCellByColumnAndRow(0,3)->getValue());
			
			/* foreach ($sheet->getMergeCells() as $cells) {
				//if ($cell->isInRange($cells)) {
					//echo 'Cell is merged!';
					var_dump($cells);
					//break;
				//	}
			} */
			//echo preg_replace("/[^0-9-]/", "", $sheet->getCellByColumnAndRow(0,3)->getValue());
			
			//$sheet->setCellValueByColumnAndRow(5,7, '123');
			$sheet->setCellValue($sheet->getHighestColumn()."6", "AL Taken");
			$sheet->setCellValueByColumnAndRow(PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn()), 6, "OT");
			$sheet->setCellValueByColumnAndRow(PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn()), 6, "SL BAL");
			$albalcol = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
			$sheet->setCellValueByColumnAndRow(($albalcol),6, 'AL BAL');
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();
			$highestColumn++;
			/* for ($column = 'A'; $column != $highestColumn; $column++) {
				for ($row = 1; $row < $highestRow + 1; $row++) {
					$sheet->insertNewRowBefore($row + 1, 1);
				}
			} */
			$countStrpos = 0;
			$newSheetData = array();
			$dateRange = array();
			for ($column = 'A'; $column != $highestColumn; $column++) {
				//$dataset[] = $this->objPHPExcel->setActiveSheetIndex(0)->getCell($column . $row)->getValue();
				
				$header = $sheet->getCell($column."6")->getValue();
				
				
				
				if(strpos(trim($header), '/') !== false){
					$day = "01";
					$getMonthFromHeader = explode("-",$month1)[0]."-".sprintf('%02d',explode("/",$header)[0]);
					if($getMonthFromHeader!=$month1){
						$countStrpos++;
					}
					
				}else{
					$day = substr($header,0, 2);
				}
				$headerMonth = strtotime($month1);
				$month = date("Y-m", strtotime("+".$countStrpos." month", $headerMonth));
				
				if(is_numeric($day)){
					$dateRange[] =  $month."-".$day;
					//echo $day;
					//setCellValue('A' . (string)(i + 1)
					
					for ($row = 1; $row < $highestRow + 1; $row++) {
						$value = $sheet->getCell($column . $row)->getValue();
						if($row >=7){
						$staffCode = trim($sheet->getCell("A".$row)->getValue());
						$staffCode1 = explode(PHP_EOL,$staffCode);
						$countSL = 0;
						if(isset($staffCode1[0]) && is_numeric($staffCode1[0])){
						$hasProblem = false;
						
						
						
						//$newSheet->setCellValue($column.$row, $staffCode1[0]);
						//$sheet->setCellValue($column.$row, $leaves.$value);
						
						
						
						
						
						$value1 = preg_grep('/^(2[0-3]|[01][0-9]):[0-5][0-9](2[0-3]|[01][0-9]):[0-5][0-9]$/', explode("\n", str_replace("\n",'', trim($value))));
						
						$hasTime = preg_grep('/(2[0-3]|[01][0-9]):[0-5][0-9]$/', explode("\n", str_replace("\n",'', trim($value))));
						
						if(count($value1) > 0){
							
						}else{
							$hasProblem = true;
							
						}
						
						if($value==""){
							$hasProblem = false;
						}
						
						$totalAL = $this->getTotalAL($staffCode1[0]);
							
							
							//echo $staffCode1[0]."|";
							//echo $value."|";
							//echo $month."-".$day."<br>";
							//if($value == ""){
							
							$leave = array();
							foreach($this->getLeaveApplication($staffCode1[0], $month."-".$day) as $i=>$model){
								switch($model->reasonID){
									case 67:
										$leave[] = "AL";
										break;
									case 110:
										$leave[] = "NP";
										break;
									case 131:
										$leave[] = "CL";
										break;
									case 84:
										$leave[] = "ML";
										break;
									case 110:
										$leave[] = "No Pay";
										break;
									case 85:
										$leave[] = "PL";
										break;
									case 66:
										$leave[] = "SL";
										$countSL++;
										break;
									case 130:
										$leave[] = "BL";
										break;
									case 128:
										$leave[] = "LSL";
										break;
									case 83:
										$leave[] = "EL";
										break;
									/* case 66:
										if($this->checkProbation($staffCode1[0], $month."-".$day)){
											$leave[] = "SL*";
										}else{
											$leave[] = "SL^";
										}
										break; */
									default:
										$leave[] = "L";
									
								}
								/* if($model->reasonID==67){
									$leave[] = "AL";
								}
								if($model->reasonID==110){
									$leave[] = "NP";
								}
								if($model->reasonID==66){
									if($this->checkProbation($staffCode1[0], $month."-".$day)){
										$leave[] = "SL*";
									}else{
										$leave[] = "SL^";
									}
								} */
								//$leave[] = "L";
							}

		  					$leaves = "";
							$leaves .= implode(",",$leave)."\r\n";
							
							//$sheet->setCellValue($column.$row, implode(",",$leave)."\r\n".$value);
							
							
							
							/* }else{
								//$sheet->setCellValue($column.$row, $value);
							} */
							
							if($this->getHoliday($staffCode1[0], $month."-".$day)){
								
								$leaves .= "H\r\n";
								$hasProblem = false;
								//$sheet->setCellValue($column.$row, $value."H");
							}
							
							if(date('N', strtotime($month."-".$day)) == 6){
								$leaves .= $this->getWeekType($staffCode1[0], $month."-".$day)."\r\n";
								
								//if($this->getWeekType($staffCode1[0], $month."-".$day){
									//$sheet->setCellValue($column.$row, $sheet->getCell($column.$row)->getValue()."\r\n".$this->getWeekType($staffCode1[0], $month."-".$day)."\r\n".$value);
								/* }else{
									$sheet->setCellValue($column.$row, $value."*SW");
								} */
								
								
								if($this->getWeekType($staffCode1[0], $month."-".$day)=="SW"){
									if(count($hasTime) > 0){
										$sheet->getStyle($column . $row)->getFill()->getStartColor()->setRGB('FF0000');
									}
								}
								
								if($this->getWeekType($staffCode1[0], $month."-".$day)=="LW"){
									if(count($value1) == 0 && !in_array("AL", $leave)){
										$sheet->getStyle($column . $row)->getFill()->getStartColor()->setRGB('FF0000');
									}
									
									if(count($value1) == 0 && !in_array("SL", $leave)){
										$sheet->getStyle($column . $row)->getFill()->getStartColor()->setRGB('FF0000');
									}
								}
								
								/* if($this->getWeekType($staffCode1[0], $month."-".$day)=="LW" && !in_array("AL", $leave)){
									if(count($value1) == 0){
										$sheet->getStyle($column . $row)->getFill()->getStartColor()->setRGB('FF0000');
									}
								} */
								
								/* if($this->getWeekType($staffCode1[0], $month."-".$day)=="LW" && !in_array("SL", $leave)){
									if(count($value1) > 0){
										$sheet->getStyle($column . $row)->getFill()->getStartColor()->setRGB('FF0000');
									}
								} */
								
							}
							if(date('N', strtotime($month."-".$day)) == 7){
								$leaves .= "H\r\n";
								$hasProblem = false;
							}
							
							
							
							
							if($hasProblem){
								$sheet->getStyle($column . $row)->getFill()->getStartColor()->setRGB('FF0000');
							}
							
							if($hasTime && in_array("AL", $leave)){
								$sheet->getStyle($column . $row)->getFill()->getStartColor()->setRGB('FF0000');
							}
							
							if($hasTime && in_array("SL", $leave)){
								$sheet->getStyle($column . $row)->getFill()->getStartColor()->setRGB('FF0000');
							}
							
							$sheet->setCellValue($column.$row, $value.$leaves);
							
							
							
							//sickleave
							//$sheet->setCellValue($sheet->getHighestColumn().$row, $countSL);
							
							
							$sheet->setCellValueByColumnAndRow((PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn())-4),$row, $this->loadStaffApplicationDeductionPeroid($staffCode1[0], $dateRange[0], end($dateRange)));
							//$sheet->setCellValueByColumnAndRow((PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn())-4),$row, $dateRange[0].end($dateRange));
							
							$sickLeaveData = $this->sickLeaveTotal($staffCode1[0], date('Y-m-d'));
							$balanceSickLeave = $sickLeaveData['entitlement']-$this->loadStaffApplicationDeductionSickLeavePeroid($staffCode1[0], $sickLeaveData['from'], date('Y-', strtotime($month."-".$day)).'12-31');

							
							
							$sheet->setCellValueByColumnAndRow((PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn())-2),$row, $balanceSickLeave);
							
							$lastYear = date('Y', strtotime($month."-".$day))-1;
							$currentYear = date('Y', strtotime($month."-".$day));
							
							
							$remainingapply = $this->loadStaffApplicationDeductionPeroid($staffCode1[0], $currentYear."-01-01", $currentYear."-09-30");
							$remainBalance = $this->loadRemainBalance($staffCode1[0], $lastYear);
							if($remainBalance && $remainBalance->remaining-$remainingapply > 0){
								$getInt = intval(round($remainBalance->remaining-$remainingapply,1));
								$decimal = round($remainBalance->remaining-$remainingapply,1)-$getInt;
							$finalOut = 0;
							if($decimal >= 0.5){
								$finalOut = $getInt+0.5;
							}else{
								$finalOut = $getInt;
							}
								$remainBal = $finalOut;
							}else{
								$remainBal = "0";
							}
							
							$allApplied = $this->getTotalAL($staffCode1[0])-$this->loadStaffApplicationDeduction($staffCode1[0], $currentYear, 'ACTIVE', 'NO');
							$rounded = round($allApplied, 1);
							$getInt = intval($rounded);
							$decimal = $rounded-$getInt;
							$finalOut = 0;
							if($decimal >= 0.5){
								$finalOut = $getInt+0.5;
							}else{
								$finalOut = $getInt;
							}
							//echo $finalOut;
							
							$sheet->setCellValueByColumnAndRow((PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn())-1),$row, $finalOut."+".$remainBal);
							//$albalcolData = PHPExcel_Cell::columnIndexFromString($column);
							//$sheet->setCellValueByColumnAndRow(($albalcolData),$row, '');
							
							
							$newSheetData[$staffCode1[0]] = array(
								$staffCode,
								$staffCode1[0],
								($this->loadStaffApplicationDeductionPeroid($staffCode1[0], $dateRange[0], end($dateRange))==0)?"0":$this->loadStaffApplicationDeductionPeroid($staffCode1[0], $dateRange[0], end($dateRange)),
								//$vlookup,
								
							);
							/*
							$sheet->setCellValueByColumnAndRow(PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn()), 6, "SL BAL");
			$albalcol = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
			$sheet->setCellValueByColumnAndRow(($albalcol),6, 'AL BAL');
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();
							*/
							//=VLOOKUP(A2,Sheet!A:AM,38,0)
							
						}
						
						}
						/* $value = $sheet->getCell($column . $row)->getValue();
						
							
							echo $value."<br>";
						} */
					}
					
					
					
					
				}
			}
			
			$newSheet->setCellValueByColumnAndRow(0, 1, "Code");
			$newSheet->setCellValueByColumnAndRow(1, 1, "Staff Code");
			$newSheet->setCellValueByColumnAndRow(2, 1, "AL Taken");
			$newSheet->setCellValueByColumnAndRow(3, 1, "Working day");
			$newSheet->setCellValueByColumnAndRow(4, 1, "OT");
			
			$newSheet->fromArray($newSheetData, null, "A2");
			for ($column = 'A'; $column != $newSheet->getHighestColumn(); $column++) {
				for ($row = 1; $row < $newSheet->getHighestRow() + 1; $row++) {
					if($row > 1){
						$newSheet->setCellValueByColumnAndRow(3, $row, "VLOOKUP(A".$row.",Sheet!A:".$sheet->getHighestColumn().",".(PHPExcel_Cell::columnIndexFromString($this->searchColumnByName("AL Taken", $sheet))-2).",0)");
						$newSheet->setCellValueByColumnAndRow(4, $row, "VLOOKUP(A".$row.",Sheet!A:".$sheet->getHighestColumn().",".(PHPExcel_Cell::columnIndexFromString($this->searchColumnByName("AL Taken", $sheet))).",0)");
					}
					
				}
			}
			//"=VLOOKUP(A".$row.",Sheet!A:".$sheet->getHighestColumn().",".(PHPExcel_Cell::columnIndexFromString($this->searchColumnByName("AL Taken", $sheet))-2).",0)"
			//$vlookup = "=VLOOKUP(A2,Sheet!A:".$sheet->getHighestColumn().",".(PHPExcel_Cell::columnIndexFromString($this->searchColumnByName("AL Taken", $sheet))-2).",0)";
			
			
			//exit;
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$filename = __FUNCTION__ ."_".date('YmdHis').".xls";
			header('Content-Type: application/vnd.ms-excel');
			 //header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			//$objWriter->setPreCalculateFormulas(true);
			$objWriter->save('php://output');
			Yii::app()->end();
		
			
			
		}
		
		$this->render('upload',array(
		));
		
	}
	
	public function searchColumnByName($subject, $sheet){
		//$grade_sheet = $sheet->setActiveSheetIndex(1);
		$sub = "";
		for ($column = 'A'; $column != $sheet->getHighestColumn(); $column++) {
			$_subject = trim($sheet->getCell($column ."6")->getValue());
			if(strtolower($_subject) == strtolower($subject)){
				$sub = $column;
				break;
			}else{
				//throw new CHttpException(404,'Error');
				
			}
		}
		
		return $sub;
	}
	
	public function actionListview()
	{
		
		//if(!Yii::app()->user->checkAccess('admin')){
		if(!Yii::app()->user->getState('staffCode')=='9999999'){
			throw new CHttpException(500,'The application is closed.');
		}
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('CURDATE() between startDate and endDate');
		$criteria->order = "applyStartDate ASC";
		$LeaveApplicationApply = LeaveApplicationApply::model()->findAll($criteria);
		
		//echo Yii::app()->user->name;
		//var_dump(Yii::app()->user);
		$model=new LeaveApplication('search');
		$model->unsetAttributes();  // clear any default values
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		//$criteria->addCondition('DATE_FORMAT(balanceDate, "%Y") = :balanceDate');
		$criteria->params = array(
			
			//':endDate'=>$endDate,
			':staffCode'=>Yii::app()->user->getState('staffCode'),
			//':balanceDate'=>date('Y'),
			
		);
		//$criteria-
		$leaveBalance = LeaveBalance::model()->findAll($criteria);
		unset($criteria);
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>Yii::app()->user->getState('staffCode')
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		if(isset($_GET['LeaveApplication']))
			$model->attributes=$_GET['LeaveApplication'];

		$this->render('listview2',array(
			'model'=>$model,
			'leaveBalance'=>$leaveBalance,
			'StaffEmployment'=>$StaffEmployment,
			'LeaveApplicationApply'=>$LeaveApplicationApply,
		));
		
	}
	
	public function actionListview2()
	{
		
		//if(!Yii::app()->user->checkAccess('admin')){
		if(!Yii::app()->user->getState('staffCode')=='9999999'){
			throw new CHttpException(500,'The application is closed.');
		}
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('CURDATE() between startDate and endDate');
		$criteria->order = "applyStartDate ASC";
		$LeaveApplicationApply = LeaveApplicationApply::model()->findAll($criteria);
		
		//echo Yii::app()->user->name;
		//var_dump(Yii::app()->user);
		$model=new LeaveApplication('search');
		$model->unsetAttributes();  // clear any default values
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		//$criteria->addCondition('DATE_FORMAT(balanceDate, "%Y") = :balanceDate');
		$criteria->params = array(
			
			//':endDate'=>$endDate,
			':staffCode'=>Yii::app()->user->getState('staffCode'),
			//':balanceDate'=>date('Y'),
			
		);
		//$criteria-
		$leaveBalance = LeaveBalance::model()->findAll($criteria);
		unset($criteria);
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>Yii::app()->user->getState('staffCode')
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		if(isset($_GET['LeaveApplication']))
			$model->attributes=$_GET['LeaveApplication'];

		$this->render('listview2',array(
			'model'=>$model,
			'leaveBalance'=>$leaveBalance,
			'StaffEmployment'=>$StaffEmployment,
			'LeaveApplicationApply'=>$LeaveApplicationApply,
		));
		
	}
	
	public function actionManageApproval()
	{
		//echo Yii::app()->user->name;
		//var_dump(Yii::app()->user);
		//Yii::log(Yii::app()->user->id);
		
		$model=new LeaveApplication('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LeaveApplication']))
			$model->attributes=$_GET['LeaveApplication'];

		$this->render('manageapproval',array(
			'model'=>$model,
		));
	}
	
	public function actionExportLanding(){
		
		$model=new LeaveApplication;
		$model->scenario = "export";
		 $this->performAjaxValidation($model);
		if(isset($_POST['LeaveApplication']))
		{
			$startDate = $_POST['LeaveApplication']['startDate'];
			$endDate = $_POST['LeaveApplication']['endDate'];
			$staffCode = $_POST['LeaveApplication']['staffCode'];
			ob_end_clean();
			Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator(Yii::app()->params['companyName'])
				->setLastModifiedBy(Yii::app()->params['companyName'])
				->setTitle("Leave records")
				->setSubject("Leave records")
				->setDescription("Leave records")
				->setKeywords("Leave records")
				->setCategory("Leave records");
			
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', "REF")
				->setCellValue('B1', "APPLY DATE")
				->setCellValue('C1', "STAFF NO")
				->setCellValue('D1', "STAFF NAME")
				->setCellValue('E1', "NAME_C")
				->setCellValue('F1', "FM")
				->setCellValue('G1', "TO")
				->setCellValue('H1', "DAY")
				->setCellValue('I1', "STATUS")
				->setCellValue('J1', "TYPE")
				->setCellValue('K1', "STATUS2")
				->setCellValue('L1', "Original Supporting Doc")
				
				->setCellValue('M1', "AL Remaining from 2018")
				->setCellValue('N1', "Balance of 2019");
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			);
			
			
		$objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);			
		$new_sheet = $objPHPExcel->setActiveSheetIndex(0);
		
		$criteria = new CDbCriteria;
		//$criteria->compare('startDate1', $startDate, false);
		//$criteria->compare('endDate', $endDate, false, 'OR');
		$criteria->addCondition("date_format(startDate, '%Y-%m-%d') >= :startDate and date_format(endDate, '%Y-%m-%d') <= :endDate");
		
		//$criteria->addCondition("endDate <= :endDate");
		$criteria->params = array(
			':startDate'=>$startDate,
			':endDate'=>$endDate
		);
		if($staffCode != ""){
			$criteria->addCondition("staffCode = :staffCode");
			$criteria->params['staffCode'] = $staffCode;
		}
		$criteria->order = "startDate ASC";
		$model = LeaveApplication::model()->findAll($criteria);
		//$j=0;
		$bal = $this->getTotalBal($staffCode, $endDate);
		
		
		$remainBalance = $this->loadRemainBalance($staffCode, (date('Y',strtotime($startDate))-1));
	/* if($remainBalance && $remainBalance->remaining > 0){
		$getInt = intval(round($remainBalance->remaining,1));
		$decimal = round($remainBalance->remaining,1)-$getInt;
		$finalOut = 0;
		if($decimal >= 0.5){
			$finalOut = $getInt+0.5;
		}else{
			$finalOut = $getInt;
		}
		
	}else{
		$finalOut = 0;
	}
	
	$remainingapply = $this->loadStaffApplicationDeductionPeroid($staffCode, $startDate, date('Y',strtotime($startDate))."-03-31");
	
	if($remainBalance && $remainBalance->remaining-$remainingapply > 0){
		//$getLastYearBL = round($remainBalance->remaining-$remainingapply,2);
		
		$getInt = intval(round($remainBalance->remaining-$remainingapply,1));
		$decimal = round($remainBalance->remaining-$remainingapply,1)-$getInt;
		$getLastYearBL = 0;
		if($decimal >= 0.5){
			$getLastYearBL = $getInt+0.5;
		}else{
			$getLastYearBL = $getInt;
		}
		
	}else{
		$getLastYearBL = 0;
	} */
		
		
		
		
		
		$durition = 0;
		$remaining0331 = 0;
		$duritionAfter0331 = 0;
		foreach($model as $i=>$data){
			
			
			
			
			$new_sheet->setCellValue("A".($i+2), $data->refNo);
			$new_sheet->setCellValue("B".($i+2), date('Y-m-d', strtotime($data->createDate)));
			$new_sheet->setCellValue("C".($i+2), $data->staffCode0->staffCode);
			$new_sheet->setCellValue("D".($i+2), $data->staffCode0->Fullname);
			$new_sheet->setCellValue("E".($i+2), $data->staffCode0->chineseName);
			$new_sheet->setCellValue("F".($i+2), date('Y-m-d', strtotime($data->startDate))." (".$data->startDateType.")");
			$new_sheet->setCellValue("G".($i+2), date('Y-m-d', strtotime($data->endDate))." (".$data->endDateType.")");
			$new_sheet->setCellValue("H".($i+2), $this->clacDuration($data->id));
			
			if($this->isRejected($data->id, $data->staffCode)){
				$statusText = "REJECTED";
			}else{
				if($this->isApproved($data->id, $data->staffCode)){
					$statusText = "APPROVED";
				}else{
					$statusText = "NOT APPROVED";
				}
			}
			$new_sheet->setCellValue("I".($i+2), $statusText);
			$new_sheet->setCellValue("J".($i+2), $data->reason->content);
			$new_sheet->setCellValue("K".($i+2), $data->status);
			$new_sheet->setCellValue("L".($i+2), $data->HRStatus0->content);
			if($staffCode != ""){
				if($this->isApproved($data->id, $data->staffCode) && $data->reasonID=='67' && date('Y-m-d', strtotime($data->startDate)) > '2018-03-22' && $data->status=='ACTIVE'){
					$durition += $this->clacDuration($data->id);
				}else{
					$durition += 0;
				}
				
			

			if($remainBalance){
			if($data->endDate <= date('Y',strtotime($startDate))."-09-30"){
				$new_sheet->setCellValue("M".($i+2), $remainBalance->remaining-$durition);
			}else{
				$new_sheet->setCellValue("M".($i+2), "-");
				$remaining0331 += $remaining0331;
			}
			
			}else{
				$new_sheet->setCellValue("M".($i+2), "0");
			}
			
			if($remaining0331 < 0){
				$new_sheet->setCellValue("N".($i+2), $bal-$remaining0331);
				
			}else{
				
				if($data->startDate > date('Y',strtotime($startDate))."-09-30"){
					
					
					if($this->isApproved($data->id, $data->staffCode) && $data->reasonID=='67' && date('Y-m-d', strtotime($data->startDate)) > '2018-03-22' && $data->status=='ACTIVE'){
					$duritionAfter0331 += $this->clacDuration($data->id);
				}else{
					$duritionAfter0331 += 0;
				}
					
					
					$new_sheet->setCellValue("N".($i+2), $bal-$duritionAfter0331-$remaining0331);
				}else{
					$new_sheet->setCellValue("N".($i+2), '-');
				}
				//$new_sheet->setCellValue("M".($i+2), $bal-$durition);
			}
			
				//$new_sheet->setCellValue("L".($i+2), $bal);
			}
			//$new_sheet->setCellValueByColumnAndRow(($i+1), $j, $data->createDate);
			//$j++;
		}
		$new_sheet->getColumnDimension("A")->setAutoSize(true);
		$new_sheet->getColumnDimension("B")->setAutoSize(true);
		$new_sheet->getColumnDimension("D")->setAutoSize(true);
		$new_sheet->getColumnDimension("E")->setAutoSize(true);
		$new_sheet->getColumnDimension("F")->setAutoSize(true);
		$new_sheet->getColumnDimension("G")->setAutoSize(true);
		/* foreach ($new_sheet->getRowIterator() as $k=>$row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		
		foreach ($cellIterator as $i=>$cell){
			//$value = $cell->getValue();
			//echo $i.$k." ".$value."<br>";
			//$i = column, $k = row; e.g: 1,8 = B8
			$cell->setValue($new_header);
			
		}
		} */
		
			$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 
				
		$objPHPExcel->getActiveSheet()->setTitle('records');
		//$objPHPExcel->getActiveSheet()->setTitle('Discipline List');
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		
		$margin = 1.3 / 2.54;
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);
		

		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L From '.$startDate.' To '.$endDate.' &C '.Yii::app()->params['companyName'].' &R '.date('Y-m-d H:i:s'));
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1); 
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L Student Preferences');
		
		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&C Page &P of &N &R');
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
 
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			if($staffCode != ""){
				$filename = 'leave_record'.date('YmdHis')."_".$staffCode.".xls";
			}else{
				$filename = 'leave_record'.date('YmdHis').".xls";
			}
		
			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			 //header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			 
			
			ob_start();
			$objWriter->save('php://output');
			Yii::app()->end();
		}
		
		$this->render('exportlanding',array(
			'model'=>$model,
		));
	}
	
	public function actionALHistory(){
		
		$model=new LeaveApplication;
		$model->scenario = "export";
		 $this->performAjaxValidation($model);
		if(isset($_POST['LeaveApplication']))
		{
			$startDate = $_POST['LeaveApplication']['startDate'];
			$endDate = $_POST['LeaveApplication']['endDate'];
			$staffCode = $_POST['LeaveApplication']['staffCode'];
			ob_end_clean();
			
			
		
		$criteria = new CDbCriteria;
		//$criteria->compare('startDate1', $startDate, false);
		//$criteria->compare('endDate', $endDate, false, 'OR');
		$criteria->addCondition("date_format(startDate, '%Y-%m-%d') >= :startDate and date_format(endDate, '%Y-%m-%d') <= :endDate");
		
		//$criteria->addCondition("endDate <= :endDate");
		$criteria->params = array(
			':startDate'=>$startDate,
			':endDate'=>$endDate
		);
		if($staffCode != ""){
			$criteria->addCondition("staffCode = :staffCode");
			$criteria->params['staffCode'] = $staffCode;
		}
		$criteria->order = "startDate ASC";
		$model = LeaveApplication::model()->findAll($criteria);
		//$j=0;
		$bal = $this->getTotalBal($staffCode, $endDate);
		
		$criteria1 = new CDbCriteria;
		//$criteria->with = array("staffCodeEmploy");
		$criteria1->addCondition("staffCode = :staffCode");
		$criteria1->params = array(
			':staffCode'=>$staffCode,
		);
		
		$modelUser = Staff::model()->find($criteria1);
		//$remainBalance = $this->loadRemainBalance($staffCode, (date('Y',strtotime($startDate))-1));
	/* if($remainBalance && $remainBalance->remaining > 0){
		$getInt = intval(round($remainBalance->remaining,1));
		$decimal = round($remainBalance->remaining,1)-$getInt;
		$finalOut = 0;
		if($decimal >= 0.5){
			$finalOut = $getInt+0.5;
		}else{
			$finalOut = $getInt;
		}
		
	}else{
		$finalOut = 0;
	}
	
	$remainingapply = $this->loadStaffApplicationDeductionPeroid($staffCode, $startDate, date('Y',strtotime($startDate))."-03-31");
	
	if($remainBalance && $remainBalance->remaining-$remainingapply > 0){
		//$getLastYearBL = round($remainBalance->remaining-$remainingapply,2);
		
		$getInt = intval(round($remainBalance->remaining-$remainingapply,1));
		$decimal = round($remainBalance->remaining-$remainingapply,1)-$getInt;
		$getLastYearBL = 0;
		if($decimal >= 0.5){
			$getLastYearBL = $getInt+0.5;
		}else{
			$getLastYearBL = $getInt;
		}
		
	}else{
		$getLastYearBL = 0;
	} */
		
		
		
		
		
		$durition = 0;
		$remaining0331 = 0;
		$duritionAfter0331 = 0;
		/* foreach($model as $i=>$data){
			
			
			
			
			$new_sheet->setCellValue("A".($i+2), $data->refNo);
			$new_sheet->setCellValue("B".($i+2), date('Y-m-d', strtotime($data->createDate)));
			$new_sheet->setCellValue("C".($i+2), $data->staffCode0->staffCode);
			$new_sheet->setCellValue("D".($i+2), $data->staffCode0->Fullname);
			$new_sheet->setCellValue("E".($i+2), $data->staffCode0->chineseName);
			$new_sheet->setCellValue("F".($i+2), date('Y-m-d', strtotime($data->startDate))." (".$data->startDateType.")");
			$new_sheet->setCellValue("G".($i+2), date('Y-m-d', strtotime($data->endDate))." (".$data->endDateType.")");
			$new_sheet->setCellValue("H".($i+2), $this->clacDuration($data->id));
			$new_sheet->setCellValue("I".($i+2), ($this->isApproved($data->id, $data->staffCode))?"APPROVED":"NOT APPROVED");
			$new_sheet->setCellValue("J".($i+2), $data->reason->content);
			$new_sheet->setCellValue("K".($i+2), $data->status);
			if($staffCode != ""){
				if($data->reasonID=='67' && date('Y-m-d', strtotime($data->startDate)) > '2018-03-22' && $data->status=='ACTIVE'){
					$durition += $this->clacDuration($data->id);
				}else{
					$durition += 0;
				}
				
			

			if($remainBalance){
			if($data->endDate <= date('Y',strtotime($startDate))."-03-31"){
				$new_sheet->setCellValue("L".($i+2), $remainBalance->remaining-$durition);
			}else{
				$new_sheet->setCellValue("L".($i+2), "-");
				$remaining0331 += $remaining0331;
			}
			
			}else{
				$new_sheet->setCellValue("L".($i+2), "0");
			}
			
			if($remaining0331 < 0){
				$new_sheet->setCellValue("M".($i+2), $bal-$remaining0331);
				
			}else{
				
				if($data->startDate > date('Y',strtotime($startDate))."-03-31"){
					
					
					if($data->reasonID=='67' && date('Y-m-d', strtotime($data->startDate)) > '2018-03-22' && $data->status=='ACTIVE'){
					$duritionAfter0331 += $this->clacDuration($data->id);
				}else{
					$duritionAfter0331 += 0;
				}
					
					
					$new_sheet->setCellValue("M".($i+2), $bal-$duritionAfter0331-$remaining0331);
				}else{
					$new_sheet->setCellValue("M".($i+2), '-');
				}
				
			}
			
				
			}
			
		} */
			$this->render('alhistory',array(
				'model'=>$model,
				'startDate'=>$startDate,
				'endDate'=>$endDate,
				'staffCode'=>$staffCode,
				'modelUser'=>$modelUser,
			));
			Yii::app()->end();
		}
		
		$this->render('exportlanding2',array(
			'model'=>$model,
		));
	}
	
	public function actionExportAll(){
		

			ob_end_clean();
			Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator(Yii::app()->params['companyName'])
				->setLastModifiedBy(Yii::app()->params['companyName'])
				->setTitle("Leave records")
				->setSubject("Leave records")
				->setDescription("Leave records")
				->setKeywords("Leave records")
				->setCategory("Leave records");
			
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', "REF")
				->setCellValue('B1', "APPLY DATE")
				->setCellValue('C1', "STAFF NO")
				->setCellValue('D1', "STAFF NAME")
				->setCellValue('E1', "NAME_C")
				->setCellValue('F1', "FM")
				->setCellValue('G1', "TO")
				->setCellValue('H1', "DAY")
				->setCellValue('I1', "STATUS")
				->setCellValue('J1', "TYPE")
				->setCellValue('K1', "STATUS2");
				
				//->setCellValue('L1', "Balance");
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			);
			
			
		$objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);			
		$new_sheet = $objPHPExcel->setActiveSheetIndex(0);
		
		$criteria = new CDbCriteria;
		//$criteria->compare('startDate1', $startDate, false);
		//$criteria->compare('endDate', $endDate, false, 'OR');
		//$criteria->addCondition("startDate >= :startDate or endDate <= :endDate");
		
		//$criteria->addCondition("endDate <= :endDate");
		/*
$criteria->params = array(
			':startDate'=>$startDate,
			':endDate'=>$endDate
		);
*/
		/*
if($staffCode != ""){
			$criteria->addCondition("staffCode = :staffCode");
			$criteria->params['staffCode'] = $staffCode;
		}
*/
		$criteria->order = "id ASC";
		$model = LeaveApplication::model()->findAll($criteria);
		//$j=0;
		//$bal = $this->getTotalBal($staffCode);
		$durition = 0;
		foreach($model as $i=>$data){
			
			
			
			
			$new_sheet->setCellValue("A".($i+2), $data->refNo);
			$new_sheet->setCellValue("B".($i+2), date('Y-m-d', strtotime($data->createDate)));
			$new_sheet->setCellValue("C".($i+2), $data->staffCode0->staffCode);
			$new_sheet->setCellValue("D".($i+2), $data->staffCode0->Fullname);
			$new_sheet->setCellValue("E".($i+2), $data->staffCode0->chineseName);
			$new_sheet->setCellValue("F".($i+2), date('Y-m-d', strtotime($data->startDate))." (".$data->startDateType.")");
			$new_sheet->setCellValue("G".($i+2), date('Y-m-d', strtotime($data->endDate))." (".$data->endDateType.")");
			$new_sheet->setCellValue("H".($i+2), $this->clacDuration($data->id));
			$new_sheet->setCellValue("I".($i+2), ($this->isApproved($data->id, $data->staffCode))?"APPROVED":"REJECTED");
			$new_sheet->setCellValue("J".($i+2), $data->reason->content);
			$new_sheet->setCellValue("K".($i+2), $data->status);

			//$new_sheet->setCellValueByColumnAndRow(($i+1), $j, $data->createDate);
			//$j++;
		}
		$new_sheet->getColumnDimension("A")->setAutoSize(true);
		$new_sheet->getColumnDimension("B")->setAutoSize(true);
		$new_sheet->getColumnDimension("D")->setAutoSize(true);
		$new_sheet->getColumnDimension("E")->setAutoSize(true);
		$new_sheet->getColumnDimension("F")->setAutoSize(true);
		$new_sheet->getColumnDimension("G")->setAutoSize(true);
		/* foreach ($new_sheet->getRowIterator() as $k=>$row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		
		foreach ($cellIterator as $i=>$cell){
			//$value = $cell->getValue();
			//echo $i.$k." ".$value."<br>";
			//$i = column, $k = row; e.g: 1,8 = B8
			$cell->setValue($new_header);
			
		}
		} */
		
			$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 
				
		$objPHPExcel->getActiveSheet()->setTitle('records');
		//$objPHPExcel->getActiveSheet()->setTitle('Discipline List');
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		
		$margin = 1.3 / 2.54;
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);
		

		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L &C '.Yii::app()->params['companyName'].' &R '.date('Y-m-d H:i:s'));
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1); 
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L Student Preferences');
		
		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&C Page &P of &N &R');
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
 
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$filename = 'all_leave_record'.date('YmdHis').".xls";
		
			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			 //header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			 
			
			ob_start();
			$objWriter->save('php://output');
			Yii::app()->end();
		
	}
	
	public function actionExportLandingBalance(){
		
		//$model=new LeaveApplication;
		//$model->scenario = "export";
		//$this->performAjaxValidation($model);
		//if(isset($_POST['LeaveApplication']))
		//{
		
		if(!Yii::app()->user->checkAccess('hr admin')){
			throw new CHttpException(404,'The requested page does not exist.');
		}
		
			ob_end_clean();
			Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator(Yii::app()->params['companyName'])
				->setLastModifiedBy(Yii::app()->params['companyName'])
				->setTitle("Leave records")
				->setSubject("Leave records")
				->setDescription("Leave records")
				->setKeywords("Leave records")
				->setCategory("Leave records");
			
			
			$objPHPExcel->setActiveSheetIndex(0)
				//->setCellValue('A1', "REF")
				//->setCellValue('B1', "APPLY DATE")
				->setCellValue('A1', "STAFF NO")
				->setCellValue('B1', "STAFF NAME")
				->setCellValue('C1', "NAME_C")
				->setCellValue('D1', "Balance as of today")
				->setCellValue('E1', "AL Taken (Incl not Approved)")
				->setCellValue('F1', "AL Taken (with Approved)")
				->setCellValue('G1', "AL Bal, from 03-22")
				->setCellValue('H1', "entitlement")
				->setCellValue('I1', "basis")
				->setCellValue('J1', "group")
				->setCellValue('K1', "status")
				->setCellValue('P1', date('Y-m-d H:i:s'));
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			);
			
			
		$objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);			
		$new_sheet = $objPHPExcel->setActiveSheetIndex(0);
		$info = array();
		$criteria1 = new CDbCriteria;
		$criteria1->addCondition("date_format(balanceDate,'%Y') = :balanceDate");
		$criteria1->params = array(
			':balanceDate'=>'2018',
		);
		$criteria1->order = "staffCode ASC";
		$LeaveBalanceUser = LeaveBalance::model()->findAll($criteria1);
		
		foreach($LeaveBalanceUser as $j=>$balance){
		
		$duration = 0;	
			$criteria = new CDbCriteria;
		//$criteria->compare('startDate1', $startDate, false);
		//$criteria->compare('endDate', $endDate, false, 'OR');
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("status = :status");
		$criteria->addCondition("date_format(startDate, '%Y') = :starDate");
		//$criteria->addCondition("date_format(startDate, '%Y-%m-%d') <= :starDate");
		
		//$criteria->addCondition("id <= :id");
		$criteria->params = array(
			':staffCode'=>$balance->staffCode,
			':status'=>'ACTIVE',
			':starDate'=>'2018',
		);
		$criteria->order = "startDate ASC";
		$model = LeaveApplication::model()->findAll($criteria);
		
		$bal = 0;
		$alTaken = 0;
		
		
		$criteria2 = new CDbCriteria;
		$criteria2->addCondition("staffCode = :staffCode");
		$criteria2->params = array(
			':staffCode'=>$balance->staffCode,
			//':status'=>'ACTIVE',
			//':id'=>'460',
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria2);
		
		
		
		
		
		if($balance->balanceDate <= '2018-03-22'){
			$begin = new DateTime( '2018-03-22' );
		}else{
			//$begin = new DateTime( $StaffEmployment->startDate );
			$begin = new DateTime( $balance->balanceDate );
		}
		//$begin = (date('Y')=="2018")?new DateTime( '2018-03-22' ):new DateTime( date('Y').'-01-01' );
	//$end = new DateTime(date('Y-m-d'));
	$end = new DateTime('2018-12-31');
	$calcurrentDay = $begin->diff($end);
	
	$da1 = new DateTime();
	$da2 = new DateTime($StaffEmployment->startDate);
	$diffY = $da2->diff($da1);
	//echo $diff->y;
	if($StaffEmployment->Basis==62){
		if($diffY->y<=2){
			$ALtotal=7;
		}else{
			$ALtotal=7+($diffY->y-2);
		}
	}else{
		$ALtotal = 14;
	}
	$entitlement = ($ALtotal/365)*($calcurrentDay->days+1);
	
	
			foreach($model as $i=>$data){
				if($data && $StaffEmployment->AlternateGroup0){
				if($this->isApproved($data->id, $data->staffCode) && $data->reasonID == "67"  && $data->status == "ACTIVE"){
					$bal = $this->getLeaveBalance2($data);
					if($data->startDate > '2018-03-22'){
						$alTaken += $this->clacDuration($data->id);
					}
				}
				if($data->reasonID == "67" && $data->status == "ACTIVE"){
				if($data->startDate > '2018-03-22'){
					$duration += $this->clacDuration($data->id);
					}
				}
					
				
				}else{
					$bal = 0;
				}
			}
			
			
		if($StaffEmployment->endDate !="" && date('Y-m-d H:i:s') >= $StaffEmployment->endDate ){
			$currStatus = "terminated";
		}else{
			$currStatus = "current";
		}
		
		/* if($staff->endDate == ''){
				$currStatus = "current";
		}else{
			if($staff->startDate <= date('Y-m-d H:i:s') && $staff->endDate >= date('Y-m-d H:i:s')){
				$currStatus = "current";
			}else{
				$currStatus = "terminated";
			}
		} */
		
		
		$info[] = array(
			$balance->staffCode0->staffCode,
			$balance->staffCode0->Fullname,
			$balance->staffCode0->chineseName,
			//($bal==0)?($balance->balance+$entitlement):round(($balance->balance+$entitlement)-$duration,2),
			round(($balance->balance+$entitlement)-$duration,2),
			$duration,
			$alTaken,
			$balance->balance,
			$entitlement,
			$StaffEmployment->basis->content,
			($StaffEmployment->AlternateGroup0)?$StaffEmployment->AlternateGroup0->GroupName0->content:"",
			$currStatus
			
		);
		}
		//var_dump($info);
		//$j=0;
		foreach($info as $i=>$data){
			//foreach($data as $k=>$val){
			//$new_sheet->setCellValue("A".($i+2), $data->refNo);
			//$new_sheet->setCellValue("B".($i+2), date('Y-m-d', strtotime($data->createDate)));
			$new_sheet->setCellValue("A".($i+2), $data[0]);
			$new_sheet->setCellValue("B".($i+2), $data[1]);
			$new_sheet->setCellValue("C".($i+2), $data[2]);
			$new_sheet->setCellValue("D".($i+2), round($data[3],2));
			$new_sheet->setCellValue("E".($i+2), $data[4]);
			$new_sheet->setCellValue("F".($i+2), $data[5]);
			$new_sheet->setCellValue("G".($i+2), $data[6]);
			$new_sheet->setCellValue("H".($i+2), $data[7]);
			$new_sheet->setCellValue("I".($i+2), $data[8]);
			$new_sheet->setCellValue("J".($i+2), $data[9]);
			$new_sheet->setCellValue("K".($i+2), $data[10]);
			//var_dump($val);
			//}
		}
		//exit;
		$new_sheet->getColumnDimension("A")->setAutoSize(true);
		$new_sheet->getColumnDimension("B")->setAutoSize(true);
		$new_sheet->getColumnDimension("D")->setAutoSize(true);
		$new_sheet->getColumnDimension("E")->setAutoSize(true);
		$new_sheet->getColumnDimension("F")->setAutoSize(true);
		/* foreach ($new_sheet->getRowIterator() as $k=>$row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		
		foreach ($cellIterator as $i=>$cell){
			//$value = $cell->getValue();
			//echo $i.$k." ".$value."<br>";
			//$i = column, $k = row; e.g: 1,8 = B8
			$cell->setValue($new_header);
			
		}
		} */
		
		$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 
				
		$objPHPExcel->getActiveSheet()->setTitle('records');
		//$objPHPExcel->getActiveSheet()->setTitle('Discipline List');
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		
		$margin = 1.3 / 2.54;
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);
		

		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L From '.' To '.' &C '.Yii::app()->params['companyName'].' &R '.date('Y-m-d H:i:s'));
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1); 
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L Student Preferences');
		
		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&C Page &P of &N &R');
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
 
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$filename = 'leave_record'.date('YmdHis').".xls";
		
			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			 //header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			 
			
			ob_start();
			$objWriter->save('php://output');
			Yii::app()->end();
		//}
		
		/* $this->render('exportlanding',array(
			'model'=>$model,
		)); */
	}
	
	
	public function staffLeaveDetail($staffCode="all", $year){
		$info = array();
		$criteria1 = new CDbCriteria;
		
		if($staffCode=="all"){
		$criteria1->addCondition("date_format(balanceDate,'%Y') = :balanceDate");
		$criteria1->params = array(
			':balanceDate'=>$year,
		);
		}else{
			$criteria1->addCondition("date_format(balanceDate,'%Y') = :balanceDate");
			$criteria1->addCondition("staffCode = :staffCode");
			$criteria1->params = array(
			':balanceDate'=>$year,
			':staffCode'=>$staffCode,
			);
		}
		$criteria1->order = "staffCode ASC";
		$LeaveBalanceUser = LeaveBalance::model()->findAll($criteria1);
		
		foreach($LeaveBalanceUser as $j=>$balance){
		
		$duration = 0;	
		$durationToday = 0;	
		$durationRemainto0331 = 0;	
		$durationYearEnd = 0;	
		
		$criteria = new CDbCriteria;
		//$criteria->compare('startDate1', $startDate, false);
		//$criteria->compare('endDate', $endDate, false, 'OR');
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("status = :status");
		$criteria->addCondition("date_format(startDate, '%Y') = :starDate");
		//$criteria->addCondition("date_format(startDate, '%Y-%m-%d') <= :starDate");
		
		//$criteria->addCondition("id <= :id");
		$criteria->params = array(
			':staffCode'=>$balance->staffCode,
			':status'=>'ACTIVE',
			':starDate'=>$year,
		);
		$criteria->order = "startDate ASC";
		$model = LeaveApplication::model()->findAll($criteria);
		$sickleve = 0;
		$bal = 0;
		$alTaken = 0;
		
		
		$criteria2 = new CDbCriteria;
		$criteria2->addCondition("staffCode = :staffCode");
		$criteria2->params = array(
			':staffCode'=>$balance->staffCode,
			//':status'=>'ACTIVE',
			//':id'=>'460',
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria2);
		
		
		
		
		/* if($balance->balanceDate <= '2018-03-22'){
			$begin = new DateTime( '2018-03-22' );
		}else{
			//$begin = new DateTime( $StaffEmployment->startDate );
			$begin = new DateTime( $balance->balanceDate );
		} */
		$begin = new DateTime($year.'-01-01');
		//$begin = (date('Y')=="2018")?new DateTime( '2018-03-22' ):new DateTime( date('Y').'-01-01' );
	//$end = new DateTime(date('Y-m-d'));
	$end = new DateTime();
	$calcurrentDay = $begin->diff($end);
	
	$da1 = new DateTime($year.'-12-31');
	$da2 = new DateTime($StaffEmployment->startDate);
	$diffY = $da2->diff($da1);
	//echo $diff->y;
	if($StaffEmployment->Basis==62){
		if($diffY->y<=2){
			$ALtotal=7;
			
			$addOne2NextYear = 0;
			
			
		}else{
			if(7+($diffY->y-2) >= 14){
				$ALtotal= 14;
			}else{
				$ALtotal= 7+($diffY->y-2);
			}
			$addOne2NextYear = 0;
			
		}
		
		$da11 = new DateTime($year.'-01-01');
		$da22 = new DateTime($year.date('-m-d', strtotime($StaffEmployment->startDate)));
		$diff11 = $da22->diff($da11);
		$diff22 = $da22->diff($da1);
		$diff33 = $da11->diff($da1);
		$sub1 = ($diffY->y+1 >=3)?1:0;
		
		if((($ALtotal-$addOne2NextYear)*($diff11->days)+($ALtotal+$sub1)*($diff22->days+1))/($diff33->days+1) >=14){
			$ALtotal = 14;
		}else{
		
		$ALtotal = (($ALtotal-$addOne2NextYear)*($diff11->days)+($ALtotal+$sub1)*($diff22->days+1))/($diff33->days+1);
		}
		//if($balance->staffCode == "1222"){
		//echo $ALtotal."|".$addOne2NextYear."|".$diff11->days."|".$ALtotal."|".$sub1."|".($diff22->days+1)."|".($diff33->days+1)."<br>";
		//echo (($ALtotal-$addOne2NextYear)*($diff11->days)+($ALtotal+$sub1)*($diff22->days+1))/($diff33->days+1);
		//exit;
		//}
	}else{
		$ALtotal = 14;
	}
	
	
	
	
	
	$YearEnd = new DateTime($year.'-12-31');
	$totalSickLeave = 12;
	if(date('Y', strtotime($StaffEmployment->startDate)) == $year ){
		$joinDate = new DateTime($StaffEmployment->startDate);
		$firstYearProDay = $YearEnd->diff($joinDate);
		if($balance->balance > 0){
			$entitlement = $balance->balance;
		}else{
			$entitlement = ($ALtotal/365)*($firstYearProDay->days);
		}
		
		
		$asToday = $joinDate->diff($end);
		$entitlementUpToToday = ($ALtotal/365)*($asToday->days);
		$entitlementSickLeaveCurrentYear = ($totalSickLeave/365)*($firstYearProDay->days);
		
		
	}else{
		if($balance->balance > 0){
			$entitlement = $balance->balance;
		}else{
			$entitlement = ($ALtotal/365)*($begin->diff($da1)->days+1);
		}
		
		$entitlementUpToToday = ($ALtotal/365)*($calcurrentDay->days);
		$entitlementSickLeaveCurrentYear = $totalSickLeave;
	}
	
	
	
	$remainBalance = $this->loadRemainBalance($balance->staffCode, ($year-1));
	
	if($remainBalance && $remainBalance->remaining > 0){
		$getInt = intval(round($remainBalance->remaining,1));
		$decimal = round($remainBalance->remaining,1)-$getInt;
		$finalOut = 0;
		if($decimal >= 0.5){
			$finalOut = $getInt+0.5;
		}else{
			$finalOut = $getInt;
		}
		
	}else{
		$finalOut = 0;
	}
	
	
	
	
	if($year=="2019"){
		$applyendate = "2019-09-30";
	}else{
		//$applyendate= $year."-04-30";
		if($remainBalance){
			$applyendate= date('Y-m-d', strtotime("+1 day", strtotime($remainBalance->endDate)));
		}else{
			$applyendate= $year."-03-31";
		}
	}
	$remainingapply = $this->loadStaffApplicationDeductionPeroid($balance->staffCode, $year."-01-01", $applyendate);
	if($remainBalance && $remainBalance->remaining-$remainingapply > 0){
		//$getLastYearBL = round($remainBalance->remaining-$remainingapply,2);
		
		$getInt = intval(round($remainBalance->remaining-$remainingapply,1));
		$decimal = round($remainBalance->remaining-$remainingapply,1)-$getInt;
		$getLastYearBL = 0;
		if($decimal >= 0.5){
			$getLastYearBL = $getInt+0.5;
		}else{
			$getLastYearBL = $getInt;
		}
		
	}else{
		$getLastYearBL = 0;
	}
	
	
	
	/* $remainBalance = $this->loadRemainBalance($balance->staffCode, (2019-1));
	$remainingapply = $this->loadStaffApplicationDeductionPeroid($balance->staffCode, "2019-01-01", "2019-03-31");
	if($remainBalance && $remainBalance->remaining-$remainingapply < 0){
		$remainBal = $remainBalance->remaining-$remainingapply;
	}else{
		$remainBal = 0;
	}
	$allApplied = $totalBal-$this->loadStaffApplicationDeduction($balance->staffCode, 2019, 'ACTIVE', 'NO')+$remainBal; */
	$sickLeavefor4over5 = 0;
			foreach($model as $i=>$data){
				if($data && $StaffEmployment->AlternateGroup0){
					$bal = $this->getLeaveBalance2($data);
					
				if($data->reasonID == "67"  && $data->status == "ACTIVE"){
					
					if($data->startDate >= $year.'-01-01' || $data->endDate <= $year.'-12-31'){
						
						if($this->isApproved($data->id, $data->staffCode)){
							$alTaken += $this->clacDuration($data->id);
						}else{
							if(!$this->isRejected($data->id, $data->staffCode)){
								$alTaken += $this->clacDuration($data->id);
							}
						}
						/* if(!$this->isRejected($data->id, $data->staffCode)){
								$alTaken += $this->clacDuration($data->id);
						} */
					}
				}
				if($data->reasonID == "67" && $data->status == "ACTIVE"){
				if($data->startDate >= $year.'-01-01' && $data->endDate <= $year.'-12-31'){
					if($this->isApproved($data->id, $data->staffCode)){
						$duration += $this->clacDuration($data->id);
					}
				}
				
				if($data->startDate >= $year.'-01-01' && $data->endDate <= date('Y-m-d')){
					$durationToday += $this->clacDuration($data->id);
				}
				
				if($data->startDate >= $year.'-01-01' && $data->endDate <= $applyendate){
					$durationRemainto0331 += $this->clacDuration($data->id);
				}
				
				
				if($data->startDate >= $year.'-01-01' && $data->endDate <= $year.'-12-31'){
					$durationYearEnd += $this->clacDuration($data->id);
				}
				
				}
				
				if($data->reasonID == "66" && $data->status == "ACTIVE"){
					if($data->startDate >= $year.'-01-01' && $data->endDate <= $year.'-12-31'){
						$sickleve += $this->clacDuration($data->id);
						
						if($this->clacDuration($data->id) >= 4){
							$sickLeavefor4over5 += $this->clacDuration($data->id);
						}
						
					}
				}
				
				}else{
					$bal = 0;
				}
			}
			
			
		if($StaffEmployment->endDate !="" && date('Y-m-d H:i:s') >= $StaffEmployment->endDate ){
			$currStatus = "terminated";
		}else{
			$currStatus = "current";
		}
		
		/* if($staff->endDate == ''){
				$currStatus = "current";
		}else{
			if($staff->startDate <= date('Y-m-d H:i:s') && $staff->endDate >= date('Y-m-d H:i:s')){
				$currStatus = "current";
			}else{
				$currStatus = "terminated";
			}
		} */
		$ALBalofCurrentYear = 0;
		if($finalOut-$durationRemainto0331 < 0){
			$ALBalofCurrentYear = $ALtotal+($finalOut-$durationRemainto0331);
			$ALasToday = ($finalOut-$durationRemainto0331)+$durationToday;
		}else{
			$ALBalofCurrentYear = $ALtotal;
			$ALasToday = $durationToday;
		}
		$remainBalanceVal = ($remainBalance)?$remainBalance->remaining:0;
		$info[] = array(
			$balance->staffCode0->staffCode,
			$balance->staffCode0->Fullname,
			$balance->staffCode0->chineseName,
			//$finalOut,
			$remainBalanceVal,
			$getLastYearBL,
			round($entitlement, 2),
			round($entitlementUpToToday, 2),
			round($entitlement, 2)+$remainBalanceVal-$getLastYearBL-$alTaken,
			//$finalOut-$getLastYearBL+round($entitlement, 2)-$alTaken,
			$finalOut-$getLastYearBL+round($entitlementUpToToday, 2)-$alTaken,
			
			$alTaken,
			$duration,
			$sickLeavefor4over5,
			round($entitlementSickLeaveCurrentYear,2),
			$sickleve,
			round($entitlementSickLeaveCurrentYear,2)-$sickleve,
			$StaffEmployment->basis->content,
			($StaffEmployment->AlternateGroup0)?$StaffEmployment->AlternateGroup0->GroupName0->content:"",
			$currStatus,
			date('Y-m-d', strtotime($StaffEmployment->startDate)),
			($StaffEmployment->department0&&$StaffEmployment->department0->companyID!="0")?$StaffEmployment->department0->company0->content:"N/A",
			($StaffEmployment->department0&&$StaffEmployment->department0->departmentID!="0")?$StaffEmployment->department0->department0->content:"N/A",
			($StaffEmployment->department0&&$StaffEmployment->department0->divisionID!="0")?$StaffEmployment->department0->division0->content:"N/A",
			round(($entitlement+$balance->balance+$finalOut-$alTaken),2),
			$ALBalofCurrentYear,
			$ALBalofCurrentYear+$getLastYearBL,
			$StaffEmployment->projectCode,
			$StaffEmployment->registeredTrade,
		);
		
		/* $info[] = array(
			$balance->staffCode0->staffCode,
			$balance->staffCode0->Fullname,
			$balance->staffCode0->chineseName,
			//($bal==0)?($balance->balance+$entitlement):round(($balance->balance+$entitlement)-$duration,2),
			round($entitlementUpToToday+($ALBalofCurrentYear-$ALtotal),2),
			round($entitlement+$balance->balance+($ALBalofCurrentYear-$ALtotal),2),
			round(($entitlement+$balance->balance+$finalOut-$alTaken),2),
			//round($entitlement+$this->getYearEndBL($StaffEmployment->staffCode, 2019),2),
			//round($ALBalofCurrentYear,2),
			$ALBalofCurrentYear,
			$ALBalofCurrentYear+$getLastYearBL,
			//round(($balance->balance+$entitlement)-$duration,2),
			$sickleve,
			$duration,
			$alTaken,
			$finalOut,
			$getLastYearBL,
			$entitlement."|".$diffY->y,
			$ALtotal,
			$StaffEmployment->basis->content,
			($StaffEmployment->AlternateGroup0->GroupName0)?$StaffEmployment->AlternateGroup0->GroupName0->content:"",
			$currStatus,
			date('Y-m-d', strtotime($StaffEmployment->startDate)),
			($StaffEmployment->department0&&$StaffEmployment->department0->companyID!="0")?$StaffEmployment->department0->company0->content:"N/A",
			($StaffEmployment->department0&&$StaffEmployment->department0->departmentID!="0")?$StaffEmployment->department0->department0->content:"N/A",
			($StaffEmployment->department0&&$StaffEmployment->department0->divisionID!="0")?$StaffEmployment->department0->division0->content:"N/A",
			
		); */
		}
		if($staffCode == "all"){
			return $info;
		}else{
			return isset($info[0])?$info[0]:null;
		}
	}
	
	public function actionExportLandingBalanceYear($year){
		
		//$model=new LeaveApplication;
		//$model->scenario = "export";
		//$this->performAjaxValidation($model);
		//if(isset($_POST['LeaveApplication']))
		//{
			
			ob_end_clean();
			Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator(Yii::app()->params['companyName'])
				->setLastModifiedBy(Yii::app()->params['companyName'])
				->setTitle("Leave records")
				->setSubject("Leave records")
				->setDescription("Leave records")
				->setKeywords("Leave records")
				->setCategory("Leave records");
			
			
			$objPHPExcel->setActiveSheetIndex(0)
				//->setCellValue('A1', "REF")
				//->setCellValue('B1', "APPLY DATE")
				->setCellValue('A1', "STAFF NO")
				->setCellValue('B1', "STAFF NAME")
				->setCellValue('C1', "NAME_C")
				->setCellValue('D1', "AL Bal brought from Previous Year")
				->setCellValue('E1', "AL Bal brought from Previous Year (Unused)")
				->setCellValue('F1', "Current Year entitlement of Current Year")
				->setCellValue('G1', "Current Year entitlement as today")
				->setCellValue('H1', "Balance up to 31 Dec of Current Year")
				->setCellValue('I1', "Balance as today")
				->setCellValue('J1', "AL Submitted")
				->setCellValue('K1', "AL Submitted & Approved")
				->setCellValue('L1', "4/5 Sick Leave Taken")				
				->setCellValue('M1', "Sick Leave Entitlement")
				->setCellValue('N1', "Sick Leave Taken")
				->setCellValue('O1', "Sick leave balance")
				->setCellValue('P1', "basis")
				->setCellValue('Q1', "group")
				->setCellValue('R1', "status")
				->setCellValue('S1', "joindate")
				->setCellValue('T1', "COMPANY")
				->setCellValue('U1', "DEPARTMENT")
				->setCellValue('V1', "DIVISION")
				->setCellValue('W1', "Approver 1")
				->setCellValue('X1', "Approver 2")
				->setCellValue('Y1', "Approver 3")
->setCellValue('AA1', "approved AL inclusive")
->setCellValue('AB1', "Balance of ".($year-1))
->setCellValue('AC1', "Balance of ".($year-1)." + AL Remaining from ".($year-2))
->setCellValue('AD1', "Project Code")
->setCellValue('AE1', "Registered Trade")
				->setCellValue('Z1', date('Y-m-d H:i:s'));
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			);
			
			
		$objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);			
		$new_sheet = $objPHPExcel->setActiveSheetIndex(0);
		
		$info = $this->staffLeaveDetail("all", $year);
		
		//var_dump($info);
		//$j=0;
		$countLetter = array(
			"W",
			"X",
			"Y"
		);
		foreach($info as $i=>$data){
			
			
			
			//foreach($data as $k=>$val){
			//$new_sheet->setCellValue("A".($i+2), $data->refNo);
			//$new_sheet->setCellValue("B".($i+2), date('Y-m-d', strtotime($data->createDate)));
			$new_sheet->setCellValue("A".($i+2), $data[0]);
			$new_sheet->setCellValue("B".($i+2), $data[1]);
			$new_sheet->setCellValue("C".($i+2), $data[2]);
			$new_sheet->setCellValue("D".($i+2), round($data[3],2));
			$new_sheet->setCellValue("E".($i+2), $data[4]);
			$new_sheet->setCellValue("F".($i+2), $data[5]);
			$new_sheet->setCellValue("G".($i+2), $data[6]);
			$new_sheet->setCellValue("H".($i+2), $data[7]);
			$new_sheet->setCellValue("I".($i+2), $data[8]);
			$new_sheet->setCellValue("J".($i+2), $data[9]);
			$new_sheet->setCellValue("K".($i+2), $data[10]);
			$new_sheet->setCellValue("L".($i+2), $data[11]);
			$new_sheet->setCellValue("M".($i+2), $data[12]);
			$new_sheet->setCellValue("N".($i+2), $data[13]);
			$new_sheet->setCellValue("O".($i+2), $data[14]);
			$new_sheet->setCellValue("P".($i+2), $data[15]);
			$new_sheet->setCellValue("Q".($i+2), $data[16]);
			$new_sheet->setCellValue("R".($i+2), $data[17]);
			$new_sheet->setCellValue("S".($i+2), $data[18]);
			$new_sheet->setCellValue("T".($i+2), $data[19]);
			$new_sheet->setCellValue("U".($i+2), $data[20]);
			$new_sheet->setCellValue("V".($i+2), $data[21]);
			$new_sheet->setCellValue("AA".($i+2), $data[22]);
			$new_sheet->setCellValue("AB".($i+2), $data[23]);
			$new_sheet->setCellValue("AC".($i+2), $data[24]);
			$new_sheet->setCellValue("AD".($i+2), $data[25]);
			$new_sheet->setCellValue("AE".($i+2), $data[26]);
			foreach($this->getApprover($data[0]) as $j=>$approver){ 
				if($approver){
					$new_sheet->setCellValue($countLetter[$j].($i+2), $approver->approver0->staffCode."-".$approver->approver0->Fullname);
				}
			}
			//var_dump($val);
			//}
		}
		//exit;
		
		$new_sheet->getColumnDimension("A")->setAutoSize(true);
		$new_sheet->getColumnDimension("B")->setAutoSize(true);
		$new_sheet->getColumnDimension("C")->setWidth(10);
		$new_sheet->getColumnDimension("D")->setWidth(10);
		$new_sheet->getColumnDimension("E")->setWidth(10);
		$new_sheet->getColumnDimension("F")->setWidth(10);
		$new_sheet->getColumnDimension("G")->setWidth(10);
		$new_sheet->getColumnDimension("H")->setWidth(10);
		$new_sheet->getColumnDimension("I")->setWidth(10);
		$new_sheet->getColumnDimension("J")->setWidth(10);
		$new_sheet->getColumnDimension("K")->setWidth(10);
		$new_sheet->getColumnDimension("L")->setWidth(10);
		
		
		$new_sheet->getStyle('C1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('D1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('E1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('F1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('G1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('H1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('I1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('J1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('K1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('L1')->getAlignment()->setWrapText(true);
		
		
		
		/* foreach ($new_sheet->getRowIterator() as $k=>$row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		
		foreach ($cellIterator as $i=>$cell){
			//$value = $cell->getValue();
			//echo $i.$k." ".$value."<br>";
			//$i = column, $k = row; e.g: 1,8 = B8
			$cell->setValue($new_header);
			
		}
		} */
		
		$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 
				
		$objPHPExcel->getActiveSheet()->setTitle('records');
		//$objPHPExcel->getActiveSheet()->setTitle('Discipline List');
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		
		$margin = 1.3 / 2.54;
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);
		

		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L From '.' To '.' &C '.Yii::app()->params['companyName'].' &R '.date('Y-m-d H:i:s'));
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1); 
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L Student Preferences');
		
		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&C Page &P of &N &R');
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
 
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$filename = 'leave_record'.date('YmdHis').".xls";
		
			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			 //header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			 
			
			ob_start();
			$objWriter->save('php://output');
			Yii::app()->end();
		//}
		
		/* $this->render('exportlanding',array(
			'model'=>$model,
		)); */
	}
	
	
	public function actionExportLandingBalance4(){
		
		//$model=new LeaveApplication;
		//$model->scenario = "export";
		//$this->performAjaxValidation($model);
		//if(isset($_POST['LeaveApplication']))
		//{
			
			ob_end_clean();
			Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator(Yii::app()->params['companyName'])
				->setLastModifiedBy(Yii::app()->params['companyName'])
				->setTitle("Leave records")
				->setSubject("Leave records")
				->setDescription("Leave records")
				->setKeywords("Leave records")
				->setCategory("Leave records");
			
			
			$objPHPExcel->setActiveSheetIndex(0)
				//->setCellValue('A1', "REF")
				//->setCellValue('B1', "APPLY DATE")
				->setCellValue('A1', "STAFF NO")
				->setCellValue('B1', "STAFF NAME")
				->setCellValue('C1', "NAME_C")
				->setCellValue('D1', "AL Bal brought from Previous Year")
				->setCellValue('E1', "AL Bal brought from Previous Year (Unused)")
				->setCellValue('F1', "Current Year entitlement of Current Year")
				->setCellValue('G1', "Current Year entitlement as today")
				->setCellValue('H1', "Balance up to 31 Dec of Current Year")
				->setCellValue('I1', "Balance as today")
				->setCellValue('J1', "AL Submitted")
				->setCellValue('K1', "AL Submitted & Approved")
				->setCellValue('L1', "4/5 Sick Leave Taken")				
				->setCellValue('M1', "Sick Leave Entitlement")
				->setCellValue('N1', "Sick Leave Taken")
				->setCellValue('O1', "Sick leave balance")
				->setCellValue('P1', "basis")
				->setCellValue('Q1', "group")
				->setCellValue('R1', "status")
				->setCellValue('S1', "joindate")
				->setCellValue('T1', "COMPANY")
				->setCellValue('U1', "DEPARTMENT")
				->setCellValue('V1', "DIVISION")
				->setCellValue('W1', "Approver 1")
				->setCellValue('X1', "Approver 2")
				->setCellValue('Y1', "Approver 3")
->setCellValue('AA1', "approved AL inclusive")
->setCellValue('AB1', "Balance of 2019")
->setCellValue('AC1', "Balance of 2019 + AL Remaining from 2018")
->setCellValue('AD1', "Project Code")
->setCellValue('AE1', "Registered Trade")
				->setCellValue('Z1', date('Y-m-d H:i:s'));
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			);
			
			
		$objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);			
		$new_sheet = $objPHPExcel->setActiveSheetIndex(0);
		
		$info = $this->staffLeaveDetail("all", "2020");
		
		//var_dump($info);
		//$j=0;
		$countLetter = array(
			"W",
			"X",
			"Y"
		);
		foreach($info as $i=>$data){
			
			
			
			//foreach($data as $k=>$val){
			//$new_sheet->setCellValue("A".($i+2), $data->refNo);
			//$new_sheet->setCellValue("B".($i+2), date('Y-m-d', strtotime($data->createDate)));
			$new_sheet->setCellValue("A".($i+2), $data[0]);
			$new_sheet->setCellValue("B".($i+2), $data[1]);
			$new_sheet->setCellValue("C".($i+2), $data[2]);
			$new_sheet->setCellValue("D".($i+2), round($data[3],2));
			$new_sheet->setCellValue("E".($i+2), $data[4]);
			$new_sheet->setCellValue("F".($i+2), $data[5]);
			$new_sheet->setCellValue("G".($i+2), $data[6]);
			$new_sheet->setCellValue("H".($i+2), $data[7]);
			$new_sheet->setCellValue("I".($i+2), $data[8]);
			$new_sheet->setCellValue("J".($i+2), $data[9]);
			$new_sheet->setCellValue("K".($i+2), $data[10]);
			$new_sheet->setCellValue("L".($i+2), $data[11]);
			$new_sheet->setCellValue("M".($i+2), $data[12]);
			$new_sheet->setCellValue("N".($i+2), $data[13]);
			$new_sheet->setCellValue("O".($i+2), $data[14]);
			$new_sheet->setCellValue("P".($i+2), $data[15]);
			$new_sheet->setCellValue("Q".($i+2), $data[16]);
			$new_sheet->setCellValue("R".($i+2), $data[17]);
			$new_sheet->setCellValue("S".($i+2), $data[18]);
			$new_sheet->setCellValue("T".($i+2), $data[19]);
			$new_sheet->setCellValue("U".($i+2), $data[20]);
			$new_sheet->setCellValue("V".($i+2), $data[21]);
			$new_sheet->setCellValue("AA".($i+2), $data[22]);
			$new_sheet->setCellValue("AB".($i+2), $data[23]);
			$new_sheet->setCellValue("AC".($i+2), $data[24]);
			$new_sheet->setCellValue("AD".($i+2), $data[25]);
			$new_sheet->setCellValue("AE".($i+2), $data[26]);
			foreach($this->getApprover($data[0]) as $j=>$approver){ 
				if($approver){
					$new_sheet->setCellValue($countLetter[$j].($i+2), $approver->approver0->staffCode."-".$approver->approver0->Fullname);
				}
			}
			//var_dump($val);
			//}
		}
		//exit;
		
		$new_sheet->getColumnDimension("A")->setAutoSize(true);
		$new_sheet->getColumnDimension("B")->setAutoSize(true);
		$new_sheet->getColumnDimension("C")->setWidth(10);
		$new_sheet->getColumnDimension("D")->setWidth(10);
		$new_sheet->getColumnDimension("E")->setWidth(10);
		$new_sheet->getColumnDimension("F")->setWidth(10);
		$new_sheet->getColumnDimension("G")->setWidth(10);
		$new_sheet->getColumnDimension("H")->setWidth(10);
		$new_sheet->getColumnDimension("I")->setWidth(10);
		$new_sheet->getColumnDimension("J")->setWidth(10);
		$new_sheet->getColumnDimension("K")->setWidth(10);
		$new_sheet->getColumnDimension("L")->setWidth(10);
		
		
		$new_sheet->getStyle('C1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('D1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('E1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('F1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('G1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('H1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('I1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('J1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('K1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('L1')->getAlignment()->setWrapText(true);
		
		
		
		/* foreach ($new_sheet->getRowIterator() as $k=>$row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		
		foreach ($cellIterator as $i=>$cell){
			//$value = $cell->getValue();
			//echo $i.$k." ".$value."<br>";
			//$i = column, $k = row; e.g: 1,8 = B8
			$cell->setValue($new_header);
			
		}
		} */
		
		$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 
				
		$objPHPExcel->getActiveSheet()->setTitle('records');
		//$objPHPExcel->getActiveSheet()->setTitle('Discipline List');
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		
		$margin = 1.3 / 2.54;
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);
		

		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L From '.' To '.' &C '.Yii::app()->params['companyName'].' &R '.date('Y-m-d H:i:s'));
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1); 
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L Student Preferences');
		
		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&C Page &P of &N &R');
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
 
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$filename = 'leave_record'.date('YmdHis').".xls";
		
			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			 //header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			 
			
			ob_start();
			$objWriter->save('php://output');
			Yii::app()->end();
		//}
		
		/* $this->render('exportlanding',array(
			'model'=>$model,
		)); */
	}
	
	public function actionExportLandingBalance3(){
		
		//$model=new LeaveApplication;
		//$model->scenario = "export";
		//$this->performAjaxValidation($model);
		//if(isset($_POST['LeaveApplication']))
		//{
			
			ob_end_clean();
			Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator(Yii::app()->params['companyName'])
				->setLastModifiedBy(Yii::app()->params['companyName'])
				->setTitle("Leave records")
				->setSubject("Leave records")
				->setDescription("Leave records")
				->setKeywords("Leave records")
				->setCategory("Leave records");
			
			
			$objPHPExcel->setActiveSheetIndex(0)
				//->setCellValue('A1', "REF")
				//->setCellValue('B1', "APPLY DATE")
				->setCellValue('A1', "STAFF NO")
				->setCellValue('B1', "STAFF NAME")
				->setCellValue('C1', "NAME_C")
				->setCellValue('D1', "AL Bal brought from Previous Year")
				->setCellValue('E1', "AL Bal brought from Previous Year (Unused)")
				->setCellValue('F1', "Current Year entitlement of Current Year")
				->setCellValue('G1', "Current Year entitlement as today")
				->setCellValue('H1', "Balance up to 31 Dec of Current Year")
				->setCellValue('I1', "Balance as today")
				->setCellValue('J1', "AL Submitted")
				->setCellValue('K1', "AL Submitted & Approved")
				->setCellValue('L1', "4/5 Sick Leave Taken")				
				->setCellValue('M1', "Sick Leave Entitlement")
				->setCellValue('N1', "Sick Leave Taken")
				->setCellValue('O1', "Sick leave balance")
				->setCellValue('P1', "basis")
				->setCellValue('Q1', "group")
				->setCellValue('R1', "status")
				->setCellValue('S1', "joindate")
				->setCellValue('T1', "COMPANY")
				->setCellValue('U1', "DEPARTMENT")
				->setCellValue('V1', "DIVISION")
				->setCellValue('W1', "Approver 1")
				->setCellValue('X1', "Approver 2")
				->setCellValue('Y1', "Approver 3")
->setCellValue('AA1', "approved AL inclusive")
->setCellValue('AB1', "Balance of 2019")
->setCellValue('AC1', "Balance of 2019 + AL Remaining from 2018")
				->setCellValue('Z1', date('Y-m-d H:i:s'));
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			);
			
			
		$objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);			
		$new_sheet = $objPHPExcel->setActiveSheetIndex(0);
		
		$info = $this->staffLeaveDetail("all", "2019");
		
		//var_dump($info);
		//$j=0;
		$countLetter = array(
			"W",
			"X",
			"Y"
		);
		foreach($info as $i=>$data){
			
			
			
			//foreach($data as $k=>$val){
			//$new_sheet->setCellValue("A".($i+2), $data->refNo);
			//$new_sheet->setCellValue("B".($i+2), date('Y-m-d', strtotime($data->createDate)));
			$new_sheet->setCellValue("A".($i+2), $data[0]);
			$new_sheet->setCellValue("B".($i+2), $data[1]);
			$new_sheet->setCellValue("C".($i+2), $data[2]);
			$new_sheet->setCellValue("D".($i+2), round($data[3],2));
			$new_sheet->setCellValue("E".($i+2), $data[4]);
			$new_sheet->setCellValue("F".($i+2), $data[5]);
			$new_sheet->setCellValue("G".($i+2), $data[6]);
			$new_sheet->setCellValue("H".($i+2), $data[7]);
			$new_sheet->setCellValue("I".($i+2), $data[8]);
			$new_sheet->setCellValue("J".($i+2), $data[9]);
			$new_sheet->setCellValue("K".($i+2), $data[10]);
			$new_sheet->setCellValue("L".($i+2), $data[11]);
			$new_sheet->setCellValue("M".($i+2), $data[12]);
			$new_sheet->setCellValue("N".($i+2), $data[13]);
			$new_sheet->setCellValue("O".($i+2), $data[14]);
			$new_sheet->setCellValue("P".($i+2), $data[15]);
			$new_sheet->setCellValue("Q".($i+2), $data[16]);
			$new_sheet->setCellValue("R".($i+2), $data[17]);
			$new_sheet->setCellValue("S".($i+2), $data[18]);
			$new_sheet->setCellValue("T".($i+2), $data[19]);
			$new_sheet->setCellValue("U".($i+2), $data[20]);
			$new_sheet->setCellValue("V".($i+2), $data[21]);
			$new_sheet->setCellValue("AA".($i+2), $data[22]);
			$new_sheet->setCellValue("AB".($i+2), $data[23]);
			$new_sheet->setCellValue("AC".($i+2), $data[24]);
			foreach($this->getApprover($data[0]) as $j=>$approver){ 
				if($approver){
					$new_sheet->setCellValue($countLetter[$j].($i+2), $approver->approver0->staffCode."-".$approver->approver0->Fullname);
				}
			}
			//var_dump($val);
			//}
		}
		//exit;
		
		$new_sheet->getColumnDimension("A")->setAutoSize(true);
		$new_sheet->getColumnDimension("B")->setAutoSize(true);
		$new_sheet->getColumnDimension("C")->setWidth(10);
		$new_sheet->getColumnDimension("D")->setWidth(10);
		$new_sheet->getColumnDimension("E")->setWidth(10);
		$new_sheet->getColumnDimension("F")->setWidth(10);
		$new_sheet->getColumnDimension("G")->setWidth(10);
		$new_sheet->getColumnDimension("H")->setWidth(10);
		$new_sheet->getColumnDimension("I")->setWidth(10);
		$new_sheet->getColumnDimension("J")->setWidth(10);
		$new_sheet->getColumnDimension("K")->setWidth(10);
		$new_sheet->getColumnDimension("L")->setWidth(10);
		
		
		$new_sheet->getStyle('C1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('D1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('E1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('F1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('G1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('H1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('I1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('J1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('K1')->getAlignment()->setWrapText(true);
		$new_sheet->getStyle('L1')->getAlignment()->setWrapText(true);
		
		
		
		/* foreach ($new_sheet->getRowIterator() as $k=>$row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		
		foreach ($cellIterator as $i=>$cell){
			//$value = $cell->getValue();
			//echo $i.$k." ".$value."<br>";
			//$i = column, $k = row; e.g: 1,8 = B8
			$cell->setValue($new_header);
			
		}
		} */
		
		$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 
				
		$objPHPExcel->getActiveSheet()->setTitle('records');
		//$objPHPExcel->getActiveSheet()->setTitle('Discipline List');
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		
		$margin = 1.3 / 2.54;
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);
		

		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L From '.' To '.' &C '.Yii::app()->params['companyName'].' &R '.date('Y-m-d H:i:s'));
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1); 
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L Student Preferences');
		
		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&C Page &P of &N &R');
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
 
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$filename = 'leave_record'.date('YmdHis').".xls";
		
			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			 //header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			 
			
			ob_start();
			$objWriter->save('php://output');
			Yii::app()->end();
		//}
		
		/* $this->render('exportlanding',array(
			'model'=>$model,
		)); */
	}
	
	public function actionExportLandingBalance2(){
		
		//$model=new LeaveApplication;
		//$model->scenario = "export";
		//$this->performAjaxValidation($model);
		//if(isset($_POST['LeaveApplication']))
		//{
			
			ob_end_clean();
			Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator(Yii::app()->params['companyName'])
				->setLastModifiedBy(Yii::app()->params['companyName'])
				->setTitle("Leave records")
				->setSubject("Leave records")
				->setDescription("Leave records")
				->setKeywords("Leave records")
				->setCategory("Leave records");
			
			
			$objPHPExcel->setActiveSheetIndex(0)
				//->setCellValue('A1', "REF")
				//->setCellValue('B1', "APPLY DATE")
				->setCellValue('A1', "STAFF NO")
				->setCellValue('B1', "STAFF NAME")
				->setCellValue('C1', "NAME_C")
				->setCellValue('D1', "Balance")
				->setCellValue('E1', "Count")
				->setCellValue('F1', "AL Taken")
				->setCellValue('G1', "AL Bal, FM03-20")
				->setCellValue('H1', "entitlement")
				->setCellValue('I1', "basis")
				->setCellValue('J1', "group")
				->setCellValue('P1', date('Y-m-d H:i:s'));
			$styleArray = array(
			'borders' => array(
			'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
			)
			)
			);
			
			
		$objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);			
		$new_sheet = $objPHPExcel->setActiveSheetIndex(0);
		$info = array();
		$criteria1 = new CDbCriteria;
		$criteria1->order = "staffCode ASC";
		$LeaveBalanceUser = LeaveBalance::model()->findAll($criteria1);
		
		foreach($LeaveBalanceUser as $j=>$balance){
		
		$duration = 0;	
			$criteria = new CDbCriteria;
		//$criteria->compare('startDate1', $startDate, false);
		//$criteria->compare('endDate', $endDate, false, 'OR');
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("status = :status");
		//$criteria->addCondition("startDate <= :status");
		
		$criteria->addCondition("id <= :id");
		$criteria->params = array(
			':staffCode'=>$balance->staffCode,
			':status'=>'ACTIVE',
			':id'=>'460',
		);
		$criteria->order = "startDate ASC";
		$model = LeaveApplication::model()->findAll($criteria);
		
		$bal = 0;
		$alTaken = 0;
		
		
		$criteria2 = new CDbCriteria;
		$criteria2->addCondition("staffCode = :staffCode");
		$criteria2->params = array(
			':staffCode'=>$balance->staffCode,
			//':status'=>'ACTIVE',
			//':id'=>'460',
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria2);
		
		
		
		$begin = (date('Y')=="2018")?new DateTime( '2018-03-22' ):new DateTime( date('Y').'-01-01' );
	$end = new DateTime(date('Y-m-d'));
	$calcurrentDay = $begin->diff($end);
	
		$da1 = new DateTime();
	$da2 = new DateTime($StaffEmployment->startDate);
	$diffY = $da2->diff($da1);
	
	//echo $diff->y;
	if($StaffEmployment->Basis==62){
		if($diffY->y<=2){
			$ALtotal=7;
		}else{
			$ALtotal=7+$diffY->y;
		}
	}else{
		$ALtotal = 14;
	}
	$entitlement = ($ALtotal/365)*($diffY->days+1);
	
	
			foreach($model as $i=>$data){
				if($data && $StaffEmployment->AlternateGroup0){
				if($data->reasonID == "67"){
					$bal = $this->getLeaveBalance2($data);
					if($data->startDate >= '2018-01-01' && $data->startDate <= '2018-07-17'){
						$alTaken += $this->clacDuration($data->id);
					}
				}
				//if($Recordmodel->reasonID == "85" || $Recordmodel->reasonID == "66" || $Recordmodel->reasonID == "83" || $Recordmodel->startDate < '2018-03-22') {
				if($data->reasonID == "67" && !$this->isApproved($data->id, $data->staffCode)){
					
					$duration += $this->clacDuration($data->id);
				}
					
				
				}else{
					$bal = 0;
				}
			}
		
		$info[] = array(
			$balance->staffCode0->staffCode,
			$balance->staffCode0->Fullname,
			$balance->staffCode0->chineseName,
			($bal==0)?$balance->balance+$entitlement:$bal,
			$duration,
			$alTaken,
			$balance->balance,
			$entitlement,
			$StaffEmployment->basis->content,
			($StaffEmployment->AlternateGroup0)?$StaffEmployment->AlternateGroup0->GroupName0->content:"",
			$StaffEmployment->startDate,
			$diffY->format('%y'),
			$diffY->format('%m'),
			$diffY->format('%d'),
		);
		}
		//var_dump($info);
		//$j=0;
		foreach($info as $i=>$data){
			//foreach($data as $k=>$val){
			//$new_sheet->setCellValue("A".($i+2), $data->refNo);
			//$new_sheet->setCellValue("B".($i+2), date('Y-m-d', strtotime($data->createDate)));
			$new_sheet->setCellValue("A".($i+2), $data[0]);
			$new_sheet->setCellValue("B".($i+2), $data[1]);
			$new_sheet->setCellValue("C".($i+2), $data[2]);
			$new_sheet->setCellValue("D".($i+2), $data[3]);
			$new_sheet->setCellValue("E".($i+2), $data[4]);
			$new_sheet->setCellValue("F".($i+2), $data[5]);
			$new_sheet->setCellValue("G".($i+2), $data[6]);
			$new_sheet->setCellValue("H".($i+2), $data[7]);
			$new_sheet->setCellValue("I".($i+2), $data[8]);
			$new_sheet->setCellValue("J".($i+2), $data[9]);
			$new_sheet->setCellValue("K".($i+2), $data[10]);
			$new_sheet->setCellValue("L".($i+2), $data[11]);
			$new_sheet->setCellValue("M".($i+2), $data[12]);
			$new_sheet->setCellValue("N".($i+2), $data[13]);
			//var_dump($val);
			//}
		}
		//exit;
		$new_sheet->getColumnDimension("A")->setAutoSize(true);
		$new_sheet->getColumnDimension("B")->setAutoSize(true);
		$new_sheet->getColumnDimension("D")->setAutoSize(true);
		$new_sheet->getColumnDimension("E")->setAutoSize(true);
		$new_sheet->getColumnDimension("F")->setAutoSize(true);
		/* foreach ($new_sheet->getRowIterator() as $k=>$row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		
		foreach ($cellIterator as $i=>$cell){
			//$value = $cell->getValue();
			//echo $i.$k." ".$value."<br>";
			//$i = column, $k = row; e.g: 1,8 = B8
			$cell->setValue($new_header);
			
		}
		} */
		
		$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow(); 
				
		$objPHPExcel->getActiveSheet()->setTitle('records');
		//$objPHPExcel->getActiveSheet()->setTitle('Discipline List');
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		
		$margin = 1.3 / 2.54;
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($margin);
		

		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L From '.' To '.' &C '.Yii::app()->params['companyName'].' &R '.date('Y-m-d H:i:s'));
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1); 
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L Student Preferences');
		
		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&C Page &P of &N &R');
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
 
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$filename = 'leave_record'.date('YmdHis').".xls";
		
			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			 //header('Content-Type: application/pdf');
			header('Content-Disposition: attachment;filename="'.$filename.'"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			 
			
			ob_start();
			$objWriter->save('php://output');
			Yii::app()->end();
		//}
		
		/* $this->render('exportlanding',array(
			'model'=>$model,
		)); */
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LeaveApplication the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LeaveApplication::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	
	
	public function loadApprovalLog($id){
		$criteria = new CDbCriteria;
		$criteria->addCondition("leaveApplicationID = :leaveApplicationID");
		$criteria->params = array(
			':leaveApplicationID'=>$id
		);
		$model=ApprovalLog::model()->findAll($criteria);
		/*
if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
*/
		return $model;
	}
	
	
	public function loadApprovalers($staffCode, $createDate=null){
		
		
		if($createDate == null){
			$date = date('Y-m-d');
		}else{
			$date = $createDate;
		}
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition(":date between startDate and endDate");
		$criteria->params = array(
			':staffCode'=>$staffCode,
			":date"=>$date
		);
		$criteria->order = "position ASC";
		//$criteria->group = "approver";
		$model = Approvers::model()->findAll($criteria);
		if($model===null)
			throw new CHttpException(404,'There are no approver on the database.');
		return $model;
	}
	
	public function checkApprovalLog($leaveID, $approver){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("leaveApplicationID = :leaveApplicationID");
		$criteria->addCondition("approver = :approver");
		$criteria->params = array(
			':approver'=>$approver,
			':leaveApplicationID'=>$leaveID,
			
		);
		
		$model=ApprovalLog::model()->find($criteria);
		
		return $model;
	}
	
	public static function checkApprovalLogExist($leaveID){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("leaveApplicationID = :leaveApplicationID");
		
		$criteria->params = array(
			
			':leaveApplicationID'=>$leaveID,
			
		);
		
		$model=ApprovalLog::model()->findAll($criteria);
		
		return $model;
	}
	
	public function isApprover($staffCode){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("approver = :approver");
		$criteria->params = array(
			
			':staffCode'=>$staffCode,
			':approver'=>Yii::app()->user->getState('staffCode')
			
		);
		$model=Approvers::model()->findAll($criteria);
		
		return $model;
		
	}	
	
	/**
	 * Performs the AJAX validation.
	 * @param LeaveApplication $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='leave-application-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionGetAttachment($code){
		$this->getAttachment($code);
	}
	
	public function getPhoto($code){
		
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("md5(concat(id, createDate)) = :code");
		$criteria->params = array(
			':code'=>$code,
		);
		
		$model=Attachments::model()->find($criteria);
		
		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
		}else{
		$file = $model->fileLocation;
		if(file_exists($file)){
			$type = pathinfo($model->fileLocation, PATHINFO_EXTENSION);
			$data = file_get_contents($file);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			return $base64;
		}else{
			return false;
		}
	}
	}
	
	
	public function clacDuration($id){
		
		$addition = 0;
		$days = 0;
		$model = LeaveApplication::model()->findByPk($id);
		$specialStaffForAllDay = array("539");
		
		$criteria = new CDbCriteria;
		
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			
			':staffCode'=>$model->staffCode
			
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		$datetime1 = new DateTime($model->startDate);
		$datetime2 = new DateTime($model->endDate);
		$interval1 = $datetime1->diff($datetime2);
		$interval = $interval1->format('%a');
		$startDateType = $model->startDateType;
		$endDateType = $model->endDateType;
			
			
			
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
			':staffCode'=>$model->staffCode
		);
		$alternateGroup = AlternateGroup::model()->find($criteria4);
		unset($criteria4);
		
		
		$criteria4 = new CDbCriteria;
		$criteria4->addCondition("groupID = :groupID");
		$criteria4->params = array(
			':groupID'=>$alternateGroup->groupID
		);
		$StaffGroup = StaffGroup::model()->find($criteria4); */
		
		$period = new DatePeriod(new DateTime($model->startDate),new DateInterval('P1D'),$datetime2->modify('+1 day'));
		
		foreach ($period as $key => $value) {
		unset($criteria1);
				$criteria1 = new CDbCriteria;
				$criteria1->addCondition("staffCode = :staffCode");
				$criteria1->addCondition("status = :status");
				$criteria1->addCondition("currentYear = :currentYear");
				$criteria1->params = array(
					':currentYear'=>$value->format('Y'),
					//':groupID'=>$StaffEmployment->Basis,
					':staffCode'=>$model->staffCode,
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
			
		if($model->reasonID !=66 && $model->reasonID != 130 && $model->reasonID != 129){
		
		
		
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
				
				/* if($datetime1->format('Y-m-d')==$value->format('Y-m-d') && $startDateType=="PM"){
					$addition -= 0.5;
				}elseif($datetime2->format('Y-m-d')==$value->format('Y-m-d') && $endDateType=="AM"){
					$addition -= 0.5;
				}else{
					$addition -= 1;
				} */
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
				
				
				
				
				
				if($StaffEmployment->AlternateGroup0 && $AlternateGroup){
				
				if(date('N', strtotime($value->format('Y-m-d'))) == 6){
				
				
				/* if($StaffEmployment->AlternateGroup0->alternateGroupID == "3"){
					$addition += 0.5;
				} */
				
					$criteria1 = new CDbCriteria;
					$criteria1->addCondition("dutyDate = :dutyDate");
					$criteria1->addCondition("groupID = :groupID");
					$criteria1->params = array(
						':dutyDate'=>$value->format('Y-m-d'),
						':groupID'=>$AlternateGroup->alternateGroupID,
					);
					$AlternateDuty = AlternateDuty::model()->find($criteria1);
					$oneDay = array("96","97","98","124");
					if(in_array($AlternateGroup->groupID, $oneDay)){
						//$addition += 1;
						//if(!$AlternateDuty){
							//if($alternateGroup->alternateGroupID == "4"){
						
						if($AlternateGroup->alternateGroupID !=99 && !$AlternateDuty){
								$addition -= 1;
						}
						
						if($AlternateGroup->alternateGroupID ==0){
								$addition += 1;
						}
						
							//}
						//}
						
						
					}else{
						
						
					if(!$AlternateDuty){
						/* if($alternateGroup->groupID == "125"){
								$addition += 0.5;
						} */
						if($AlternateGroup->alternateGroupID == "0"){
								$addition += 0.5;
								if(in_array($model->staffCode, $specialStaffForAllDay)){ //spiecal staff
									//$addition += 0.5;
								}
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
								if(in_array($model->staffCode, $specialStaffForAllDay)){ //spiecal staff
									$addition += 0.5;
								}
						}
						}
						
						if($interval >= 1){
							
						if(date('Y-m-d', strtotime($model->endDate)) != $value->format('Y-m-d')){	
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
				/* if($startDateType=="ALL" && $endDateType == "AM"){
					$addition -= 0.5;
				} */
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
			}else{
			//	
			}
			
		}else{
			
			$days = 0;
		}
			
		}
		//$days = $interval->days+$addition;
		$days = $interval+$addition;
		
		return $days;
	}
	
	
	public function sentSickLeaveEmail($model){
		
		
		$sickLeaveTotal = $this->sickLeaveTotal($model->staffCode, date('Y', strtotime($model->startDate)).'-01-01');
		$sickLeaveTaken = $this->loadStaffApplicationDeductionSickLeavePeroid($model->staffCode, date('Y', strtotime($model->startDate)).'-01-01', date('Y', strtotime($model->startDate)).'-12-31', 'ACTIVE', 'NO');
		
		if(($sickLeaveTotal['entitlement']-$sickLeaveTaken) <= 3){
			
		
		
		$mail = new YiiMailer();
		$mail->setData(array(
			'model' => $model,
			'remaining'=>($sickLeaveTotal['entitlement']-$sickLeaveTaken),
			'approvers' => $this->loadApprovalers($model->staffCode),
		)); 
		$mail->setView('sickLeaveRemind');
		$mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
		//$mail->AddReplyTo($mailData->setForm);
		/* if($model->staffCode0->email != ""){
			$mail->setTo($model->staffCode0->email);
		} */
		
		$mail->setTo(array('kscheung@rayon.hk','waiyin@rayon.hk'));
		//$mail->setTo(array('yuenwong@rayon.hk'));
		//Ray On Portal – Leave Application Approved [Ref no.:201810831]
		$mail->setSubject("Ray On Portal - Remaining Sick Leave Balance [Alert] [Ref no.:".$model->refNo."]");
		//$mail->AddBcc("leave@rayon.hk");
		$mail->setBcc(array("mclau@rayon.hk"));
		
		if($mail->send()){
			//return $info;
		}else{
			print_r($mail->getError());
		}
		
		
		unset($mail);
		$mail = new YiiMailer();
		$mail->setData(array(
			'model' => $model,
			'remaining'=>($sickLeaveTotal['entitlement']-$sickLeaveTaken),
			'approvers' => $this->loadApprovalers($model->staffCode),
		)); 
		$mail->setView('sickLeaveRemindStaff');
		$mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
		//$mail->AddReplyTo($mailData->setForm);
		if($model->staffCode0->email != ""){
			$mail->setTo($model->staffCode0->email);
		}
		
		//$mail->setTo(array('yuenwong@rayon.hk','waiyin@rayon.hk'));
		//$mail->setTo(array('yuenwong@rayon.hk'));
		//Ray On Portal – Leave Application Approved [Ref no.:201810831]
		$mail->setSubject("Ray On Portal - Remaining Sick Leave Balance [Alert] [Ref no.:".$model->refNo."]");
		//$mail->AddBcc("leave@rayon.hk");
		$mail->setBcc(array("mclau@rayon.hk"));
		
		if($mail->send()){
			//return $info;
		}else{
			print_r($mail->getError());
		}
		
		
		}
	}
	
	public function sentLeaveMail($model){
		$mail = new YiiMailer();
		$mail->setData(array(
			'model' => $model,
			'approvers' => $this->loadApprovalers($model->staffCode),
		)); 
		$mail->setView('leaveConfirmation');
		$mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
		//$mail->AddReplyTo($mailData->setForm);
		if($model->staffCode0->email != ""){
			$mail->setTo($model->staffCode0->email);
		}
		
		$mail->setTo('leave@rayon.hk');
		//Ray On Portal – Leave Application Approved [Ref no.:201810831]
		$mail->setSubject("Ray On Portal – Leave Application Approved [Ref no.:".$model->refNo."]");
		//$mail->AddBcc("leave@rayon.hk");
		$mail->setBcc(array("leave@rayon.hk","mclau@rayon.hk"));
		
		if($mail->send()){
			//return $info;
		}else{
			print_r($mail->getError());
		}
	}
	
	public function sentRejectedMail($model){
		$mail = new YiiMailer();
		$mail->setData(array(
			'model' => $model,
			'approvers' => $this->loadApprovalers($model->staffCode),
		)); 
		$mail->setView('leaveReject');
		$mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
		//$mail->AddReplyTo($mailData->setForm);
		if($model->staffCode0->email != ""){
			$mail->setTo($model->staffCode0->email);
		}
		
		$mail->setTo('leave@rayon.hk');
		//Ray On Portal – Leave Application Approved [Ref no.:201810831]
		$mail->setSubject("Ray On Portal – Leave Application Denied [Ref no.:".$model->refNo."]");
		//$mail->AddBcc("leave@rayon.hk");
		$mail->setBcc(array("leave@rayon.hk","mclau@rayon.hk"));
		
		if($mail->send()){
			//return $info;
		}else{
			print_r($mail->getError());
		}
	}
	
	
	public function sentComfirmation($model, $type=null){
		$mail = new YiiMailer();
		$mail->setData(array(
			'model' => $model,
			
		));
		
		
		if($type == "update"){
			
			$text = "Ray On Portal – Change of Leave Application of ".$model->staffCode0->Fullname." [Ref no.:".$model->refNo."]";
			$mail->setView('leaveApplicationChange');
			
			
		}elseif($type == "delete"){
			$text = "Ray On Portal – Cancellation of Leave Application of ".$model->staffCode0->Fullname." [Ref no.:".$model->refNo."]";
			$mail->setView('leaveApplicationCancel');
			
			
		}else{
			//$text = "Ray On Portal – Successful Submission of Leave Application [Ref no.:".$model->refNo."]";
			$text = "Ray On Portal – Leave(s) awaiting your approval [Ref no.:".$model->refNo."]";
			$mail->setView('approverAlertonSubmission');
		}
		 
		
		$mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
		//$mail->AddReplyTo($mailData->setForm);
		$arrayMailer = array();
		/*
if($model->staffCode0->email != ""){
			$arrayMailer[] = $model->staffCode0->email;
		}
*/
		$Approvalers = $this->loadApprovalers($model->staffCode);
	
		//$mail->setTo('leave@rayon.hk');
		
		
		
		$mail->setSubject($text);
		
		foreach($Approvalers as $i=>$Approvaler){
			if($Approvaler->approver0->email != ""){
				$arrayMailer[] = $Approvaler->approver0->email;
				if($model->reasonID == '131'){
					array_push($arrayMailer, 'kscheung@rayon.hk');
				}
				if($model->reasonID == '129'){
					array_push($arrayMailer, 'kscheung@rayon.hk');
				}
				//$mail->setTo($Approvaler->approver0->email);
				//echo $Approvaler->approver0->email;
			}
		}
		//$mail->AddCC("yuenwong@rayon.hk");
		$mail->setTo($arrayMailer);
		$mail->setBcc(array("leave@rayon.hk","mclau@rayon.hk"));
		//exit;
		if($mail->send()){
			//return $info;
		}else{
			print_r($mail->getError());
			//exit;
		}
		
		unset($mail);
		unset($arrayMailer);
		//employee version
		$mail = new YiiMailer();
		$mail->setData(array(
			'model' => $model,
			
		));
		
		
		if($type == "update"){
			$text = "Ray On Portal – Change of Leave Application [Ref no.:".$model->refNo."]";
			$mail->setView('leaveApplicationChangeEmployee');
		}elseif($type == "delete"){
			$text = "Ray On Portal – Cancellation of Leave Application [Ref no.:".$model->refNo."]";
			$mail->setView('leaveApplicationCancelEmployee');
			
			}else{
			$text = "Ray On Portal – Successful Submission of Leave Application [Ref no.:".$model->refNo."]";
			$mail->setView('leaveApplicationSubmission');
		}
		 
		
		$mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
		//$mail->AddReplyTo($mailData->setForm);
		$arrayMailer = array();
		if($model->staffCode0->email != ""){
			$arrayMailer[] = $model->staffCode0->email;
		}
		//$Approvalers = $this->loadApprovalers($model->staffCode);
		
		$mail->setSubject($text);
		
		/*
foreach($Approvalers as $i=>$Approvaler){
			if($Approvaler->approver0->email != ""){
				$arrayMailer[] = $Approvaler->approver0->email;
				//$mail->setTo($Approvaler->approver0->email);
				//echo $Approvaler->approver0->email;
			}
		}
*/
		//$mail->AddCC("yuenwong@rayon.hk");
		$mail->setTo($arrayMailer);
		$mail->setBcc(array("leave@rayon.hk","mclau@rayon.hk"));
		//exit;
		if($mail->send()){
			//return $info;
		}else{
			print_r($mail->getError());
			//exit;
		}
		
		
		
	}
	
	public function actionTestSent(){
		$model = LeaveApplication::model()->findByPK(363);
		$mail = new YiiMailer();
		$mail->setData(array(
			'model' => $model,
			
		)); 
		$mail->setView('leaveApplication');
		$mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
		//$mail->AddReplyTo($mailData->setForm);
		$arrayMailer = array();
		if($model->staffCode0->email != ""){
			$arrayMailer[] = $model->staffCode0->email;
		}
		$Approvalers = $this->loadApprovalers($model->staffCode);
		
		//$mail->setTo('leave@rayon.hk');
		$type = "";
		if($type == "update"){
			$text = "[REVISED]";
		}elseif($type == "delete"){
			$text = "[DELETED]";
		}else{
			$text = "";
		}
		
		$mail->setSubject("Leave Application - Ref No.:".$model->refNo." ".$text);
		
		foreach($Approvalers as $i=>$Approvaler){
			if($Approvaler->approver0->email != ""){
				$arrayMailer[] = $Approvaler->approver0->email;
				//$mail->setTo($Approvaler->approver0->email);
				//echo $Approvaler->approver0->email;
			}
		}
		//$mail->AddCC("yuenwong@rayon.hk");
		$mail->setTo($arrayMailer);
		$mail->setBcc(array("leave@rayon.hk","mclau@rayon.hk"));
		//$mail->AddBcc("yuenwong@rayon.hk");
		//exit;
		if($mail->send()){
			//return $info;
		}else{
			print_r($mail->getError());
			
		}
	}
	
	public function getLeaveBalance($Recordmodel){
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
			':staffCode'=>$Recordmodel->staffCode
			
		);
		$model = LeaveBalance::model()->find($criteria);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		//$model = LeaveApplication::model()->findByPk($this->id);
		
		$datetime1 = new DateTime($Recordmodel->startDate);
		$datetime2 = new DateTime($Recordmodel->endDate);
		$interval = $datetime1->diff($datetime2);
		
		$startDateType = $Recordmodel->startDateType;
		$endDateType = $Recordmodel->endDateType;
		
		
		
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
     new DateTime($Recordmodel->startDate),
     new DateInterval('P1D'),
     new DateTime($Recordmodel->endDate)
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
		
		unset($criteria1);	
			if($isholiday){
				$addition -= 1;
			}else{
				if($StaffEmployment->Basis==63){
				if(date('N', strtotime($value->format('Y-m-d'))) == 7){
					
					$oneDaySunday = array("96");
					if(in_array($StaffEmployment->leaveGroup, $oneDaySunday)){
						
					}else{
						$addition -= 1;
					}
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
					$oneDay = array("96","97","98");
					if(in_array($StaffEmployment->leaveGroup, $oneDay)){
						//$addition += 1;
					}else{
					if(!$AlternateDuty){
						/* if(in_array($StaffEmployment->AlternateGroup0->groupID, $oneDay)){
							//$addition -= 1;
						}else{
							$addition -= 1;
						} */
					}else{
						if($interval->days > 0){
							$addition -= 0.5;
						}
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
	$da1 = new DateTime();
	$da2 = new DateTime($StaffEmployment->startDate);
	$diffY = $da2->diff($da1);
	//echo $diff->y;
	if($StaffEmployment->Basis==62){
		if($diffY->y<=2){
			$ALtotal=7;
		}else{
			$ALtotal=7+$diffY->y;
		}
	}else{
		$ALtotal = 14;
	}
	$entitlement = ($ALtotal/365)*($calcurrentDay->days+1);
	
	
		if($Recordmodel->reasonID == "85" || $Recordmodel->reasonID == "66" || $Recordmodel->reasonID == "83" || $Recordmodel->startDate < '2018-03-22') {
			$durition += 0;
		}else{
			$durition += $interval->days+$addition;
		}
		$remaning = ($model->balance+round($entitlement,2))-$durition;
		//$remaning -= $days;
		
		return $remaning;
	}
	
	public function getLeaveBalance2($Recordmodel){
		//LeaveBalance
		//StaffDuty
		//Holidays
		
		$addition = 0;
		$days = 0;
		$remaning = 0;
		$durition = 0;
		
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			//':endDate'=>$this->endDate,
			//':endDate'=>$endDate,
			':staffCode'=>$Recordmodel->staffCode
			
		);
		$model = LeaveBalance::model()->find($criteria);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		//$model = LeaveApplication::model()->findByPk($this->id);
		
		$datetime1 = new DateTime($Recordmodel->startDate);
		$datetime2 = new DateTime($Recordmodel->endDate);
		$interval = $datetime1->diff($datetime2);
		
		$startDateType = $Recordmodel->startDateType;
		$endDateType = $Recordmodel->endDateType;
		
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
     new DateTime($Recordmodel->startDate),
     new DateInterval('P1D'),
     new DateTime($Recordmodel->endDate)
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
		unset($criteria1);	
			if($isholiday){
				$addition -= 1;
			}else{
				if($StaffEmployment->Basis==63){
				if(date('N', strtotime($value->format('Y-m-d'))) == 7){
					$oneDaySunday = array("96");
					if(in_array($StaffEmployment->leaveGroup, $oneDaySunday)){
						
					}else{
						$addition -= 1;
					}
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
					$oneDay = array("96","97","98");
					if(in_array($StaffEmployment->leaveGroup, $oneDay)){
						//$addition += 1;
					}else{
					if(!$AlternateDuty){
						/* if(in_array($StaffEmployment->AlternateGroup0->groupID, $oneDay)){
							//$addition -= 1;
						}else{
							$addition -= 1;
						} */
					}else{
						if($interval->days > 0){
							$addition -= 0.5;
						}
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
	
	$da1 = new DateTime();
	$da2 = new DateTime($StaffEmployment->startDate);
	$diffY = $da2->diff($da1);
	//echo $diff->y;
	if($StaffEmployment->Basis==62){
		if($diffY->y<=2){
			$ALtotal=7;
		}else{
			$ALtotal=7+($diffY->y-2);
		}
	}else{
		$ALtotal = 14;
	}
	$entitlement = ($ALtotal/365)*($calcurrentDay->days+1);
	
	//if($this->isApproved($data->id, $data->staffCode) && $data->reasonID == "67"  && $data->status == "ACTIVE"){
	
		/*
if($Recordmodel->reasonID == "67"  && $Recordmodel->status == "ACTIVE" && $Recordmodel->startDate > '2018-03-22'){
			$durition += $interval->days+$addition;
		}else{
			$durition += 0;
		}
*/
		if($Recordmodel->reasonID=='67' && $Recordmodel->startDate > '2018-03-22' && $Recordmodel->status='ACTIVE'){
			$durition += $interval->days+$addition;
		}else{
			$durition += 0;
		}
		/* if($Recordmodel->reasonID == "85" || $Recordmodel->reasonID == "66" || $Recordmodel->reasonID == "83" || ($Recordmodel->startDate < '2018-03-22' && $Recordmodel->endDate < '2018-03-22')) {
			$durition += 0;
		}else{
			$durition += $interval->days+$addition;
		} */
		$remaning = ($model->balance+round($entitlement,2))-$durition;
		//$remaning -= $days;
		
		return ($model->balance+round($entitlement,2)).",".$durition;
	}
	
	
	public function getTotalBal($staffCode, $toDate=null){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("date_format(balanceDate, '%Y') = :balanceDate");
		
		$criteria->params = array(
			//':endDate'=>$this->endDate,
			//':endDate'=>$endDate,
			':staffCode'=>$staffCode,
			':balanceDate'=>($toDate==null)?date('Y'):date('Y', strtotime($toDate)),
			
			
		);
		$model = LeaveBalance::model()->find($criteria);
		
		if(!$model){
			throw new CHttpException(404,'Please check the end date of the staff.');
		}
		
		unset($criteria);
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		//$criteria->addCondition("date_format(balanceDate, '%Y') = :balanceDate");
		
		$criteria->params = array(
			//':endDate'=>$this->endDate,
			//':endDate'=>$endDate,
			':staffCode'=>$staffCode,
			//':balanceDate'=>($toDate==null)?date('Y'):date('Y', strtotime($toDate)),
			
			
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		//entitlement
		//$begin = (date('Y')=="2018")?new DateTime( '2018-03-22' ):new DateTime( date('Y').'-01-01' );
		$begin = new DateTime($model->balanceDate);
		if($toDate==null){
			$end = new DateTime(date('Y-m-d'));
		}else{
			$end = new DateTime($toDate);
		}
		$calcurrentDay = $begin->diff($end);
		
		$da1 = new DateTime(date('Y-', strtotime($toDate)).'12-31');
		$da2 = new DateTime($StaffEmployment->startDate);
		$diffY = $da2->diff($da1);
		//echo $diff->y;
		
		/* if($StaffEmployment->Basis==62){
		if($diffY->y<=2){
			$ALtotal=7;
			
			$addOne2NextYear = 0;
			
			
		}else{
			$ALtotal=7+($diffY->y-2);
			$addOne2NextYear = 1;
			
		}
		
		$da11 = new DateTime(date('Y').'-01-01');
		$da22 = new DateTime(date('Y').date('-m-d', strtotime($StaffEmployment->startDate)));
		$diff11 = $da22->diff($da11);
		$diff22 = $da22->diff($da1);
		$diff33 = $da11->diff($da1);
		$sub1 = ($diffY->y+1 >=3)?1:0;
		$ALtotal = (($ALtotal-$addOne2NextYear)*$diff11->days+($ALtotal+$sub1)*($diff22->days+1))/$diff22->days+1; */
		if($StaffEmployment->Basis==62){
		if($diffY->y<=2){
			$ALtotal=7;
			
			$addOne2NextYear = 0;
			
			
		}else{
			if(7+($diffY->y-2) >= 14){
				$ALtotal= 14;
			}else{
				$ALtotal= 7+($diffY->y-2);
			}
			$addOne2NextYear = 0;
			
		}
		
		$da11 = new DateTime(date('Y-', strtotime($toDate)).'01-01');
		$da22 = new DateTime(date('Y', strtotime($toDate)).date('-m-d', strtotime($StaffEmployment->startDate)));
		$diff11 = $da22->diff($da11);
		$diff22 = $da22->diff(new DateTime(date('Y-', strtotime($toDate)).'12-31'));
		$diff33 = $da11->diff(new DateTime(date('Y-', strtotime($toDate)).'12-31'));
		$sub1 = ($diffY->y+1 >=3)?1:0;
		
		if((($ALtotal-$addOne2NextYear)*($diff11->days)+($ALtotal+$sub1)*($diff22->days+1))/($diff33->days+1) >=14){
			$ALtotal = 14;
		}else{
		
		$ALtotal = (($ALtotal-$addOne2NextYear)*($diff11->days)+($ALtotal+$sub1)*($diff22->days+1))/($diff33->days+1);
		}
		
	}else{
		$ALtotal = 14;
	}
	
	$YearEnd = new DateTime($toDate);
	
	/* if(date('Y', strtotime($StaffEmployment->startDate)) == '2019' ){
		$joinDate = new DateTime($StaffEmployment->startDate);
		$firstYearProDay = $YearEnd->diff($joinDate);
		$entitlement = ($ALtotal/365)*($firstYearProDay->days+1);
		
		
		$asToday = $joinDate->diff($end);
		$entitlementUpToToday = ($ALtotal/365)*($asToday->days+1);
	}else{
		$entitlement = ($ALtotal/365)*($begin->diff($da1)->days+1);
		
		$entitlementUpToToday = ($ALtotal/365)*($calcurrentDay->days+1);
	} */
	
	
	$entitlement = ($ALtotal/365)*($calcurrentDay->days+1);
	
	/* $remainBalance = $this->loadRemainBalance($staffCode, (date('Y')-1));
	if($remainBalance && $remainBalance->remaining > 0){
		$getInt = intval(round($remainBalance->remaining,1));
		$decimal = round($remainBalance->remaining,1)-$getInt;
		$finalOut = 0;
		if($decimal >= 0.5){
			$finalOut = $getInt+0.5;
		}else{
			$finalOut = $getInt;
		}
		
	}else{
		$finalOut = 0;
	}
	
	$remainingapply = $this->loadStaffApplicationDeductionPeroid($staffCode, date('Y')."-01-01", date('Y')."-03-31");
	
	if($remainBalance && $remainBalance->remaining-$remainingapply > 0){
		//$getLastYearBL = round($remainBalance->remaining-$remainingapply,2);
		
		$getInt = intval(round($remainBalance->remaining-$remainingapply,1));
		$decimal = round($remainBalance->remaining-$remainingapply,1)-$getInt;
		$getLastYearBL = 0;
		if($decimal >= 0.5){
			$getLastYearBL = $getInt+0.5;
		}else{
			$getLastYearBL = $getInt;
		}
		
	}else{
		$getLastYearBL = 0;
	} */
		
		//$entitlement = ($ALtotal/365)*($calcurrentDay->days+1);
			
			return ($model->balance+round($entitlement,2));
			//return round($entitlement,2)."|".$ALtotal;
		}
		
		
	public function loadStaffApplicationDeduction($staffCode, $year, $status='ACTIVE', $approved='YES'){
		
		if($year=='2018'){
			$criteria = new CDbCriteria;
			$criteria->addCondition("staffCode = :staffCode");
			$criteria->addCondition(":year between DATE_FORMAT(startDate,'%Y') and DATE_FORMAT(endDate, '%Y')");
			$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') >= '2018-03-22'");
			$criteria->addCondition("status = :status");
			$criteria->addCondition("reasonID = 67");
			$criteria->params = array(
			':status'=>$status,
			':year'=>$year,
			':staffCode'=>$staffCode
			);
		}else{
			$criteria = new CDbCriteria;
			$criteria->addCondition("staffCode = :staffCode");
			$criteria->addCondition(":year between DATE_FORMAT(startDate,'%Y') and DATE_FORMAT(endDate, '%Y')");
			$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') >= :startDate");
			$criteria->addCondition("status = :status");
			$criteria->addCondition("reasonID = 67");
			$criteria->params = array(
			':status'=>$status,
			':year'=>$year,
			':staffCode'=>$staffCode,
			':startDate'=>$year."-10-01"
			);
		}
		
		
		
		
		$model = LeaveApplication::model()->findAll($criteria);
		
		$deduce = 0;
		foreach($model as $i=>$leave){
			if($approved=='YES'){
				if($this->isApproved($leave->id, $staffCode)){
					$deduce += $this->clacDuration($leave->id);
				}
			}else{
				
				if(!$this->isRejected($leave->id, $staffCode)){
					$deduce += $this->clacDuration($leave->id);
				}
			}
			
		}
		
		
	return $deduce;
		
		
	}
		
	public function loadRemainBalance($staffCode, $year){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("Year = :year");
		$criteria->params = array(
		//':status'=>$status,
		':year'=>$year,
		':staffCode'=>$staffCode
		);
		
		$model = RemainBalance::model()->find($criteria);
		
		return $model;
		
	}
	
	public function loadStaffApplicationDeductionPeroid($staffCode, $from, $to, $status='ACTIVE', $approved='YES'){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') between :from and :to");
		//$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') >= '2018-03-22'");
		$criteria->addCondition("status = :status");
		$criteria->addCondition("reasonID = 67");
		$criteria->params = array(
		':status'=>$status,
		':from'=>$from,
		':to'=>$to,
		':staffCode'=>$staffCode
		);
		
		$model = LeaveApplication::model()->findAll($criteria);
		
		$deduce = 0;
		foreach($model as $i=>$leave){
			/* if($approved=='YES'){
				if($this->isApproved($leave->id, $staffCode)){
					$deduce += $this->clacDuration($leave->id);
				}
			}else{
				$deduce += $this->clacDuration($leave->id);
			} */
			if($leave->status == "ACTIVE" && !$this->isRejected($leave->id, $staffCode)){
				$deduce += $this->clacDuration($leave->id);
			}
		}
		
		
	return $deduce;
	
	
	}
	
	public function getBalanceByDate($model, $date=null, $forUser=true){
	if($date==null){
			$date = date('Y-m-d');
	}
	$end = new DateTime();
		$criteria = new CDbCriteria;
				$criteria->addCondition("staffCode = :staffCode");
				$criteria->params = array(
					':staffCode'=>$model->staffCode
				);
				
				$StaffEmployment = StaffEmployment::model()->find($criteria);
				
				if($StaffEmployment){
				unset($criteria);
				$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition('DATE_FORMAT(balanceDate, "%Y") = :balanceDate');
		$criteria->params = array(
			
			//':endDate'=>$endDate,
			':staffCode'=>$model->staffCode,
			':balanceDate'=>date('Y', strtotime($date)),
			
		);
		//$criteria-
		$leaveBalance = LeaveBalance::model()->findAll($criteria);
				
		$da1 = new DateTime(date('Y-m-d', strtotime($date)));
		$da2 = new DateTime($StaffEmployment->startDate);
		$diffY = $da2->diff($da1);
				
				
		if($StaffEmployment->Basis==62){
		if($diffY->y<=2){
			$ALtotal=7;
			
			$addOne2NextYear = 0;
			
			
		}else{
			if(7+($diffY->y-2) >= 14){
				$ALtotal= 14;
			}else{
				$ALtotal= 7+($diffY->y-2);
			}
			$addOne2NextYear = 0;
			
		}
		
		$da11 = new DateTime(date('Y-', strtotime($date)).'01-01');
		$da22 = new DateTime(date('Y', strtotime($date)).date('-m-d', strtotime($StaffEmployment->startDate)));
		$diff11 = $da22->diff($da11);
		$diff22 = $da22->diff(new DateTime(date('Y-', strtotime($date)).'12-31'));
		$diff33 = $da11->diff(new DateTime(date('Y-', strtotime($date)).'12-31'));
		$sub1 = ($diffY->y+1 >=3)?1:0;
		
		if((($ALtotal-$addOne2NextYear)*($diff11->days)+($ALtotal+$sub1)*($diff22->days+1))/($diff33->days+1) >=14){
			$ALtotal = 14;
		}else{
		
		$ALtotal = (($ALtotal-$addOne2NextYear)*($diff11->days)+($ALtotal+$sub1)*($diff22->days+1))/($diff33->days+1);
		}
		
	}else{
		$ALtotal = 14;
	}
		
		
	
		$totalBal = 0;
		/* foreach($leaveBalance as $i=>$balance) { 
				$begin = new DateTime($balance->balanceDate);
				$getYear = date('Y', strtotime($balance->balanceDate));
				//$end = new DateTime($getYear.'-12-31');
				$end = new DateTime(date('Y-m-d', strtotime($date)));
				$calcurrentDay1 = $begin->diff($end);
				$calcurrentDay = $calcurrentDay1->format('%a');
				$entitlement = ($ALtotal/365)*(($calcurrentDay+1));
				//$totalBal = $entitlement+$balance->balance;
				$totalBal += $entitlement+$balance->balance;
		} */
		
		$allApplied = $ALtotal-$this->loadStaffApplicationDeduction($model->staffCode, date('Y'), 'ACTIVE', 'YES');
		
		
		
		
		$rounded = round($allApplied, 1);
		$getInt = intval($rounded);
		$decimal = $rounded-$getInt;
		$finalOut = 0;
		if($decimal >= 0.5){
			$finalOut = $getInt+0.5;
		}else{
			$finalOut = $getInt;
		}
		
		if($forUser){
			return $finalOut;
		}else{
			return $allApplied;
		}
		
	}
	}
	
	public function getLongServiceYear($staffCode){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>$staffCode
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		$d1 = new DateTime(date('Y-m-d'));
		$d2 = new DateTime($StaffEmployment->startDate);
		//$d2->modify('-1 year');
		$diff = $d2->diff($d1);
		
		
		return $diff->y;
		
	}
	
	public function getLongServiceYearDetails($staffCode){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>$staffCode
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		$d1 = new DateTime(date('Y-m-d'));
		$d2 = new DateTime($StaffEmployment->startDate);
		//$diff = $d2->diff($d1);
		$period = new DatePeriod($d2, new DateInterval('P5Y'),$d1);
		
		return $period;
	}
	
	public function checkProbation($staffCode, $date){
		
		$array = array();
		$array['ProbationDate'] = "";
		$isProbation = false;
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>$staffCode
		);
		$StaffEmployment = StaffEmployment::model()->find($criteria);
		
		
		if($StaffEmployment->probationEndDate==""){
		
		$d1 = new DateTime($date);
		$d2 = new DateTime($StaffEmployment->startDate);
		
		$diff = $d2->diff($d1);
		
		if($diff->m+($diff->y*12) < 3 ){
			$isProbation = true;
		}
		$array['isProbation'] = $isProbation;
		$array['ProbationDate'] = $d2->modify('+2 month')->format('Y-m-d');
		}else{
			
			if(date('Y-m-d') >= $StaffEmployment->probationEndDate){
				
			}else{
				$isProbation = true;
			}
			$array['isProbation'] = $isProbation;
			$array['ProbationDate'] = $StaffEmployment->probationEndDate;
		}
		
		
		
		return $array;
		//$period = new DatePeriod($d2,new DateInterval('P6Y'),$d1);
		
	}
	
	public function loadStaffApplicationDeductionSickLeavePeroid($staffCode, $from, $to, $status='ACTIVE', $approved='YES'){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') between :from and :to");
		//$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') >= '2018-03-22'");
		$criteria->addCondition("status = :status");
		$criteria->addCondition("reasonID = 66");
		$criteria->params = array(
		':status'=>$status,
		':from'=>$from,
		':to'=>$to,
		':staffCode'=>$staffCode
		);
		
		$model = LeaveApplication::model()->findAll($criteria);
		
		$deduce = 0;
		foreach($model as $i=>$leave){
			/* if($approved=='YES'){
				if($this->isApproved($leave->id, $staffCode)){
					$deduce += $this->clacDuration($leave->id);
				}
			}else{
				$deduce += $this->clacDuration($leave->id);
			} */
			$deduce += $this->clacDuration($leave->id);
		}
		
		
	return $deduce;
	
	
	}
	
	
	public function loadStaffMarriage($staffCode, $status='ACTIVE', $approved='YES'){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		//$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') between :from and :to");
		//$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') >= '2018-03-22'");
		$criteria->addCondition("status = :status");
		$criteria->addCondition("reasonID = 129");
		$criteria->params = array(
		':status'=>$status,
		//':from'=>$from,
		//':to'=>$to,
		':staffCode'=>$staffCode
		);
		
		$model = LeaveApplication::model()->findAll($criteria);
		
		$deduce = 0;
		foreach($model as $i=>$leave){
			/* if($approved=='YES'){
				if($this->isApproved($leave->id, $staffCode)){
					$deduce += $this->clacDuration($leave->id);
				}
			}else{
				$deduce += $this->clacDuration($leave->id);
			} */
			$deduce += $this->clacDuration($leave->id);
		}
		
		
	return $deduce;
	
	
	}
	
	public function loadStaffBirthdayLeave($staffCode, $status='ACTIVE', $approved='YES'){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		//$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') between :from and :to");
		$criteria->addCondition("DATE_FORMAT(startDate,'%Y') = :from");
		$criteria->addCondition("status = :status");
		$criteria->addCondition("reasonID = 130");
		$criteria->params = array(
		':status'=>$status,
		':from'=>date('Y'),
		//':to'=>$to,
		':staffCode'=>$staffCode
		);
		
		$model = LeaveApplication::model()->findAll($criteria);
		
		$deduce = 0;
		foreach($model as $i=>$leave){
			/* if($approved=='YES'){
				if($this->isApproved($leave->id, $staffCode)){
					$deduce += $this->clacDuration($leave->id);
				}
			}else{
				$deduce += $this->clacDuration($leave->id);
			} */
			$deduce += $this->clacDuration($leave->id);
		}
		
		
	return $deduce;
	
	
	}
	
	public function loadStaffLongServiceLeave($staffCode, $status='ACTIVE', $approved='YES'){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		//$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') between :from and :to");
		//$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') >= '2018-03-22'");
		$criteria->addCondition("status = :status");
		$criteria->addCondition("reasonID = 128");
		$criteria->params = array(
		':status'=>$status,
		//':from'=>$from,
		//':to'=>$to,
		':staffCode'=>$staffCode
		);
		
		$model = LeaveApplication::model()->findAll($criteria);
		
		$deduce = 0;
		foreach($model as $i=>$leave){
			/* if($approved=='YES'){
				if($this->isApproved($leave->id, $staffCode)){
					$deduce += $this->clacDuration($leave->id);
				}
			}else{
				$deduce += $this->clacDuration($leave->id);
			} */
			$deduce += $this->clacDuration($leave->id);
		}
		
		
	return $deduce;
	
	
	}
	
	public function loadStaffMarriageLeave($staffCode, $status='ACTIVE', $approved='YES'){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		//$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') between :from and :to");
		//$criteria->addCondition("DATE_FORMAT(startDate,'%Y-%m-%d') >= '2018-03-22'");
		$criteria->addCondition("status = :status");
		$criteria->addCondition("reasonID = 129");
		$criteria->params = array(
		':status'=>$status,
		//':from'=>$from,
		//':to'=>$to,
		':staffCode'=>$staffCode
		);
		
		$model = LeaveApplication::model()->findAll($criteria);
		
		$deduce = 0;
		foreach($model as $i=>$leave){
			/* if($approved=='YES'){
				if($this->isApproved($leave->id, $staffCode)){
					$deduce += $this->clacDuration($leave->id);
				}
			}else{
				$deduce += $this->clacDuration($leave->id);
			} */
			$deduce += $this->clacDuration($leave->id);
		}
		
		
	return $deduce;
	
	
	}
	
	
	public function sickLeaveTotal($staffCode, $from){
		//2019-04-23, 2019-07-23, 2019-07-24 to 2019-12-31; 
		if(!$this->checkProbation($staffCode, $from)['isProbation']){
			
			$array = array();
			$array['entitlement'] = 0;
			
			$Probation = $this->checkProbation($staffCode, $from);
			//$startDate = new DateTime($Probation['ProbationDate'])->modify('-3 month');
			
			$d2 = new DateTime(date('Y-', strtotime($from)).'12-31');
			$d1 = new DateTime($Probation['ProbationDate']);
		
			$diff = $d2->diff($d1->modify('-2 month'));
			
			
			
			$calcurrentDay = $diff->format('%a');
			$entitlement = (12/365)*($calcurrentDay);
			$rounded = round($entitlement, 1);
			$getInt = intval($rounded);
			$decimal = $rounded-$getInt;
			$finalOut = 0;
			if($decimal >= 0.5){
				$finalOut = $getInt+0.5;
			}else{
				$finalOut = $getInt;
			}
			
			if($d1->format('Y-m-d') > date('Y-', strtotime($from)).'01-01'){
				$array['from'] = $d1->format('Y-m-d');
			}else{
				$array['from'] = date('Y-', strtotime($from)).'01-01';
			}
			$array['to'] = $d2->format('Y-m-d');
			$array['entitlement'] = ($finalOut>12)?12:$finalOut;
			$array['entitlement1'] = $d1->format('Y-m-d');
			return $array;
		}
	}
	
	public function getYearEndBL($staffCode, $getYear){
		$remainBalance = $this->loadRemainBalance($staffCode, ($getYear-1));
		$remainingapply = $this->loadStaffApplicationDeductionPeroid($staffCode, $getYear."-01-01", $getYear."-09-30");
		if($remainBalance && $remainBalance->remaining-$remainingapply < 0){
			$remainBal = $remainBalance->remaining-$remainingapply;
			//echo $remainBalance->remaining."|";
		}else{
			$remainBal = 0;
		}
		
		//echo $remainingapply."|".$remainBal."|";
		
		
		$allApplied = $this->loadStaffApplicationDeduction($staffCode, $getYear, 'ACTIVE', 'NO')+$remainBal;
		$rounded = round($allApplied, 1);
		$getInt = intval($rounded);
		$decimal = $rounded-$getInt;
		
		return $allApplied;
	}
	
	/* public function getRefNo($year){
		
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("currentYear = :currentYear");
		$criteria->params = array(
			":currentYear"=>$year
		);
		
		$LeaveApplicationCount = 
	} */

}
