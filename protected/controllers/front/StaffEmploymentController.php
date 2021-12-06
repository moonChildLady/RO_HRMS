<?php

class StaffEmploymentController extends Controller
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
				'actions'=>array('admin','delete','index','view','create','update'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	} */

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($StaffCode)
	{
		
		
		$this->render('view',array(
			'model'=>$this->loadModelByStaffCode($StaffCode),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new StaffEmployment;
		
		$StaffModel = new Staff;
		$groupModel = new AlternateGroup;
		$timeSlotModel = new TimeSlotStaff;
		$AlternateGroupModel = new AlternateGroup;
		$CWRModel = new CWRStaff;
		$DepartmentModel = new Department;
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
		//$this->performAjaxValidation($StaffModel);

		if(isset($_POST['StaffEmployment']))
		{
			$model->attributes=$_POST['StaffEmployment'];
			$StaffModel->attributes=$_POST['Staff'];
			$groupModel->attributes=$_POST['AlternateGroup'];
			$timeSlotModel->attributes=$_POST['TimeSlotStaff'];
			$DepartmentModel->attributes=$_POST['Department'];
			
			$valid=$model->validate();
			$valid=$StaffModel->validate() && $valid;
			if($_POST['StaffEmployment']['endDate']==""){
				$model->endDate = new CDbExpression('NULL'); 
			}
			
			
			
			if($valid){
				
				$StaffModel->save();
				$model->staffCode = $StaffModel->staffCode;
				$model->save();
				$groupModel->staffCode = $StaffModel->staffCode;
				$groupModel->groupID = $_POST['AlternateGroup']['groupID'];
				$groupModel->alternateGroupID = $_POST['AlternateGroup']['alternateGroupID'];
			
				$groupModel->save();
				if($_POST['StaffEmployment']['createPortalAccount'] == "1"){
					$usersModel = new Users('create');
					//create
					$usersModel->staffCode = $model->staffCode;
					$usersModel->password = md5($_POST['StaffEmployment']['password']);
					$usersModel->resigned = 'NO';
					$usersModel->save();
				}
				
				$leaveBalance = new LeaveBalance;
				$leaveBalance->staffCode = $model->staffCode;
				$leaveBalance->balanceDate = $model->startDate;
				$leaveBalance->balance = $_POST['StaffEmployment']['balance'];
				$leaveBalance->save();
				if($_POST['TimeSlotStaff']['timeSlotGroup']!=""){
				$timeSlotModel->staffCode = $model->staffCode;
				$timeSlotModel->timeSlotGroup = $_POST['TimeSlotStaff']['timeSlotGroup'];
				$timeSlotModel->startDate = $_POST['StaffEmployment']['startDate']." 00:00:00";
				$timeSlotModel->endDate = '2999-12-31 23:59:59';
				$timeSlotModel->status = "ACTIVE";
				$timeSlotModel->save();
				}
				$AlternateGroupModel->staffCode = $model->staffCode;
				$AlternateGroupModel->groupID = $_POST['AlternateGroup']['groupID'];
				$AlternateGroupModel->alternateGroupID = $_POST['AlternateGroup']['alternateGroupID'];
				$AlternateGroupModel->currentYear = date('Y', strtotime($_POST['StaffEmployment']['startDate']));
				$AlternateGroupModel->save();
				
				
				
				if($_POST['CWRStaff']['cwr']!=""){
					$CWRModel->cwr = $_POST['CWRStaff']['cwr'];
					if($_POST['CWRStaff']['cwrDate']==""){
						$CWRModel->cwrDate = new CDbExpression('NULL');
					}else{
						$CWRModel->cwrDate = $_POST['CWRStaff']['cwrDate'];
					}
					$CWRModel->whiteCard = $_POST['CWRStaff']['whiteCard'];
					if($_POST['CWRStaff']['whiteCardDate']==""){
						$CWRModel->whiteCardDate = new CDbExpression('NULL');
					}else{
						$CWRModel->whiteCardDate = $_POST['CWRStaff']['whiteCardDate'];
					}
					
					$CWRModel->greenCard = $_POST['CWRStaff']['greenCard'];
					if($_POST['CWRStaff']['greenCardDate']==""){
						$CWRModel->greenCardDate = new CDbExpression('NULL');
					}else{
						$CWRModel->greenCardDate = $_POST['CWRStaff']['greenCardDate'];
					}
					
					$CWRModel->staffCode = $model->staffCode;
					$CWRModel->save();
				}
				
				$DepartmentModel->staffCode = $model->staffCode;
				$DepartmentModel->companyID = $_POST['Department']['companyID'];
				$DepartmentModel->departmentID = $_POST['Department']['departmentID'];
				$DepartmentModel->divisionID = $_POST['Department']['divisionID'];
				$DepartmentModel->save();
				
				Yii::app()->user->setFlash('success', "Record Saved!");
				//$this->redirect(array('update','StaffCode'=>$model->staffCode));
				$this->redirect(array('admin'));
			}
			/* if($model->save())
				$this->redirect(array('view','id'=>$model->id)); */
		}

		$this->render('create',array(
			'model'=>$model,
			'StaffModel'=>$StaffModel,
			'groupModel'=>$groupModel,
			'timeSlotModel'=>$timeSlotModel,
			'AlternateGroupModel'=>$AlternateGroupModel,
			'CWRModel'=>$CWRModel,
			'DepartmentModel'=>$DepartmentModel,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($StaffCode)
	{
		$model=$this->loadModelByStaffCode($StaffCode);
		if($model->balance0){
			$model->balance = $model->balance0->balance;
		}
		
		$StaffModel=$this->loadModelByStaffCodeStaff($StaffCode);
		
		
		
		if($this->loadModelByCWRCodeStaff($StaffCode)){
			$CWRModel=$this->loadModelByCWRCodeStaff($StaffCode);
		}else{
			$CWRModel = new CWRStaff;
		}
		
		
		$timeSlotModel = $this->loadModelByStaffCodeTimeSlot($StaffCode);
		
		$DepartmentModel = $this->loadModelByDepartmentStaff($StaffCode);
		
		
		
		//$AlternateGroupModel = $this->loadModelByAlternateGroup($StaffCode);
		
		$groupModel = $this->loadModelByStaffCodeGroup($StaffCode,  date('Y'));
		if($groupModel){
			$groupModel = $this->loadModelByStaffCodeGroup($StaffCode,  date('Y'));
		}else{
			$groupModel = new AlternateGroup;
		}
		
		if($timeSlotModel){
				$timeSlotModel = $this->loadModelByStaffCodeTimeSlot($StaffCode);
		}else{
			$timeSlotModel = new TimeSlotStaff;
		}
		if($DepartmentModel){
				$DepartmentModel = $this->loadModelByDepartmentStaff($StaffCode);
		}else{
			$DepartmentModel = new Department;
		}
		
		
		
		/*
if($AlternateGroupModel){
				$AlternateGroupModel = $this->loadModelByAlternateGroup($StaffCode);
		}else{
			$AlternateGroupModel = new AlternateGroup;
		}
*/
		//$StaffModel = $this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['StaffEmployment']))
		{
			
			
		
			$model->attributes=$_POST['StaffEmployment'];
			$StaffModel->attributes=$_POST['Staff'];
			$groupModel->attributes=$_POST['AlternateGroup'];
			$timeSlotModel->attributes=$_POST['TimeSlotStaff'];
			//$AlternateGroupModel->attributes=$_POST['AlternateGroup'];
			$DepartmentModel->attributes=$_POST['Department'];
			
			
			$valid= $model->validate();
			$valid= $StaffModel->validate() && $valid;
			
			
			if($_POST['StaffEmployment']['endDate']==""){
				$model->endDate = new CDbExpression('NULL'); 
			}
			
			
			
			if($valid){
				
				$StaffModel->save();
				$model->staffCode = $StaffModel->staffCode;
				$model->save();
				
				/* if($groupModel){
					//$groupModel->staffCode = $StaffModel->staffCode;
					$groupModel->groupID = $_POST['AlternateGroup']['groupID'];
					$groupModel->currentYear = date('Y', strtotime($model->startDate));
					$groupModel->alternateGroupID = $_POST['AlternateGroup']['alternateGroupID'];
					$groupModel->save();
				}else{
					
				} */
				$groupModel->staffCode = $StaffModel->staffCode;
				$groupModel->groupID = $_POST['AlternateGroup']['groupID'];
				$groupModel->currentYear = date('Y');
				$groupModel->alternateGroupID = $_POST['AlternateGroup']['alternateGroupID'];
				$groupModel->save();
				
				
				if(isset($_POST['StaffEmployment']['createPortalAccount'])){
				if($_POST['StaffEmployment']['createPortalAccount'] == "1"){
					$usersModel = new Users('create');
					//create
					$usersModel->staffCode = $model->staffCode;
					$usersModel->password = md5($_POST['StaffEmployment']['password']);
					$usersModel->resigned = 'NO';
					$usersModel->save();
				}
				}
				if($_POST['TimeSlotStaff']['timeSlotGroup']!=""){
				$timeSlotModel->staffCode = $model->staffCode;
				$timeSlotModel->timeSlotGroup = $_POST['TimeSlotStaff']['timeSlotGroup'];
				$timeSlotModel->startDate = $_POST['StaffEmployment']['startDate']." 00:00:00";
				$timeSlotModel->endDate = '2999-12-31 23:59:59';
				$timeSlotModel->status = "ACTIVE";
				$timeSlotModel->save();
				}
				//if($_POST['CWRStaff']['cwr']!=""){
					$CWRModel->cwr = $_POST['CWRStaff']['cwr'];
					if($_POST['CWRStaff']['cwrDate']==""){
						$CWRModel->cwrDate = new CDbExpression('NULL');
					}else{
						$CWRModel->cwrDate = $_POST['CWRStaff']['cwrDate'];
					}
					$CWRModel->whiteCard = $_POST['CWRStaff']['whiteCard'];
					if($_POST['CWRStaff']['whiteCardDate']==""){
						$CWRModel->whiteCardDate = new CDbExpression('NULL');
					}else{
						$CWRModel->whiteCardDate = $_POST['CWRStaff']['whiteCardDate'];
					}
					
					$CWRModel->greenCard = $_POST['CWRStaff']['greenCard'];
					if($_POST['CWRStaff']['greenCardDate']==""){
						$CWRModel->greenCardDate = new CDbExpression('NULL');
					}else{
						$CWRModel->greenCardDate = $_POST['CWRStaff']['greenCardDate'];
					}
					
					$CWRModel->staffCode = $model->staffCode;
					$CWRModel->save();
				//}
				
				$DepartmentModel->staffCode = $model->staffCode;
				$DepartmentModel->companyID = $_POST['Department']['companyID'];
				$DepartmentModel->departmentID = $_POST['Department']['departmentID'];
				$DepartmentModel->divisionID = $_POST['Department']['divisionID'];
				$DepartmentModel->save();
				Yii::app()->user->setFlash('success', "Updated!");
				$this->redirect(array('update','StaffCode'=>$model->staffCode));
				
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'StaffModel'=>$StaffModel,
			'groupModel'=>$groupModel,
			'timeSlotModel'=>$timeSlotModel,
			'CWRModel'=>$CWRModel,
			'DepartmentModel'=>$DepartmentModel,
		));
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
		$dataProvider=new CActiveDataProvider('StaffEmployment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StaffEmployment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StaffEmployment']))
			$model->attributes=$_GET['StaffEmployment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StaffEmployment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StaffEmployment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelByStaffCode($StaffCode)
	{
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("StaffCode = :StaffCode");
		$criteria->params = array(
			':StaffCode'=>$StaffCode,
		);
		$model=StaffEmployment::model()->find($criteria);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelByDepartmentStaff($StaffCode)
	{
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>$StaffCode,
		);
		$model=Department::model()->find($criteria);
		/* if($model===null)
			throw new CHttpException(404,'The requested page does not exist.'); */
		return $model;
	}
	
	public function loadModelByCWRCodeStaff($StaffCode)
	{
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>$StaffCode,
		);
		$model=CWRStaff::model()->find($criteria);
		/* if($model===null)
			throw new CHttpException(404,'The requested page does not exist.'); */
		return $model;
	}
	
	public function loadModelByStaffCodeStaff($StaffCode)
	{
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("StaffCode = :StaffCode");
		$criteria->params = array(
			':StaffCode'=>$StaffCode,
		);
		$model=Staff::model()->find($criteria);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelByStaffCodeGroup($StaffCode, $currentYear=null)
	{
		if($currentYear==null){
			$currentYear=date('Y');
		}
		$criteria = new CDbCriteria;
		$criteria->addCondition("StaffCode = :StaffCode");
		$criteria->addCondition("currentYear = :currentYear");
		$criteria->params = array(
			':StaffCode'=>$StaffCode,
			':currentYear'=>$currentYear,
		);
		$model=AlternateGroup::model()->find($criteria);
		if($model===null){
			return false;
		}else{
			//throw new CHttpException(404,'The requested page does not exist.');
		return $model;
		}
	}
	
	public function loadModelByStaffCodeTimeSlot($StaffCode)
	{
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("StaffCode = :StaffCode");
		$criteria->params = array(
			':StaffCode'=>$StaffCode,
		);
		$model=TimeSlotStaff::model()->find($criteria);
		if($model===null){
			return false;
		}else{
			//throw new CHttpException(404,'The requested page does not exist.');
		return $model;
		}
	}
	
	public function loadModelByAlternateGroup($StaffCode)
	{
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("StaffCode = :StaffCode");
		$criteria->params = array(
			':StaffCode'=>$StaffCode,
		);
		$model=AlternateGroup::model()->find($criteria);
		if($model===null){
			return false;
		}else{
			//throw new CHttpException(404,'The requested page does not exist.');
		return $model;
		}
	}

	/**
	 * Performs the AJAX validation.
	 * @param StaffEmployment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='staff-employment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionexport(){
		

			ob_end_clean();
			Yii::import('ext.phpexcel.XPHPExcel');
		$objPHPExcel= XPHPExcel::createPHPExcel();
		$objPHPExcel->getProperties()->setCreator(Yii::app()->params['companyName'])
				->setLastModifiedBy(Yii::app()->params['companyName'])
				->setTitle("Staff")
				->setSubject("Staff")
				->setDescription("Staff")
				->setKeywords("Staff")
				->setCategory("Staff");
			
			
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', "STAFF NO")
				->setCellValue('B1', "FULLNAME")
				->setCellValue('C1', "NAME_C")
				->setCellValue('D1', "NICKNAME")
				->setCellValue('E1', "MOBILE")
				->setCellValue('F1', "HKID")
				->setCellValue('G1', "CWR")
				->setCellValue('H1', "EMAIL")
				->setCellValue('I1', "START DATE")
				->setCellValue('J1', "END DATE")
				->setCellValue('K1', "DOB")
				->setCellValue('L1', "BASIS")
				->setCellValue('M1', "POSITION")
				->setCellValue('N1', "GROUP")
				->setCellValue('O1', "Alternate")
				->setCellValue('P1', "STATUS")
				->setCellValue('Q1', "COMPANY")
				->setCellValue('R1', "DEPARTMENT")
				->setCellValue('S1', "DIVISION")
				->setCellValue('T1', "Approver 1")
				->setCellValue('U1', "Approver 2")
				->setCellValue('V1', "Approver 3");
				//->setCellValue('L1', "DOB");
				
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
		$StaffEmployment = StaffEmployment::model()->findAll($criteria);
		//$j=0;
		//$bal = $this->getTotalBal($staffCode);
		$durition = 0;
		$countLetter = array(
			"T",
			"U",
			"V"
		);
		foreach($StaffEmployment as $i=>$data){
			
			
			
		
		if($data->endDate !="" && date('Y-m-d H:i:s') >= $data->endDate ){
			$currStatus = "terminated";
		}else{
			$currStatus = "current";
		}
			
			$new_sheet->setCellValue("A".($i+2), $data->staffCode0->staffCode);
			$new_sheet->setCellValue("B".($i+2), $data->staffCode0->Fullname);
			$new_sheet->setCellValue("C".($i+2), $data->staffCode0->chineseName);
			$new_sheet->setCellValue("D".($i+2), $data->staffCode0->nickName);
			$new_sheet->setCellValue("E".($i+2), $data->staffCode0->mobilePhone);
			//$new_sheet->setCellValue("F".($i+2), ($data->staffCode0->HKID!="")?str_repeat('*', 2).substr($data->staffCode0->HKID, 2, -2).str_repeat('*', 2):"");
			$new_sheet->setCellValue("F".($i+2), $data->staffCode0->HKID);
			$new_sheet->setCellValue("G".($i+2), ($data->staffCode0->CWRStaff0)?$data->staffCode0->CWRStaff0->cwr:"");
			$new_sheet->setCellValue("H".($i+2), $data->staffCode0->email);
			$new_sheet->setCellValue("I".($i+2), $data->startDate);
			$new_sheet->setCellValue("J".($i+2), $data->endDate);
			$new_sheet->setCellValue("K".($i+2), $data->staffCode0->dob);
			$new_sheet->setCellValue("L".($i+2), $data->basis->content);
			$new_sheet->setCellValue("M".($i+2), $data->position->content);
			$new_sheet->setCellValue("N".($i+2), ($data->AlternateGroup0)?$data->AlternateGroup0->GroupName0->content:"");
			$new_sheet->setCellValue("O".($i+2), ($data->AlternateGroup1)?$data->AlternateGroup1->alternateGroupName:"");
			$new_sheet->setCellValue("P".($i+2), $currStatus);
			$new_sheet->setCellValue("Q".($i+2), ($data->department0&&$data->department0->companyID!="0")?$data->department0->company0->content:"N/A");
			$new_sheet->setCellValue("R".($i+2), ($data->department0&&$data->department0->departmentID!="0")?$data->department0->department0->content:"N/A");
			$new_sheet->setCellValue("S".($i+2), ($data->department0&&$data->department0->divisionID!="0")?$data->department0->division0->content:"N/A");
			
			foreach($this->getApprover($data->staffCode) as $j=>$approver){ 
				if($approver){
					$new_sheet->setCellValue($countLetter[$j].($i+2), $approver->approver0->staffCode."-".$approver->approver0->Fullname);
				}
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
		

		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L &C '.Yii::app()->params['companyName'].' &R '.date('Y-m-d H:i:s'));
		$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1); 
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L Student Preferences');
		
		
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&C Page &P of &N &R');
		//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setEvenFooter('&R Page &P / &N');
 
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$filename = 'all_STAFF_record'.date('YmdHis').".xls";
		
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
	
	
}
