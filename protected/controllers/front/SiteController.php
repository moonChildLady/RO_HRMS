<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('login', 'logout','error'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		//$roles=Rights::getAssignedRoles(Yii::app()->user->Id); 
		//var_dump($roles); // for single role
		if(Yii::app()->user->isGuest){
			$this->redirect('site/login');
		}else{
			//echo $this->GetRealIPAddress();
			$criteria = new CDbCriteria;
			$criteria->with= array("staffCode0");
			$criteria->addCondition("CURDATE() between startDate and endDate");
			$criteria->addCondition("status = :status");
			$criteria->addCondition("LEFT(t.staffCode,2) != '99'");
			$criteria->params = array(
				':status'=>'ACTIVE'
				//':endDate'=>Yii::app()->user->getState('staffCode')
			);
			
			$criteria->order = "staffCode0.surName ASC, staffCode0.givenName ASC";
			$criteria->group = "t.staffCode";
			
			$leaveModel = LeaveApplication::model()->findAll($criteria);
			$this->render('index',array(
				'leaveModel'=>$leaveModel
			));
		}
		
		//$this->redirect('site/login');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	 
	public function CalendarEvents(){
		
		$criteria = new CDbCriteria;
		$criteria->with= array("staffCode0");
		//$criteria->addCondition("CURDATE() between startDate and endDate");
		/* if(Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('eLeave Admin')) {
			
		}else{
			$criteria->addCondition("CURDATE() between startDate and endDate");
		} */
		$criteria->addCondition("status = 'ACTIVE'");
		$criteria->addCondition("left(t.staffCode, 2) != '99'");
		$criteria->order = "staffCode0.surName ASC, staffCode0.givenName ASC";
		$leaveModel = LeaveApplication::model()->findAll($criteria);
		
		$items[] = array();
		
		foreach($leaveModel as $i=>$model){
			if(!$this->isRejected($model->id, $model->staffCode)){
			$timeslot = "ALL";
		if(date('Y-m-d', strtotime($model->startDate)) == date('Y-m-d', strtotime($model->endDate))){
			if($model->startDateType==$model->endDateType){
				$timeslot = $model->startDateType;
			}
		}
		/* if(date('Y-m-d', strtotime($model->startDate)) == date('Y-m-d')) { 
			$timeslot = $model->startDateType;
			//
		} */
		/* if( $model->endDate == date('Y-m-d') || $model->startDateType==$model->endDateType){
			$timeslot = $model->endDateType;
		}else{
			$timeslot = "ALL";
		} */
		/* if( date('Y-m-d', strtotime($model->endDate)) == date('Y-m-d')){
			$timeslot = $model->endDateType;
		} */
				
				$items[] = array(
					'title'=>'Leave - '.$model->staffCode0->Fullname." (".$timeslot.")",
					'start'=>$model->startDate,
					'end'=>date('Y-m-d H:i:s',date(strtotime("+1 day", strtotime($model->endDate)))),
					'url'=>(Yii::app()->user->checkAccess('admin'))?Yii::app()->createURL('LeaveApplication/ViewApproval', array('id'=>$model->id)):"",
				);
			}
		}
		
    /* $items[]=array(
        'title'=>'Meeting',
        'start'=>'2018-02-23',
        'color'=>'#CC0000',
        'allDay'=>true,
        'url'=>'http://anyurl.com'
    );
    $items[]=array(
        'title'=>'Meeting reminder',
        'start'=>'2018-02-23',
        'end'=>'2018-02-28',
 
        // can pass unix timestamp too
        // 'start'=>time()
 
        'color'=>'blue',
    ); */
 
    echo CJSON::encode($items);
    //Yii::app()->end();
	}
	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(!Yii::app()->user->isGuest){
			$this->redirect("/");
		}
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		
		Yii::app()->user->logout();
		Yii::app()->user->clearStates();
		$this->redirect(Yii::app()->homeUrl);
	}
}
?>