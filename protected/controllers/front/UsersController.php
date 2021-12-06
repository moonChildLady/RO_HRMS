<?php

class UsersController extends RController
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
	
	public function actionChangepassword(){
		
		 $model = new Users;
		 $model = Users::model()->findbyPK(Yii::app()->user->id);
		 $model->setScenario('changepassword');
		
		if(isset($_POST['Users'])){
 
        $model->attributes = $_POST['Users'];
        $valid = $model->validate();
 
        if($valid){
 
          $model->password = md5($model->new_password);
 
          if($model->save()){
          
			Yii::app()->user->setFlash('success', "successfully changed password!");
          }else{
            // $this->redirect(array('changepassword','msg'=>'password not changed'));
			Yii::app()->user->setFlash('error', "Password not changed!");
           }
			$this->redirect('changepassword');
		}
        }
		
		$this->render('changepassword',array(
			'model'=>$model,
		));
	}
	
	
	public function actionViewDetail(){
		$staffCode = Yii::app()->user->getState('staffCode');
		
		$criteria = new CDbCriteria;
		//$criteria->with = array("staffCodeEmploy");
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>$staffCode,
		);
		
		$model = Users::model()->find($criteria);
		
		$this->render('viewdetail',array(
			'model'=>$model,
		));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
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
		$model1=$this->loadModel($id);
		 $model->setScenario('adminchangepassword');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			//$model->attributes = $_POST['Users'];
			$valid = $model->validate();
			if($valid){
				
			//$model->password = md5($_POST['Users']['new_password']);
			if($_POST['Users']['new_password'] !=""){
				$model->password = md5($_POST['Users']['new_password']);
			}else{
				$model->password = $model1->password;
			}
			$model->resigned = $_POST['Users']['resigned'];
          if($model->save()){
          
			Yii::app()->user->setFlash('success', "successfully changed password!");
          }else{
            // $this->redirect(array('changepassword','msg'=>'password not changed'));
			Yii::app()->user->setFlash('error', "Password not changed!");
           }
			//$this->redirect('changepassword');
			//$this->redirect(array('view','id'=>$model->id));
			$this->redirect(array('admin'));
		}
				//$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionChangeRole(){
		$staffCode = Yii::app()->request->getParam('staffCode'); 
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("staffCode = :staffCode");
		$criteria->params = array(
			':staffCode'=>$staffCode
		);
		
		
		
		$record = Staff::model()->find($criteria);
		if($record){
		//$this->username = $record->staffCode;
		//$this->_id = $record->id;
		Yii::app()->user->setState( 'userlogin', $record->staffCode );
		Yii::app()->user->setState('fullname', $record->Fullname);
		Yii::app()->user->setState('Id', $record->id);
		Yii::app()->user->setState('name', $record->id);
		
		Yii::app()->user->setState('staffCode', $staffCode);
			$this->redirect(array('site/index'));
		}
		
	}
}
