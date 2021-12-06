<?php

class AttendanceRemarksController extends RController
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
			'rights', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	

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
		$model=new AttendanceRemarks;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AttendanceRemarks']))
		{
			$model->attributes=$_POST['AttendanceRemarks'];
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionCreateRemarkPersonal(){
		if(isset($_POST))
		{
			$model=new AttendanceRemarks;
			$model->staffCode = $_POST['staffcode'];
			$model->timeRecord = date('Y-m-d H:i:s', strtotime($_POST['date']));
			$model->reasonID =$_POST['reason'];
			$model->remark =$_POST['remark'];
			$model->adminInput ='NO';
			$model->createdBy =Yii::app()->user->getState('staffCode');
			if($model->save()){
			
			$reasonContent = ContentTable::model()->findByPK($model->reasonID);
				echo CJSON::encode(array(
					'remark'=>$_POST['remark'], 
					'date'=>date('Y-m-d', strtotime($model->timeRecord)),
					'reason'=>$reasonContent->content
				));
				Yii::app()->end();
			}
			
			Yii::app()->end();
			
			
		}
	}
	
	public function actionCreateRemark()
	{
		

		if(isset($_POST))
		{
		$criteria = new CDbCriteria;
		$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
		$criteria->addCondition("staffCode = :staffCode");
		//$criteria->addCondition("adminInput = :adminInput");
		$criteria->params = array(
			':staffCode'=>$_POST['staffcode'],
			':timeRecord'=>date('Y-m-d', strtotime($_POST['date'])),
			//':adminInput'
		);
		
		$AttendanceRemarks = AttendanceRemarks::model()->find($criteria);
		
		if($AttendanceRemarks){
			$model = $this->loadModel($AttendanceRemarks->id);
			//$model->staffCode = $_POST['staffcode'];
			//$model->timeRecord = date('Y-m-d', strtotime($_POST['date']));
			$model->remark =$_POST['remark'];
			$model->save();
		}else{
				
			$model=new AttendanceRemarks;
			$model->staffCode = $_POST['staffcode'];
			$model->timeRecord = date('Y-m-d H:i:s', strtotime($_POST['date']));
			$model->remark =$_POST['remark'];
			$model->createdBy =Yii::app()->user->getState('staffCode');
			$model->save();
		}
			
		echo CJSON::encode(array('remark'=>$_POST['remark'], 'staffcode'=>$model->staffCode));
		Yii::app()->end();
		}

		
	}
	
	
	public function actiongetRemark()
	{
		

		if(isset($_POST))
		{
		$criteria = new CDbCriteria;
		$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>$_POST['staffcode'],
			':timeRecord'=>date('Y-m-d', strtotime($_POST['date'])),
			
		);
		
		$AttendanceRemarks = AttendanceRemarks::model()->find($criteria);
		
		if($AttendanceRemarks){
			echo CJSON::encode(array('remark'=>$AttendanceRemarks->remark, 'staffcode'=>$AttendanceRemarks->staffCode));
		Yii::app()->end();
		}
			
		
		}

		
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

		if(isset($_POST['AttendanceRemarks']))
		{
			$model->attributes=$_POST['AttendanceRemarks'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('AttendanceRemarks');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new AttendanceRemarks('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AttendanceRemarks']))
			$model->attributes=$_GET['AttendanceRemarks'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return AttendanceRemarks the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=AttendanceRemarks::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param AttendanceRemarks $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='attendance-remarks-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
