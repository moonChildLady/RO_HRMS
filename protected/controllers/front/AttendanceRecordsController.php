<?php

class AttendanceRecordsController extends Controller
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
			'rights'
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function findLocation($id){
		
		
		$criteria=new CDbCriteria;
	
	$criteria->order = "contractID ASC";
	$criteria->addCondition("contractID = :contractID");
	$criteria->params = array(
		':contractID'=>$id,
	);
		
	$StarSystem = StarSystem::model()->find($criteria);
		
		
		
		/* $locationArray = array(
			"1"=>'HO',
			"2"=>"NM",
			"3495"=>"SH",
			//'1'=>'Head Office',
			//'2'=>'Nina Mall',
			'100'=>'Pacific Place',
			//"3495"=>"2018-028 Shatin Hospital",
			"101"=>"TST-GW",
			"4196"=>"OCII"
		); */
		
		return ($StarSystem)?$StarSystem->shortCode:"-";
	}
	
	public function actionViewAttendance(){
		//SELECT * FROM `AttendanceRecords` where timeRecord LIKE '2018-08-27%' group by staffCode HAVING count(id) <= 1
		$date = Yii::app()->request->getParam('date', date('Y-m'));
		$viewType = Yii::app()->request->getParam('viewType', 'missingAttedance');
		
		$criteria=new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m') = :timeRecord");
		$criteria->params = array(
			':staffCode'=>Yii::app()->user->staffCode,
			':timeRecord'=>$date
		);
		$model = AttendanceRecords::model()->findAll($criteria);
		
		unset($criteria);
		$criteria=new CDbCriteria;
		$criteria->addCondition("type = :type");
		$criteria->params = array(
			':type'=>'attendanceRemarkStaff',
		);
		
		$ContentTable = ContentTable::model()->findAll($criteria);
		
		if($_POST){
			
		}
		
		$this->render('viewattendance',array(
			'model'=>$model,
			'staffCode'=>Yii::app()->user->staffCode,
			'ContentTable'=>$ContentTable
		));
	}
	
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AttendanceRecords;
		$model->setscenario("create");
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AttendanceRecords']))
		{
			$model->attributes=$_POST['AttendanceRecords'];
			$model->remarks = "Manually";
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AttendanceRecords']))
		{
			$model->attributes=$_POST['AttendanceRecords'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionUploadRecords(){
		
		$model=new AttendanceRecords;
		
		if(isset($_POST['AttendanceRecords']))
		{
			
			$model->attributes=$_POST['AttendanceRecords'];
			$model->uploadfiles = CUploadedFile::getInstance($model,'uploadfiles');
			if(isset($model->uploadfiles)){
			//	exit;
			try {
					Yii::import('ext.phpexcel.XPHPExcel');
					$objPHPExcel = XPHPExcel::createPHPExcel();
					$file = $model->uploadfiles->tempName;
					$name = $model->uploadfiles->name;
					$inputFileType = PHPExcel_IOFactory::identify($file);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					
					$objPHPExcel = $objReader->load($file);
					
					$objPHPExcel->setActiveSheetIndex(0);
					$sheet = $objPHPExcel->getActiveSheet(0);
					$highestRow = $sheet->getHighestRow(); 
					$highestColumn = $sheet->getHighestColumn();
					
					
					for ($row = 2; $row < $highestRow + 1; $row++) { 
						
						//if($staffCode != ""){
						$staffCode = $sheet->getCell("B" . $row)->getValue();
						$timeRecord = $sheet->getCell("G" . $row)->getValue();
						$deviceID = $sheet->getCell("E" . $row)->getValue();
						$type = $sheet->getCell("I" . $row)->getValue();
						$timeRecordTime = $sheet->getCell("G" . $row)->getValue()." ".$sheet->getCell("H" . $row)->getValue();
						
						//$data = $this->checkType($staffCode, $timeRecordTime);
						
						//Yii::log($staffCode);
						
						$criteria=new CDbCriteria;
						$criteria->addCondition("staffCode = :staffCode");
						$criteria->addCondition("deviceID = :deviceID");
						$criteria->addCondition("type = :type");
						$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
						//criteria->addCondition("timeRecord <= :timeRecordTime");
						$criteria->params = array(
							':staffCode'=>$staffCode,
							':deviceID'=>$deviceID,
							':timeRecord'=>$timeRecord,
							//':timeRecord'=>$timeRecord." ".$sheet->getCell("H" . $row)->getValue(),
							':type'=>$type,
							
						);
						
						$checkRecord = AttendanceRecords::model()->find($criteria);
						
						if($checkRecord){
							
							if($checkRecord->timeRecord != $timeRecordTime){
								$model = $this->loadModel($checkRecord->id);
								$model->timeRecord = $timeRecordTime;
								$model->save();
							}
							/*
//7,8
							if(strtolower($checkRecord->type)==strtolower('clock-in')){
								if($checkRecord->timeRecord >= $timeRecordTime){
									$model = $this->loadModel($checkRecord->id);
									$model->timeRecord = $timeRecordTime;
									$model->save();
								}
							}else{
								if($checkRecord->timeRecord <= $timeRecord){
									$model = $this->loadModel($checkRecord->id);
									$model->timeRecord = $timeRecordTime;
									$model->save();
								}
							}
*/
							
						}else{
							$model = new AttendanceRecords;
							$model->staffCode = $sheet->getCell("B" . $row)->getValue();
							$model->timeRecord = $sheet->getCell("G" . $row)->getValue()." ".$sheet->getCell("H" . $row)->getValue();
							$model->type = $sheet->getCell("I" . $row)->getValue();
							$model->deviceID = $sheet->getCell("E" . $row)->getValue();
							$model->remarks = $sheet->getCell("J" . $row)->getValue();
							//Yii::log($sheet->getCell("B" . $row)->getValue());
							if($model->save()){
								
								
								
							}else{
								Yii::app()->user->setFlash('error',$sheet->getCell("B" . $row)->getValue().'is not the vailed staff code.');
								//$this->redirect(array('AttendanceRecords/UploadRecords'));
								break;
							}
						}
						
						//AttendanceRecords::model()->deleteAll($criteria);
						
						
						/*
	$copy = $sheet->rangeToArray(
								"A".$row.":".$highestColumn.$row
							);
*/
							
							
							
							
							
						//}
						
					}
					
					/*
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcelNew, 'Excel5');
					$filename   = pathinfo($name, PATHINFO_FILENAME);
					$filename = $filename.date('YmdHis').".xls";
					header('Content-Type: application/vnd.ms-excel');
					//header('Content-Type: application/pdf');
					header('Content-Disposition: attachment;filename="'.$filename.'"');
					header('Cache-Control: max-age=0');
					header('Cache-Control: max-age=1');
					header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
					header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
					header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
					header ('Pragma: public'); // HTTP/1.0
					//ob_start();
					$objWriter->save('php://output');
					$objPHPExcelTemplate->disconnectWorksheets();
					//$objPHPExcel->disconnectWorksheets();
					unset($objPHPExcelTemplate);
					//unset($objPHPExcel);
*/
					Yii::app()->user->setFlash('success','Upload Successfuly');
					$this->redirect(array('AttendanceRecords/UploadRecords'));
					//Yii::app()->end();
					
			}catch(Exception $e) {
				//die($e->getMessage());
				Yii::app()->user->setFlash('danger',$sheet->getCell("B" . $row)->getValue().' is not the valid staff code at B'. $row);
				$this->redirect(array('AttendanceRecords/UploadRecords'));
			}
		}
			
		}
		
		$this->render('uploadrecords',array(
			'model'=>$model,
		));
	}
	
	
	public function actionExportRecord(){
		
		$model=new AttendanceRecords;
		ob_end_clean();
		if(isset($_POST['AttendanceRecords']))
		{
			
			try {
					Yii::import('ext.phpexcel.XPHPExcel');
					$objPHPExcel = XPHPExcel::createPHPExcel();
					$startDate = $_POST['AttendanceRecords']['startDate'];
					$endDate = $_POST['AttendanceRecords']['endDate'];					
					
					
					$criteria=new CDbCriteria;
					//$criteria->addCondition("staffCode = :staffCode");
					//$criteria->addCondition("deviceID = :deviceID");
					$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') between :startDate and :endDate");
					$criteria->params = array(
						':startDate'=>$startDate,
						':endDate'=>$endDate,
					);
					$model = AttendanceRecords::model()->findAll($criteria);
					
					/*
$highestRow = $sheet->getHighestRow(); 
					$highestColumn = $sheet->getHighestColumn();
*/
					
					$objPHPExcelTemplate = PHPExcel_IOFactory::load("/var/www/portal/assets/excelTemplate/blankform.xls");
					
					
					$objPHPExcelNew = XPHPExcel::createPHPExcel();
					
					foreach($objPHPExcelTemplate->getSheetNames() as $sheetName) {
						$sheetTemplate = $objPHPExcelTemplate->getSheetByName($sheetName);
						$sheetTemplate->setTitle($sheetTemplate->getTitle());
						$objPHPExcelNew->addExternalSheet($sheetTemplate);
					}
					
					
					
					$period = new DatePeriod(
					new DateTime($startDate),
					new DateInterval('P1D'),
					new DateTime($endDate)
					);
					
					
					
					$objPHPExcelNew->removeSheetByIndex($objPHPExcelNew->getIndex($objPHPExcelNew->getSheetByName('Worksheet')));
					$sheetNew = $objPHPExcelNew->getActiveSheet(0);
					
					
					foreach ($period as $key => $value) {
						$day = $value->format('d');
						$sheetNew->setCellValueByColumnAndRow($key+6, 6, $day);
					}
					foreach($model as $i=>$user){
						$sheetNew->setCellValue('A'.($i+7), $user->staffCode);
						$sheetNew->setCellValue('B'.($i+7), $user->staffCode0->surName." ".$user->staffCode0->givenName." ".$user->staffCode0->chineseName);
						
						$sheetNew->setCellValue('C'.($i+7), $user->StaffEmployment0->position->content);
						$sheetNew->setCellValue('E'.($i+7), $user->StaffEmployment0->basis->content);
						
						foreach ($period as $key => $value) {
							$day = $value->format('Y-m-d');
							$sheetNew->setCellValueByColumnAndRow($key+6, 6, $day);
						}
						
					}
					
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcelNew, 'Excel5');
					//$filename   = pathinfo($name, PATHINFO_FILENAME);
					$filename = date('YmdHis').".xls";
					header('Content-Type: application/vnd.ms-excel');
					//header('Content-Type: application/pdf');
					header('Content-Disposition: attachment;filename="'.$filename.'"');
					header('Cache-Control: max-age=0');
					header('Cache-Control: max-age=1');
					header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
					header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
					header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
					header ('Pragma: public'); // HTTP/1.0
					ob_start();
					$objWriter->save('php://output');
					$objPHPExcelTemplate->disconnectWorksheets();
					//$objPHPExcel->disconnectWorksheets();
					unset($objPHPExcelTemplate);
					//unset($objPHPExcel);
					Yii::app()->end();
					//var_dump($objPHPExcel);
					//exit;
					
			}catch(Exception $e) {
				die($e->getMessage());
			}
		}
			
		
		
		$this->render('exportrecords',array(
			'model'=>$model,
		));
	}
	
	
	
	public function actionReportLanding(){
		
		$model=new AttendanceRecords;
		
		$criteria=new CDbCriteria;
		$criteria->order = "contractID ASC";
		//$criteria->addCondition("type = :type");
		/* $criteria->params = array(
			':type'=>'attendanceRemarkStaff',
		); */
		
		$StarSystem = StarSystem::model()->findAll($criteria);
		
		$this->render('reportladning',array(
			'model'=>$model,
			'StarSystem'=>$StarSystem
			
		));
	}
	
	public function actionReport(){
		//echo Yii::app()->request->getQuery('month','123');
		if(isset($_POST['AttendanceRecords']))
		{
			
			$date = $_POST['AttendanceRecords']['month'];
			$reportType = $_POST['AttendanceRecords']['reportType'];
			$location = $_POST['AttendanceRecords']['location'];
			
			
			//Yii::app()->user->setState("models", $models);
			
			if($reportType=="L"){
				$models = $this->specialReport($date, $reportType, $location);
				$view = "Latereport";
			}
			
			if($reportType=="X"){
				$models = $this->specialReport($date, $reportType,$location);
				$view = "leavereport";
			}
			
			/* var_dump($models);
			exit; */
			
			$this->render($view,array(
				'model'=>$models,
			));
		}
		
	}
	
	public function specialReport($date, $type, $location){
		
		if($type=="L"){
			$model = $this->lateReport($date, $location);
		}
		
		if($type=="X"){
			$model = $this->leaveReport($date);
		}
		
		return $model;
	}
	
	public function leaveReport($date, $location){
		/* $criteria = new CDbCriteria;
		$criteria->with = array('staffCode0');
		//$criteria->addCondition("staffCode = :staffCode");
		//$criteria->select = "DATE_FORMAT(timeRecord, '%Y-%m-%d') as dateRecord";
		$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
		$criteria->params = array(
			//':endDate'=>$this->endDate,
			//':endDate'=>$endDate,
			':timeRecord'=>date('Y-m-d', strtotime($date)),
			
		);
		
		$criteria->group = "timeRecord ASC, staffCode0.surName ASC, staffCode0.givenName ASC";
		
		$attendances = AttendanceRecords::model()->findAll($criteria);
		
		return $attendances; */
		$Inlocation = array();
		if($location != "0"){
		
		$criteria = new CDbCriteria;
		//$criteria->select = "DATE_FORMAT(timeRecord, '%Y-%m-%d') as dateRecord";
		$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
		$criteria->addCondition("deviceID = :deviceID");
		$criteria->params = array(
			':deviceID'=>$location,
			':timeRecord'=>date('Y-m-d', strtotime($date)),
			//':timeRecord'=>date('Y-m-d', strtotime($date)),
			
		);
		$AttendanceRecords = AttendanceRecords::model()->findAll($criteria);
		
		foreach($AttendanceRecords as  $i=>$model){
			$Inlocation[] = $model->staffCode;
		}
		
		}
		unset($criteria);
		
		$criteria = new CDbCriteria;
		//$criteria->with = array('staffEmployments');
		//$criteria->addCondition("staffCode = :staffCode");
		//$criteria->select = "DATE_FORMAT(timeRecord, '%Y-%m-%d') as dateRecord";
		//$criteria->addCondition("DATE_FORMAT(attendanceRecords.timeRecord, '%Y-%m-%d') = :timeRecord");
		//$criteria->addCondition(":date <= staffEmployments.startDate");
		/* $criteria->params = array(
			//':endDate'=>$this->endDate,
			':date'=>date('Y-m-d', strtotime($date)),
			//':timeRecord'=>date('Y-m-d', strtotime($date)),
			
		); */
		
		$criteria->addNotInCondition("staffCode", array("9999999","999998"));
		if(count($Inlocation) > 0) {
			$criteria->addInCondition("staffCode", $Inlocation);
		}
		$criteria->order = "id ASC";
		$model = StaffEmployment::model()->findAll($criteria);
		return $model;
		
	}
	
	public function lateReport($date, $location){
		
		$Inlocation = array();
		if($location != "0" && $location != '99'){
		
		$criteria = new CDbCriteria;
		//$criteria->select = "DATE_FORMAT(timeRecord, '%Y-%m-%d') as dateRecord";
		$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
		$criteria->addCondition("deviceID = :deviceID");
		$criteria->params = array(
			':deviceID'=>$location,
			':timeRecord'=>date('Y-m-d', strtotime($date)),
			//':timeRecord'=>date('Y-m-d', strtotime($date)),
			
		);
		$AttendanceRecords = AttendanceRecords::model()->findAll($criteria);
		
		foreach($AttendanceRecords as  $i=>$model){
			$Inlocation[] = $model->staffCode;
		}

		}
		unset($criteria);
		//echo $location;
		//exit;
		if($location == "99"){
		//exit;
		$criteria = new CDbCriteria;
		//$criteria->select = "DATE_FORMAT(timeRecord, '%Y-%m-%d') as dateRecord";
		$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
		
		$criteria->params = array(
			//':deviceID'=>$location,
			':timeRecord'=>date('Y-m-d', strtotime($date)),
			//':timeRecord'=>date('Y-m-d', strtotime($date)),
			
		);
		$criteria->addNotInCondition("deviceID", array('1','2'));
		$AttendanceRecords = AttendanceRecords::model()->findAll($criteria);
		
		foreach($AttendanceRecords as  $i=>$model){
			$Inlocation[] = $model->staffCode;
		}

		}
		//var_dump($Inlocation);
		//exit;
		unset($criteria);
		
		$criteria = new CDbCriteria;
		//$criteria->with = array('staffEmployments');
		//$criteria->addCondition("staffCode = :staffCode");
		//$criteria->select = "DATE_FORMAT(timeRecord, '%Y-%m-%d') as dateRecord";
		//$criteria->addCondition("DATE_FORMAT(attendanceRecords.timeRecord, '%Y-%m-%d') = :timeRecord");
		//$criteria->addCondition("DATE_FORMAT(staffEmployments.startDate, '%Y-%m-%d') <= :date");
		//$criteria->addCondition(":date between staffEmployments.startDate and staffEmployments.endDate");
		
		$criteria->params = array(
			//':endDate'=>$this->endDate,
			//':date'=>date('Y-m-d', strtotime($date)),
			//':timeRecord'=>date('Y-m-d', strtotime($date)),
			
		);
		$criteria->addNotInCondition("staffCode", array("9999999","999998"));
		if(count($Inlocation) > 0) {
			$criteria->addInCondition("staffCode", $Inlocation);
		}
		$criteria->order = "id ASC";
		$model = StaffEmployment::model()->findAll($criteria);
		return $model;
		//return $attendances;
		
	}
	
	public function findStaffTimeslot($staffCode, $date){
		//Yii::log($staffCode);
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("status = :status");
		$criteria->addCondition(":date between startDate and endDate");
		
		$criteria->params = array(
			':staffCode'=>$staffCode,
			':status'=>'ACTIVE',
			':date'=>date('Y-m-d', strtotime($date))
			
		);
		
		$model = TimeSlotStaff::model()->find($criteria);
		
		unset($criteria);
		$slots = array();
		if($model){
		$groupID = $model->timeSlotGroup;
		
		$criteria = new CDbCriteria;
		$criteria->with = array('timeSlot0');
		$criteria->addCondition("timeSlotGroup = :timeSlotGroup");
		$criteria->addCondition("find_in_set(:timeSlot0,timeSlot0.days) > 0");
		//find_in_set($needle,'column') > 0
		$criteria->params = array(
			':timeSlotGroup'=>$groupID,
			':timeSlot0'=>date('N', strtotime($date)),
		);
		$TimeSlotAissigment = TimeSlotAissigment::model()->findAll($criteria);
		
		
		foreach($TimeSlotAissigment as $i=>$timeslot){
		
		if(date('N', strtotime($date))==6){
		if(count($TimeSlotAissigment) > 1){
			if($i==0){
				$slots[] = $timeslot->timeSlot0->startTime;
			}else{

				$slots[] = $timeslot->timeSlot0->endTime;
			}
		}else{
			if($i==0){
				$slots[] = $timeslot->timeSlot0->startTime;
				$slots[] = $timeslot->timeSlot0->endTime;
			}
		}
			

		}else{
			if(count($TimeSlotAissigment) > 1){
			if($i==0){
				$slots[] = $timeslot->timeSlot0->startTime;
			}else{

				$slots[] = $timeslot->timeSlot0->endTime;
			}
			}else{
				if($i==0){
				$slots[] = $timeslot->timeSlot0->startTime;
				$slots[] = $timeslot->timeSlot0->endTime;
				}
			}
		}
		}
		}
		//Yii::log(var_dump($slots));
		return $slots;
	}
	
	public function leaveRecord($model){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition(":date between startDate and endDate");
		$criteria->params = array(
			//':endDate'=>$this->endDate,
			':date'=>date('Y-m-d', strtotime($model->timeRecord)),
			':staffCode'=>$model->staffCode
			
		);
		
		$leaveRecords = LeaveApplication::model()->findAll($criteria);
		
		
		return $leaveRecords;
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('AttendanceRecords');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AttendanceRecords('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AttendanceRecords']))
			$model->attributes=$_GET['AttendanceRecords'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AttendanceRecords the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AttendanceRecords::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AttendanceRecords $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='attendance-records-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	public function checkType($staffCode, $timeRecord){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("status = :status");
		$criteria->addCondition(":timeRecord between startDate and endDate");
		//$criteria->addCondition("startDate <= (select max(startDate) from timeSlotStaff where staffCode = :staffCode and status = :status)");
		$criteria->params = array(
			':staffCode'=>$staffCode,
			':status'=>'ACTIVE',
			':timeRecord'=>$timeRecord
		);
		$criteria->limit = "1";
		$stafftimeSlot = TimeSlotStaff::model()->find($criteria);
		$timeSlotGroup = $stafftimeSlot->timeSlotGroup;
		
		unset($criteria);
		$criteria = new CDbCriteria;
		$criteria->with = array("timeSlot0","timeSlotGroup0","timeSlotStaff");
		//$criteria->addCondition("t.createDate <= :createDate");
		//$criteria->addCondition("timeSlotStaff.createDate <= :timeSlotStaffcreateDate");
		$criteria->addCondition("t.timeSlotGroup = :timeSlotGroup");
		//$criteria->addCondition("timeSlot0.startTime <= :startTime");
		//$criteria->addCondition("timeSlot0.endTime >= :startTime");
		$criteria->params = array(
			//':createDate'=>$timeRecord,
			//':timeSlotStaffcreateDate'=>$timeRecord,
			':timeSlotGroup'=>$timeSlotGroup,
			//':startTime'=>$timeRecord,
			//':startTime'=>$timeRecord,
			
		);
		//Yii::log($criteria);
		$TimeSlotAissigment = TimeSlotAissigment::model()->findAll($criteria);
		
		foreach($TimeSlotAissigment as $i=>$d){
			
			//var_dump($d->timeSlot0->startTime);
		}
		
		return $TimeSlotAissigment;
		
	}
	
	public function isFirstClockIn($staffCode, $timeRecord){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("lower(type) = :type");
		$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
		$criteria->params = array(
			":staffCode"=>$staffCode,
			":type"=>'clock-in',
			":timeRecord"=>date('Y-m-d', strtotime($timeRecord)),
		);
		$criteria->order = "timeRecord ASC";
		$criteria->limit = "1";
		
		$model = AttendanceRecords::model()->find($criteria);
		
		
		
		return $model;
	}
	
	
	public function fristClockOut($staffCode, $timeRecord){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("LOWER(type) = :type");
		$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
		$criteria->params = array(
			":staffCode"=>$staffCode,
			":type"=>'clock-out',
			":timeRecord"=>date('Y-m-d', strtotime($timeRecord)),
		);
		$criteria->order = "timeRecord ASC";
		$criteria->limit = "1";
		
		$model = AttendanceRecords::model()->find($criteria);
		
		
		return $model;
	}
	
	
	public function checkSpecial($staffCode, $date){
		
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
	
	
	if($LeaveApplication){
		
		foreach($LeaveApplication as $i=>$leave){
			
		}
		
	}	
		
	}
	
	public function actionMissingAttendance(){
		
		$user = Users::model()->findAll();
		foreach($user as  $i=>$staff){
			$users[] = $staff->staffCode;
		}
		
		$criteria = new CDbCriteria;
		//$criteria->with = array('user');
		//$criteria->together = true;
		
		//$criteria->addCondition(":date between startDate and endDate");
		//$criteria->addCondition("endDate1 is not null or :date between startDate and endDate");
		$criteria->params = array(
			//':date'=>date('Y-m-d H:i:s')
		);
		$criteria->addInCondition("staffCode", $users);
		$criteria->addNotInCondition("staffCode", array('9999999','999998','229','242'));
		$model = StaffEmployment::model()->findAll($criteria);
		
		
		$previous_week = date("Y-m-d", strtotime("last week friday"));
		$period = new DatePeriod(new DateTime($previous_week),new DateInterval('P1D'),new DateTime());
		//echo $previous_week;
		foreach($model as $i=>$staff){
		
		if($staff->endDate == "" || (date('Y-m-d') >= $staff->startDate && date('Y-m-d') <= $staff->endDate)){
		
		foreach($period as $j=>$value){
		//var_dump($this->isLate($staff, $value->format('Y-m-d')));
			if(	date('N', strtotime($value->format('Y-m-d'))) < 7 
				&& !$this->isLeave($staff, $value->format('Y-m-d')) 
				&& $this->isLate($staff, $value->format('Y-m-d'))
				&& !$this->hasRemark($staff, $value->format('Y-m-d'))
				//&& $value->format('Y-m-d') == '2018-11-02'
				){
				echo $staff->staffCode." ".$value->format('Y-m-d (D)').'<br>';
			}
		}
		}
		}
		/*
			date('N', strtotime($value->format('Y-m-d'))) < 7 
				&& !$this->isHoliday($staff,$value->format('Y-m-d')) 
				&& !$this->isLeave($staff, $value->format('Y-m-d')) 
				&& !$this->hasRemark($staff, $value->format('Y-m-d')) 
				&& 
		*/
		//echo count($model);
	}
	
	public function isLate($model, $date){
		$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("lower(type) = :type");
	$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
	$criteria->params = array(
		':type'=>'clock-in',
		':staffCode'=>$model->staffCode,
		':timeRecord'=>$date,
		
	);
	$attendances = AttendanceRecords::model()->find($criteria);
	
	if(!$attendances){
		return true;
	}else{
		$timeslot = $this->findStaffTimeslot($model->staffCode, $attendances->timeRecord);
		if(count($timeslot) > 0){
		if($timeslot[0] < date("H:i:s", strtotime($attendances->timeRecord))){
			return true;
		}else{
			return false;
		}
		}else{
			return false;
		}
	}
	
	}
	
	public function hasRemark($model, $date){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition(":date = DATE_FORMAT(timeRecord, '%Y-%m-%d')");
		$criteria->addCondition("remark != ''");
	$criteria->params = array(
		':staffCode'=>$model->staffCode,
		':date'=>$date
		
	);
		$remark = AttendanceRemarks::model()->find($criteria);
		
		if($remark){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function isLeave($model, $date){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->addCondition("status = :status");
		$criteria->addCondition(":date between startDate and endDate");
	
	$criteria->params = array(
		':staffCode'=>$model->staffCode,
		':status'=>'ACTIVE',
		':date'=>$date
		
	);
	
	$LeaveApplication = LeaveApplication::model()->find($criteria);
	if($LeaveApplication){
		$datetime1 = new DateTime($LeaveApplication->startDate);
		$datetime2 = new DateTime($LeaveApplication->endDate);
		$interval1 = $datetime1->diff($datetime2);
		$interval = $interval1->format('%a');
		$startDateType = $LeaveApplication->startDateType;
		$endDateType = $LeaveApplication->endDateType;
		
		
		
		if($interval >= 1){
			return true;
		}else{
			if($startDateType=="AM" && $endDateType == "AM"){
					return "AM";
			}
			if($startDateType=="PM" && $endDateType == "PM"){
					return "PM";
				}
				if($startDateType=="ALL" && $endDateType == "ALL"){
					return true;
				}
				if($startDateType=="AM" && $endDateType == "PM"){
					return true;
				}
		}
		}else{
			return false;
		}
	
	}
	
	public function isHoliday($model, $date){
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
		unset($criteria1);	
		if($isholiday){
		
			return true;
			
		}else{
			if($model->AlternateGroup0){
				if(date('N', strtotime($date)) == 6){
					
					$criteria1 = new CDbCriteria;
					$criteria1->addCondition("dutyDate = :dutyDate");
					$criteria1->addCondition("groupID = :groupID");
					$criteria1->params = array(
						':dutyDate'=>$date,
						':groupID'=>$model->AlternateGroup0->alternateGroupID,
					);
					$AlternateDuty = AlternateDuty::model()->find($criteria1);
					if($AlternateDuty){
						return false;
					}else{
						return true;
					}
				}
			}
			
		}
	}
	
	
	
	
}
