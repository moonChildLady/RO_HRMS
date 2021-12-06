<?php
class cronEmailApproverCommand extends CConsoleCommand {

	
	
    public function run($args) {
        // here we are doing what we need to dom_import_simplexml
		//echo "1";
		
		//date('Y-m-d')
		
		$datetime = new DateTime();
		$datetime->modify('-3 days');
		
		
		
		$criteria = new CDbCriteria();
		//$criteria->join = "LEFT OUTER JOIN bk_Session s on s.id = t.bk_session";
		//$criteria->order = 'Date ASC, sessionTimeStart ASC, sessionTimeEnd ASC';
		//$criteria->addInCondition('Date', array("2017-12-01"));
		$criteria->addCondition(':date >= DATE_FORMAT(createDate, "%Y-%m-%d")');
		$criteria->addCondition('status = "ACTIVE"');
		$criteria->addCondition('staffCode not like "99%"');
		$criteria->order = 'createDate ASC';
		
		$criteria->params = array(
			':date'=>$datetime->format('Y-m-d')
		);
		
		$model=LeaveApplication::model()->findAll($criteria);
		$notApproved = array();
		foreach($model as $i=>$leave){
			
			if(!$this->checkResign($leave->staffCode)){			
			if(!$this->isApproved($leave->id, $leave->staffCode)){
				foreach($this->needToApprove($leave->id) as $j=>$approver){
					$notApproved[$approver][] = $leave;
				}
			}
			}
		}
		
		EmailContent::sendReminderEmail_Approver($notApproved);
		
		
    }
	
	public function checkResign($staffCode){
		$criteria = new CDbCriteria();
		$criteria->addCondition(':date <= DATE_FORMAT(endDate, "%Y-%m-%d")');
		$criteria->addCondition(':staffCode = :staffCode');
		$criteria->params = array(
			":date"=>date('Y-m-d'),
			":staffCode"=>$staffCode
		);
		$model = StaffEmployment::model()->find($criteria);
		
		if($model){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function needToApprove($leaveID){
		$array = array();
		$criteria = new CDbCriteria;
		$criteria->addCondition("leaveApplicationID = :leaveApplicationID");
		$criteria->params = array(
			':leaveApplicationID'=>$leaveID
		);
		$model=ApprovalLog::model()->findAll($criteria);
		
		foreach($model as $i=>$approver){
			if($approver->status == "APPROVED" || $approver->status == "REJECTED"){
				array_push($array, $approver->approver);
			}
		}
		
		$leaveModel = LeaveApplication::model()->findByPK($leaveID);
		
		
		$criteria1 = new CDbCriteria;
		$criteria1->addCondition("staffCode = :staffCode");
		$criteria1->addCondition(":date between startDate and endDate");
		$criteria1->params = array(
			':staffCode'=>$leaveModel->staffCode,
			':date'=>$leaveModel->createDate
		);
		//$criteria1->order = "position ASC";
		//$criteria1->group = "approver";
		$needToSentEmail = array();
		$approvers=Approvers::model()->findAll($criteria1);
		$apprvoed = true;
		foreach($approvers as $i=>$approver){
			if(in_array($approver->approver, $array)){
				//$apprvoed = $apprvoed&&true;
			}else{
				//$apprvoed = $apprvoed&&false;
				$needToSentEmail[] = $approver->approver;
			}
		}
		
		return $needToSentEmail;
		
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
	
	
	
	
}