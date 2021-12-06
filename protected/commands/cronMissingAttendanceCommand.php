<?php
class cronMissingAttendanceCommand extends CConsoleCommand {

	
	
    public function run($args) {
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
		//$criteria->addInCondition("staffCode", array('9999999','999998'));
		$model = StaffEmployment::model()->findAll($criteria);
		
		
		$previous_week = date("Y-m-d", strtotime("last week monday"));
		$period = new DatePeriod(new DateTime('2018-10-01'),new DateInterval('P1D'),new DateTime('-1 days'));
		//echo $previous_week;
		foreach($model as $i=>$staff){
		$missingDate = array();
		if($staff->endDate == "" || (date('Y-m-d') >= $staff->startDate && date('Y-m-d') <= $staff->endDate)){
		
		foreach($period as $j=>$value){
		//var_dump($this->isLate($staff, $value->format('Y-m-d')));
			if(	date('N', strtotime($value->format('Y-m-d'))) < 7 
				&& !$this->isLeave($staff, $value->format('Y-m-d')) 
				&& $this->isLate($staff, $value->format('Y-m-d'))
				&& !$this->hasRemark($staff, $value->format('Y-m-d'))
				//&& $value->format('Y-m-d') == '2018-11-02'
				){
				//echo $staff->staffCode." ".$value->format('Y-m-d (D)').'<br>';
				$missingDate[] = $value->format('Y-m-d (D)');
			}
		}
		if(count($missingDate) > 0){
			EmailContent::missingAttendace($staff, $missingDate);
		}
		}
		unset($missingDate);
		}
		
		
		
		
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
	
	public function MissingAttendance(){
		
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