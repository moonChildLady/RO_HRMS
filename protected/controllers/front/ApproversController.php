<?php

class ApproversController extends RController
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model=new Approvers;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Approvers']))
		{
			$model->attributes=$_POST['Approvers'];
			$model->endDate = '2999-12-31 23:59:59';
			if($model->save()){
				Yii::app()->user->setFlash('success', "<strong>Success!</strong> Update Successfully.");
				$this->redirect(array('manageApprover'));
			}
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
		$old_approver = $model->approver;
		if(isset($_POST['Approvers']))
		{
		
			
			$model->attributes=$_POST['Approvers'];
			
			
			if($_POST['Approvers']['deleteApprover']=="1"){
				//$old_approver->
				$newDate = new DateTime();
				$newDate->modify('-1 day');
				$model->endDate = $newDate->format('Y-m-d')." 23:59:59";
				$model->save();
				$this->redirect(array('manageApprover'));
				Yii::app()->end;
			}
			
			if($old_approver != $_POST['Approvers']['approver']){
			/*
$criteria = new CDbCriteria;
			$criteria->addCondition("staffCode = :staffCode");
			$criteria->addCondition("approver = :approver");
			$criteria->addCondition(":date between startDate and endDate");
			$criteria->params = array(
				":staffCode"=>$_POST['Approvers']['staffCode'],
				":approver"=>$_POST['Approvers']['approver'],
				':date'=>$_POST['Approvers']['startDate']
			);
			$appover = Approvers::model()->find($criteria);
			if($appover){
				$newDate = new DateTime($_POST['Approvers']['startDate']);
				$newDate->modify('-1 day');
				$appover->endDate = $newDate->format('Y-m-d H:i:s');
				if($appover->save()){
					//var_dump($appover->getErrors());
					//exit;
				}
			}
*/
						
			$newApprover = new Approvers;
			$newApprover->staffCode = $_POST['Approvers']['staffCode'];
			$newApprover->approver = $_POST['Approvers']['approver'];
			$newApprover->position = $_POST['Approvers']['position'];
			$newApprover->startDate = $_POST['Approvers']['startDate'];
			$newApprover->endDate = '2999-12-31 23:59:59';
			$newApprover->save();
			//$this->redirect(array('admin'));
			}
			$newDate = new DateTime($_POST['Approvers']['startDate']);
			$newDate->modify('-1 day');
			$model->endDate = $newDate->format('Y-m-d H:i:s');
			$model->approver = $old_approver;
			if($model->save()){
				$this->redirect(array('manageApprover'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('Approvers');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Approvers('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Approvers']))
			$model->attributes=$_GET['Approvers'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionManageApprover(){
		
		$criteria2 = new CDbCriteria;
		/* $criteria2->addCondition("staffCode = :staffCode");
		$criteria2->params = array(
			':staffCode'=>$balance->staffCode,
		); */
		$model = StaffEmployment::model()->findAll($criteria2);
		$array = array();
		foreach($model as $i=>$StaffEmployment ){
		if($StaffEmployment->endDate !="" && date('Y-m-d H:i:s') >= $StaffEmployment->endDate ){
			
		}else{
			$array[] = $StaffEmployment->staffCode;
			//$currStatus = "current";
		}
		}
		
		$criteria = new CDbCriteria;
		$criteria->addNotInCondition("staffCode", array("9999999","999998","9999997"));
		$criteria->addInCondition("staffCode", $array);
		$criteria->order = "id ASC";
		$model = StaffEmployment::model()->findAll($criteria);
		
		$this->render('manageapprover',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdateApprover($staffCode){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffcode");
		//$criteria->addCondition(":date between startDate and endDate");
		$criteria->params = array(
			':staffcode'=>$staffCode,
			//':date'=>date('Y-m-d')
		);
		//$criteria->limit = "3";
		$criteria->order = "position ASC";
		$model = Approvers::model()->findAll($criteria);
		
		
		if($_POST){
			var_dump($_POST);
			exit;
			foreach($_POST['ApproverPostion'] as $i=>$approver){
				if($_POST['ApproverOld'][$i] != $_POST['Approver'][$i]){
			$newApprover = new Approvers;
			$newApprover->staffCode = $staffCode;
			$newApprover->approver = $_POST['Approver'][$i];
			$newApprover->position = $_POST['ApproverPostionOld'][$i];
			$newApprover->startDate = date('Y-m-d');
			$newApprover->endDate = '2999-12-31 23:59:59';
			$newApprover->save();
			//$this->redirect(array('admin'));
			$oldModel = $this->loadModel($_POST['model'][$i]);
			$newDate = new DateTime(date('Y-m-d'));
			$newDate->modify('-1 day');
			$oldModel->endDate = $newDate->format('Y-m-d H:i:s');
			$oldModel->save();
			//$model->approver = $old_approver;

				}
			}
			
		}
		
		
		$this->render('updateapprover',array(
			'model'=>$model,
			'staff'=>$this->loadStaff($staffCode)
		));
	}
	
	public function getApprover($staffCode){
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffcode");
		$criteria->addCondition(":date between startDate and endDate");
		$criteria->params = array(
			':staffcode'=>$staffCode,
			':date'=>date('Y-m-d H:i:s')
		);
		$criteria->limit = "3";
		$criteria->order = "position ASC";
		$model = Approvers::model()->findAll($criteria);
		
		return $model;
	}
	
	public function loadStaff($staffCode){
	
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffcode");
		$criteria->params = array(
			':staffcode'=>$staffCode
		);
		
		$model = StaffEmployment::model()->find($criteria);
		
		return $model;
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Approvers the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Approvers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Approvers $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='approvers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
