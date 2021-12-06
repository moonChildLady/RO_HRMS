<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	protected function beforeAction($action){
	
		if(!Yii::app()->user->isGuest && Yii::app()->controller->action->id!="logout" && !Yii::app()->request->isAjaxRequest){
		Yii::log('',CLogger::LEVEL_TRACE,'Category');
		}
		
		/* if(Yii::app()->controller->action->id=="logout"){
			Yii::app()->user->logout();
		Yii::app()->user->clearStates();
		} */
       return parent::beforeAction($action);
	}
	
	public function getAttachment($code){
		$criteria = new CDbCriteria;
		$criteria->addCondition("md5(concat(id, createDate)) = :code");
		$criteria->params = array(
			':code'=>$code,
		);
		
		$model=Attachments::model()->find($criteria);
		
		if($model===null){
			throw new CHttpException(404,'The requested page does not exist.');
		}else{
			ob_end_clean();
			return Yii::app()->getRequest()->sendFile( date('YmdHis').".".pathinfo($model->fileLocation, PATHINFO_EXTENSION), file_get_contents($model->fileLocation));
		}
		
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
		
		$isApproved = $this->checkApprover($staffCode, $array, $leaveID);
		
		return $isApproved;
		
		
	}
	
	
	public function isRejected($leaveID, $staffCode){
		
		$array = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition("leaveApplicationID = :leaveApplicationID");
		$criteria->params = array(
			':leaveApplicationID'=>$leaveID
		);
		$model=ApprovalLog::model()->findAll($criteria);
		
		foreach($model as $i=>$approver){
			if($approver->status == "REJECTED"){
				array_push($array, $approver->approver);
			}
		}
		
		$isApproved = $this->checkApprover($staffCode, $array, $leaveID);
		
		return $isApproved;
		
		
	}
	
	public function checkApprover($staffCode, $array, $leaveID){
		
		
		$leaveModel = LeaveApplication::model()->findByPK($leaveID);
		
		
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
	
	
	public function genReferenceNumber($id){
		$year = date('Y');
		if(date('m-d') >= "01-01"){
			$number = ($id+1)-$id;
		}
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
	
	/* public function checkApprovalLogExist($leaveID){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("leaveApplicationID = :leaveApplicationID");
		
		$criteria->params = array(
			
			':leaveApplicationID'=>$leaveID,
			
		);
		
		$model=ApprovalLog::model()->findAll($criteria);
		
		return $model;
	}
	 */
	
}