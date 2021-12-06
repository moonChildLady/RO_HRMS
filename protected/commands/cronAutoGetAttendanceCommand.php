<?php
class cronAutoGetAttendanceCommand extends CConsoleCommand {

	
	
    public function run($args) {
		
        
		
		$criteria1 = new CDbCriteria;
		$criteria1->addCondition("status = :status");
		//$criteria1->addCondition("id = :id");
		$criteria1->params = array(
			':status'=>'YES',
			//':id'=>'7',
		);
		
		$system = StarSystem::model()->findAll($criteria1);
		
		foreach($system as $i=>$sys){
		
			$url = $sys->url."getinout?";
			$params = array(
				//'StartDate'=>date('Y-m-d'),
				//'EndDate'=>date('Y-m-d'),
				//'StartDate'=>'2019-07-25',
				//'StartDate'=>(new DateTime())->modify('first day of this month')->modify('-1 months')->format("Y-m-d"),
				'StartDate'=>(new DateTime())->modify('-4 days')->format("Y-m-d"),
				'EndDate'=>date('Y-m-d'),
				//'EndDate'=>'2019-07-30',
				'ContractID'=>$sys->contractID
			);
			
			/*
$file = fopen($url.http_build_query($params), 'rb', false);
			if(!$file){
				//die('Could not connect to "'.$api.'"');
				throw new CHttpException(404,'The requested page does not exist.');
			}
*/
			$response = file_get_contents($url.http_build_query($params));
			
			if($response === FALSE) {
				EmailContent::sendReminderEmail_GetAttendanceRecordError($sys);
			}else{
			
			
			$data = json_decode($response);
			/* var_dump($response);
			exit; */
			/* var_dump($sys->contractID);
			if($data == NULL){
				var_dump($response);
			} */
			if($data != NULL){
			foreach($data as  $j=>$staff){
				
				//echo $staff->OutTime.'<br>';
				
				if(strpos($staff->EmployeeID, 'CWR') !== false) {
					//$ReferenceNo = explode("_", $ReferenceNo)[0];
					$criteria = new CDbCriteria;
					$criteria->addCondition("cwr = :cwr");
					$criteria->params = array(
						':cwr'=>$staff->EmployeeID,
					);
					$cwr = CWRStaff::model()->find($criteria);
					if($cwr){
						$staffCode = $cwr->staffCode;
					}else{
						$staffCode = null;
					}
				}else{
					$staffCode = $staff->EmployeeID;
				}
				
				
				
				if(!empty($staffCode)){
				
				unset($criteria1);
				$criteria = new CDbCriteria;
				$criteria->addCondition("staffCode = :staffCode");
				$criteria->params = array(
					':staffCode'=>$staffCode,
				);
				$staffs = Staff::model()->find($criteria);
				
				if($staffs){
				
				
				
				
				unset($criteria);
				if($staff->Intime != ""){
					
					$criteria=new CDbCriteria;
					$criteria->addCondition("staffCode = :staffCode");
					$criteria->addCondition("deviceID = :deviceID");
					$criteria->addCondition("type = :type");
					$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
					//criteria->addCondition("timeRecord <= :timeRecordTime");
					$criteria->params = array(
						':staffCode'=>$staffCode,
						':deviceID'=>$sys->contractID,
						':timeRecord'=>date('Y-m-d', strtotime($staff->Intime)),
						//':timeRecord'=>$timeRecord." ".$sheet->getCell("H" . $row)->getValue(),
						':type'=>'Clock-in',
						
					);
						
					$checkRecord = AttendanceRecords::model()->find($criteria);
					
					
					if(!$checkRecord){
					$AttendanceRecords = new AttendanceRecords;
					$AttendanceRecords->staffCode = $staffCode;
					$AttendanceRecords->timeRecord = $staff->Intime;
					$AttendanceRecords->type = 'Clock-in';
					$AttendanceRecords->deviceID = $sys->contractID;
					$AttendanceRecords->place = $staff->ContractID;
					$AttendanceRecords->remarks = $staff->EmployeeID;
					$AttendanceRecords->save();
					}
				}
				
				if($staff->OutTime != ""){
					
					$criteria=new CDbCriteria;
					$criteria->addCondition("staffCode = :staffCode");
					$criteria->addCondition("deviceID = :deviceID");
					$criteria->addCondition("type = :type");
					$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
					//criteria->addCondition("timeRecord <= :timeRecordTime");
					$criteria->params = array(
						':staffCode'=>$staffCode,
						':deviceID'=>$sys->contractID,
						':timeRecord'=>date('Y-m-d', strtotime($staff->OutTime)),
						//':timeRecord'=>$timeRecord." ".$sheet->getCell("H" . $row)->getValue(),
						':type'=>'Clock-out',
						
					);
						
					$checkRecord = AttendanceRecords::model()->find($criteria);
					
					if(!$checkRecord){
					$AttendanceRecords = new AttendanceRecords;
					$AttendanceRecords->staffCode = $staffCode;
					$AttendanceRecords->timeRecord = $staff->OutTime;
					$AttendanceRecords->type = 'Clock-out';
					$AttendanceRecords->deviceID = $sys->contractID;
					$AttendanceRecords->place = $staff->ContractID;
					$AttendanceRecords->remarks = $staff->EmployeeID;
					$AttendanceRecords->save();
					}
				}
				
				}
				}
				
			}
			}
			EmailContent::sendReminderEmail_GetAttendanceRecord($sys);
			}
		}
		
	}
		
	
	
	
	
	
}