<?php

class WwwProjectsController extends Controller
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
		$model=new wwwProjects;
		$typeModel = new ProjectType;
		$ImagesModel = new ProjectsImages;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['wwwProjects']) && isset($_POST['ProjectType']))
		{
			$model->attributes=$_POST['wwwProjects'];
			if($model->save()){
				
				
				foreach($_POST['ProjectType']['typeID'] as $i=>$type){
					$newType = new ProjectType;
					$newType->typeID = $type;
					$newType->projectID = $model->id;
					$newType->save();
					
				}
				$photos = CUploadedFile::getInstancesByName('ProjectsImages[imagePath]');
				
				if (isset($photos) && count($photos) > 0) {
					foreach ($photos as $image => $pic) {
						$filePath = uniqid().".".strtolower(pathinfo($pic->name, PATHINFO_EXTENSION));
						if($pic->saveAs($filePath)){
							$ImagesModel = new ProjectsImages;
							$ImagesModel->projectID = $model->id;
							$ImagesModel->imagePath = $filePath;
							$ImagesModel->save();
						}
					}
				}
				
				
				
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'typeModel'=>$typeModel,
			'ImagesModel'=>$ImagesModel,
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
		//$typeModel = new ProjectType;
		$ImagesModel = new ProjectsImages;
		$criteria = new CDbCriteria;
		$criteria->addCondition("projectID = :projectID");
		$criteria->params = array(
			':projectID'=>$id,
		);
		$typeModel = ProjectType::model()->findAll($criteria);
		
		
		
		
		
		//$exisingType = 
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['wwwProjects']))
		{
			$model->attributes=$_POST['wwwProjects'];
			if($model->save()){
				
				unset($criteria);
				$criteria = new CDbCriteria;
				$criteria->addCondition('projectID = :projectID');
				$criteria->params['projectID'] = $id;
				ProjectType::model()->deleteAll($criteria);
				
				
				
				
				foreach($_POST['ProjectType']['typeID'] as $i=>$type){
					$newType = new ProjectType;
					$newType->typeID = $type;
					$newType->projectID = $model->id;
					$newType->save();
					
				}
				
				$photos = CUploadedFile::getInstancesByName('ProjectsImages[imagePath]');
				
				if (isset($photos) && count($photos) > 0) {
					ProjectsImages::model()->deleteAll($criteria);
					foreach ($photos as $image => $pic) {
						$filePath = uniqid().".".strtolower(pathinfo($pic->name, PATHINFO_EXTENSION));
						if($pic->saveAs($filePath)){
							$ImagesModel = new ProjectsImages;
							$ImagesModel->projectID = $model->id;
							$ImagesModel->imagePath = $filePath;
							$ImagesModel->save();
						}
					}
				}
				
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'typeModel'=>$typeModel,
			'ImagesModel'=>$ImagesModel,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('projectID = :projectID');
		$criteria->params['projectID'] = $id;
		ProjectType::model()->deleteAll($criteria);
		ProjectsImages::model()->deleteAll($criteria);
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
		$dataProvider=new CActiveDataProvider('wwwProjects');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new wwwProjects('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['wwwProjects']))
			$model->attributes=$_GET['wwwProjects'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return wwwProjects the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=wwwProjects::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param wwwProjects $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='www-projects-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
