<script>
$(function(){
	//$('.table-responsive > #reportTable').DataTable({});
});
</script>
<?php
if(isset($_POST['AttendanceRecords']['location'])){
	$location = $_POST['AttendanceRecords']['location'];
	if($location == "0"){
		$locationText = "Overall";
	}else{
	$criteria=new CDbCriteria;
	
	$criteria->order = "contractID ASC";
	$criteria->addCondition("contractID = :contractID");
	$criteria->params = array(
		':contractID'=>$location,
	);
		
	$StarSystem = StarSystem::model()->find($criteria);
	
	$locationText = $StarSystem->displayName;
	
	}
	
	
	
	
	/* if($location == "0"){
		$locationText = "Overall";
	}
	
	if($location == "1"){
		$locationText = "Head Office";
	}
	
	if($location == "2"){
		$locationText = "Nina Mall";
	}
	if($location == "3495"){
		$locationText = "2018-028 Shatin Hospital";
	}
	if($location == "100"){
		$locationText = "Pacific Place";
	}
	if($location == "101"){
		$locationText = "Gateway";
	}
	if($location == "4196"){
		$locationText = "OCII";
	}
	if($location == "99"){
		$locationText = "Other";
	} */
}
unset($criteria);
$criteria=new CDbCriteria;
$criteria->order = "contractID ASC";
$StarSystem = StarSystem::model()->findAll($criteria);

foreach($StarSystem as $i=>$locationName){
	$locationArray[$locationName->contractID] = $locationName->shortCode;
	$show[] = $locationName->shortCode." = ".$locationName->displayName;
}

/* $locationArray = array(
"1"=>'HO',
"2"=>"NM",
"3495"=>"SH",
"100"=>"PP",
"101"=>"TST-GW",
"4196"=>"OCII",
) */

?>
<a href="<?php echo Yii::app()->createURL('AttendanceRecords/ReportLanding');?>" class="btn btn-primary">Back</a>
<h3><?php echo $locationText;?> Report <?php echo $_POST['AttendanceRecords']['month'];?></h3>
<p><?php echo implode(", ",$show);?></p>

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Overall</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Late</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">OT</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Others</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">

<div class="table-responsive">
<table class="table table-bordered table-striped table-condensed" id="reportTable">
<thead>
	<tr>
		<th>Staff Code</th>
		<th>Name</th>
		<th>TimeSlot</th>
		<th>Date Time</th>
		<th width="10%">Status</th>
		<th>Leave</th>
		<th width="30%">Remark</th>
	</tr>
</thead>
<tbody>		
<?php
$key = array();
$lates = array();
$ots = array();
$others = array();
$othersArray = array();
foreach($model as $i=>$staff){
	$endDate = ($staff->endDate=="")?'2999-12-31':$staff->endDate;
	if($_POST['AttendanceRecords']['month'] >= $staff->startDate && $_POST['AttendanceRecords']['month'] <= $endDate){
	
	
	$criteria = new CDbCriteria;
	//$criteria->with = array('staffCode0');
	$criteria->addCondition("staffCode = :staffCode");
	//$criteria->select = "DATE_FORMAT(timeRecord, '%Y-%m-%d') as dateRecord";
	$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
	$criteria->params = array(
		//':endDate'=>$this->endDate,
		':staffCode'=>$staff->staffCode,
		':timeRecord'=>$_POST['AttendanceRecords']['month'],
		
	);
	
	//$criteria->group = "timeRecord ASC, staffCode0.surName ASC, staffCode0.givenName ASC";
	
	$attendances = AttendanceRecords::model()->find($criteria);
	
	if($attendances){
	$startTime =  $this->findStaffTimeslot($staff->staffCode, $attendances->timeRecord);

	$firsCLockIn = $this->isFirstClockIn($staff->staffCode, $attendances->timeRecord);
	unset($criteria);		
			
	$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("status = :status");
	$criteria->addCondition(":date between startDate and endDate");
	
	$criteria->params = array(
		':staffCode'=>$staff->staffCode,
		':status'=>'ACTIVE',
		':date'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
	
	$TimeSlotStaff = TimeSlotStaff::model()->find($criteria);
	$TimeSlotStaffs = TimeSlotStaff::model()->findAll($criteria);
	//Yii::log($staff->staffCode);
	unset($criteria);
	$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("status = :status");
	$criteria->addCondition(":date between startDate and endDate");
	
	$criteria->params = array(
		':staffCode'=>$staff->staffCode,
		':status'=>'ACTIVE',
		':date'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
	
	$LeaveApplication = LeaveApplication::model()->findAll($criteria);
			//&& ($TimeSlotStaff->timeSlotGroup == 1 || $TimeSlotStaff->timeSlotGroup == 4 || )
	//		if(!empty($startTime)){
	//	if(!in_array($staff->staffCode.$firsCLockIn->timeRecord, $key)){
	
?>
<tr>
	<td rowspan="2"><?php echo $staff->staffCode;?></td>
	<td rowspan="2"><?php echo $staff->staffCode0->surName;?> <?php echo $staff->staffCode0->givenName;?><br><?php echo $staff->staffCode0->nickName;?><br><?php echo $staff->staffCode0->chineseName;?></td>
	<td rowspan="2"><?php 
	if($TimeSlotStaff){ ?>
	<?php echo $TimeSlotStaff->timeSlotGroup0->timeSlotGroup0->groupName;?>
	<?php 
	
	}else{ ?>
	-
	<?php } ?>
	</td>
	
	<td>
	<?php if($firsCLockIn){?>
	<?php foreach($TimeSlotStaffs as $k=>$value) { 
	if($k==0){
	?>
	
	<?php echo date("H:i:s", strtotime($firsCLockIn->timeRecord));?>(<?php echo empty($startTime[0])?"":$startTime[0];?>)[<?php echo (isset($locationArray[$firsCLockIn->deviceID]))?$locationArray[$firsCLockIn->deviceID]:"";?>]
	<?php } } }else{?>
	-
	<?php } ?>
	</td>
	<td>
	
	<?php if(!empty($startTime[0]) && $firsCLockIn){
	
	if($firsCLockIn->deviceID)
	
	$datetime1 = new DateTime($startTime[0]);
			$datetime2 = new DateTime(date("H:i:s", strtotime($firsCLockIn->timeRecord)));
			$interval = $datetime1->diff($datetime2);
			$clockin = date("H:i:s", strtotime($firsCLockIn->timeRecord));
			$clockin .= "(";
			$clockin .= (empty($startTime[0]))?"":$startTime[0];
			$clockin .= ")";
			$clockin .=  "<br>[";
			$clockin .= (isset($locationArray[$firsCLockIn->deviceID]))?$locationArray[$firsCLockIn->deviceID]:"";
			$clockin .= "]";
	 
		$others[] = $staff->staffCode;
		
		$othersArray[$staff->staffCode] = array(
				"staffCode"=>$staff->staffCode,
				"name"=>$staff->staffCode0->surName." ".$staff->staffCode0->givenName.'<br>'.$staff->staffCode0->nickName.'<br>'.$staff->staffCode0->chineseName,
				"timeslot"=>$TimeSlotStaff->timeSlotGroup0->timeSlotGroup0->groupName,
				"clockin"=>$clockin,
				"clockinLate"=>$interval->format('%i Min(s)'),
				
			);
		if($startTime[0] < date("H:i:s", strtotime($firsCLockIn->timeRecord))){ 
			$late_hours = $interval->format('%h')*60 + $interval->format('%i');
			$lates[$staff->staffCode] = array(
				"staffCode"=>$staff->staffCode,
				"name"=>$staff->staffCode0->surName." ".$staff->staffCode0->givenName.'<br>'.$staff->staffCode0->nickName.'<br>'.$staff->staffCode0->chineseName,
				"timeslot"=>$TimeSlotStaff->timeSlotGroup0->timeSlotGroup0->groupName,
				"clockin"=>$clockin,
				"clockinLate"=>$late_hours." Min(s)",
				
			);
			
	?>
		Late<br><?php echo $late_hours." Min(s)"; ?>
	<?php }else{  ?>
		
		-
		
	<?php } ?>
	<?php }else{ ?>
		-
	<?php } ?>
	</td>
	<td rowspan="2">
		<?php if($LeaveApplication){ 
			$others[] = $staff->staffCode;
			$lates[$staff->staffCode] = array(
				"LeaveApplication"=>$LeaveApplication,
			);
			
			foreach($LeaveApplication as $i=>$leave){ 
				
				$others[] = $leave->staffCode;
			?>
			
			<a href="<?php echo Yii::app()->createURL('leaveApplication/ViewApproval/', array('id'=>$leave->id));?>" target="_blank"><?php 
	echo $leave->refNo;
	?></a><br>
	<?php echo $leave->reason->content; ?>
	<br>From: <?php 
	echo $leave->StartDateSlot;
	?><br>
	To:  <?php 
	echo $leave->EndDateSlot;
	?><br>
	<?php echo $leave->ApprovalStatus;?> 
		<?php } }else{ ?> 
		-
		<?php } ?>
		
	</td>
	<td rowspan="2">
		<div class="row">
		<div class="col-md-9">
		
		<?php 
		unset($criteria);
	$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
	
	$criteria->params = array(
		':staffCode'=>$staff->staffCode,
		
		':timeRecord'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
	
	$AttendanceRemarks = AttendanceRemarks::model()->find($criteria);
			if($AttendanceRemarks && $AttendanceRemarks->remark != ""){ 
			
			$lates[$staff->staffCode]["remarks"]= nl2br($AttendanceRemarks->remark);
			
		 ?>
			<p id="remark_<?php echo $staff->staffCode;?>"><?php echo nl2br($AttendanceRemarks->remark);?></p>
			<?php }else{ ?>
			<p id="remark_<?php echo $staff->staffCode;?>">-</p>
			<?php } ?>
			</div>
			<div class="col-md-3">
			<a id="a_<?php echo $staff->staffCode;?>" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-content="<?php echo ($AttendanceRemarks)?nl2br($AttendanceRemarks->remark):"";?>" data-title="<?php echo $staff->staffCode0->surName;?> <?php echo $staff->staffCode0->givenName;?> <?php echo $staff->staffCode0->chineseName;?>" data-staffcode="<?php echo $staff->staffCode;?>" data-date="<?php echo $_POST['AttendanceRecords']['month'];?>">
				<span class=" glyphicon glyphicon-pencil" aria-hidden="true"></span>
			</a>
			</div>
	</td>
</tr>
<tr>
	<td>
	<?php 
	
	$out = $this->fristClockOut($staff->staffCode, date('Y-m-d', strtotime($_POST['AttendanceRecords']['month'])));
	if($out){ ?>
	<?php echo date("H:i:s", strtotime($out->timeRecord));?>(<?php echo empty($startTime[1])?"":$startTime[1];?>)[<?php echo (isset($locationArray[$out->deviceID]))?$locationArray[$out->deviceID]:"";?>]
	<?php }else{ ?>
	-
	<?php } ?>
	</td>
	<td>
	<?php if(!empty($startTime[1]) && $out){ 
		
		if($startTime[1] > date("H:i:s", strtotime($out->timeRecord))){ ?>
		Early	
	<?php
		}else{
		
		
		$datetime1 = new DateTime($startTime[1]);
		$datetime2 = new DateTime(date("H:i:s", strtotime($out->timeRecord)));
		$interval = $datetime1->diff($datetime2);
		$diff = $interval->format('%h');
		
		
		$clockout = date("H:i:s", strtotime($out->timeRecord));
			$clockout .= "(";
			$clockout .= (empty($startTime[1]))?"":$startTime[1];
			$clockout .= ")";
			$clockout .=  "<br>[";
			$clockout .= (isset($locationArray[$out->deviceID]))?$locationArray[$out->deviceID]:"";
			$clockout .= "]";
		
		$othersArray[$staff->staffCode]['clockout'] = $clockout;
		if($diff >= 1){ 
			echo $interval->format('OT<br>%h.%I Hr(s)');
			
			
			$ots[$staff->staffCode] = array(
				"staffCode"=>$staff->staffCode,
				"name"=>$staff->staffCode0->surName." ".$staff->staffCode0->givenName.'<br>'.$staff->staffCode0->nickName.'<br>'.$staff->staffCode0->chineseName,
				"timeslot"=>$TimeSlotStaff->timeSlotGroup0->timeSlotGroup0->groupName,
				"clockout"=>$clockout,
				"clockoutOT"=>$interval->format('%h.%I Hr(s)'),
				
			);
			
			
		}else{
			echo "-";
		}
	?>
	
	<?php } ?>
	<?php }else{ 
		
	?>
	-
	<?php } ?>
	</td>
</tr>


<?php
				
				//Yii::log(date('H:i:s', strtotime($firsCLockIn->timeRecord))." |".$startTime[0]);
	//		$key[] = $staff->staffCode.$firsCLockIn->timeRecord;
			}else{ 
			
			$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("status = :status");
	$criteria->addCondition(":date between startDate and endDate");
	
	$criteria->params = array(
		':staffCode'=>$staff->staffCode,
		':status'=>'ACTIVE',
		':date'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
	
	$TimeSlotStaff = TimeSlotStaff::model()->find($criteria);
	//Yii::log($staff->staffCode);
	unset($criteria);
	
	$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("status = :status");
	$criteria->addCondition(":date between startDate and endDate");
	
	$criteria->params = array(
		':staffCode'=>$staff->staffCode,
		':status'=>'ACTIVE',
		':date'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
	
	$LeaveApplication = LeaveApplication::model()->findAll($criteria);
			
			
			?>
<tr>
	<td rowspan="2"><?php echo $staff->staffCode0->staffCode;?></td>
	<td rowspan="2"><?php echo $staff->staffCode0->surName;?> <?php echo $staff->staffCode0->givenName;?><br><?php echo $staff->staffCode0->nickName;?><br><?php echo $staff->staffCode0->chineseName;?></td>
	<td rowspan="2"><?php if($TimeSlotStaff){ 
	
	?>
	<?php echo $TimeSlotStaff->timeSlotGroup0->timeSlotGroup0->groupName;?>
	<?php }else{ ?>
	-
	<?php } ?>
	</td>
	<td>-</td>
	<td>-</td>
	<td rowspan="2">
		<?php if($LeaveApplication){ 
			foreach($LeaveApplication as $i=>$leave){ ?>
			
			<a href="<?php echo Yii::app()->createURL('leaveApplication/ViewApproval/', array('id'=>$leave->id));?>" target="_blank"><?php 
	echo $leave->refNo;
	?></a><br>
	<?php echo $leave->reason->content; ?>
	<br>From: <?php 
	echo $leave->StartDateSlot;
	?><br>
	To:  <?php 
	echo $leave->EndDateSlot;
	?><br>
	<?php echo $leave->ApprovalStatus;?> 
		<?php } }else{ ?> 
		-
		<?php } ?>
		
	</td>
	<td rowspan="2">
	<div class="row">
		<div class="col-md-9">
		
		<?php 
		unset($criteria);
	$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
	
	$criteria->params = array(
		':staffCode'=>$staff->staffCode,
		
		':timeRecord'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
	
	$AttendanceRemarks = AttendanceRemarks::model()->find($criteria);
			if($AttendanceRemarks && $AttendanceRemarks->remark != ""){ 
		 ?>
			<p id="remark_<?php echo $staff->staffCode;?>"><?php echo nl2br($AttendanceRemarks->remark);?></p>
			<?php }else{ ?>
			<p id="remark_<?php echo $staff->staffCode;?>">-</p>
			<?php } ?>
			</div>
			<div class="col-md-3">
			<a id="a_<?php echo $staff->staffCode;?>" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-content="<?php echo ($AttendanceRemarks)?nl2br($AttendanceRemarks->remark):"";?>" data-title="<?php echo $staff->staffCode0->surName;?> <?php echo $staff->staffCode0->givenName;?> <?php echo $staff->staffCode0->chineseName;?>" data-staffcode="<?php echo $staff->staffCode;?>" data-date="<?php echo $_POST['AttendanceRecords']['month'];?>">
				<span class=" glyphicon glyphicon-pencil" aria-hidden="true"></span>
			</a>
			</div>
	</td>
</tr>
<tr>
	<td>-</td>
	<td>-</td>
</tr>
<?php	}
	}
	}
	//		}
			
	//	}

?>
</tbody>
</table>
</div>
</div>
    <div role="tabpanel" class="tab-pane" id="profile">
    <h3>Count Late: <?php echo count($lates);?></h3>
	    <div class="table-responsive">
<table class="table table-bordered table-striped table-condensed">
	<tr>
		<th>Staff Code</th>
		<th>Name</th>
		<th>TimeSlot</th>
		<th>Date Time</th>
		<th width="10%">Late Status</th>
		<th>Leave</th>
		<th width="30%">Remark</th>
	</tr>
	<?php 
	//var_dump($lates);
	foreach($lates as $i=>$late){ 
		
		if(isset($late['staffCode'])){
	?>
	<tr>
		<td><?php echo $late['staffCode'];?></td>
		<td><?php echo $late['name'];?></td>
		<td><?php echo $late['timeslot'];?></td>
		<td><?php echo $late['clockin'];?></td>
		<td><?php echo $late['clockinLate'];?></td>
		<td>
			<?php if(isset($late['LeaveApplication'])) { 
				
				$LeaveApplication = $late['LeaveApplication'];
				foreach($LeaveApplication as $i=>$leave){ ?>
			
			<a href="<?php echo Yii::app()->createURL('leaveApplication/ViewApproval/', array('id'=>$leave->id));?>" target="_blank"><?php 
	echo $leave->refNo;
	?></a><br>
	<?php echo $leave->reason->content; ?>
	<br>From: <?php 
	echo $leave->StartDateSlot;
	?><br>
	To:  <?php 
	echo $leave->EndDateSlot;
	?><br>
	<?php echo $leave->ApprovalStatus;?> 
				
			<?php } }else{ ?>
				-
			<?php } ?>
		</td>
		<td>
			<?php if(isset($late['remarks'])){ ?>
				<?php echo $late['remarks']; ?>
			<?php }else{  ?>
				-
			<?php } ?>
		</td>
	</tr>
	<?php } } ?>
	
</table>
	    </div>
	    
	    
	    
    </div>
    <div role="tabpanel" class="tab-pane" id="messages">
	    
	    <h3>Count OT: <?php echo count($ots);?>, Over time more than 1 Hr</h3>
	    <div class="table-responsive">
<table class="table table-bordered table-striped table-condensed">
	<tr>
		<th>Staff Code</th>
		<th>Name</th>
		<th>TimeSlot</th>
		<th>Date Time</th>
		<th width="10%">OT Status</th>
		<th>Leave</th>
		<th width="30%">Remark</th>
	</tr>
	<?php foreach($ots as $i=>$late){ 
		
		if(isset($late['staffCode'])){
	?>
	<tr>
		<td><?php echo $late['staffCode'];?></td>
		<td><?php echo $late['name'];?></td>
		<td><?php echo $late['timeslot'];?></td>
		<td><?php echo $late['clockout'];?></td>
		<td><?php echo $late['clockoutOT'];?></td>
		<td>
			<?php 
			
			
			unset($criteria);
	$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("status = :status");
	$criteria->addCondition(":date between startDate and endDate");
	
	$criteria->params = array(
		':staffCode'=>$late['staffCode'],
		':status'=>'ACTIVE',
		':date'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
	
	$LeaveApplication = LeaveApplication::model()->findAll($criteria);
	
			
			
			if($LeaveApplication) { 
				
				//$LeaveApplication = $late['LeaveApplication'];
				foreach($LeaveApplication as $i=>$leave){ ?>
			
			<a href="<?php echo Yii::app()->createURL('leaveApplication/ViewApproval/', array('id'=>$leave->id));?>" target="_blank"><?php 
	echo $leave->refNo;
	?></a><br>
	<?php echo $leave->reason->content; ?>
	<br>From: <?php 
	echo $leave->StartDateSlot;
	?><br>
	To:  <?php 
	echo $leave->EndDateSlot;
	?><br>
	<?php echo $leave->ApprovalStatus;?> 
				
			<?php } }else{ ?>
				-
			<?php } ?>
		</td>
		<td>
			<?php 
			unset($criteria);
	$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
	
	$criteria->params = array(
		':staffCode'=>$late['staffCode'],
		
		':timeRecord'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
			$AttendanceRemarks = AttendanceRemarks::model()->find($criteria);
			if($AttendanceRemarks && $AttendanceRemarks->remark != ""){ 
			
			 ?>
				<?php echo nl2br($AttendanceRemarks->remark); ?>
			<?php }else{  ?>
				-
			<?php } ?>
		</td>
	</tr>
	<?php } } ?>
	
</table>
	    </div>
	    
	    
	    
    </div>
    <div role="tabpanel" class="tab-pane" id="settings">
    <?php //var_dump(array_count_values($others));?>
	    <div class="table-responsive">
<table class="table table-bordered table-striped table-condensed">
	<tr>
		<th>Staff Code</th>
		<th>Name</th>
		<th>TimeSlot</th>
		<th>Date Time</th>
		<th width="30%"> Leave</th>
		<th width="15%">Remark</th>
	</tr>
	<?php 
		$countOther = array_count_values($others);
		foreach($countOther as  $staffCode=>$count){  
		if($count >=2){	
			
		?>
	<tr>
		<td rowspan="2"><?php echo $staffCode;?></td>
		<td rowspan="2"><?php echo (isset($othersArray[$staffCode]['name']))?$othersArray[$staffCode]['name']:"";?></td>
		<td rowspan="2"><?php echo (isset($othersArray[$staffCode]['timeslot']))?$othersArray[$staffCode]['timeslot']:"";?></td>
		<td><?php echo (isset($othersArray[$staffCode]['clockin']))?$othersArray[$staffCode]['clockin']:"";?></td>
		<td rowspan="2">
			
			<?php 
			
			
			unset($criteria);
	$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("status = :status");
	$criteria->addCondition(":date between startDate and endDate");
	
	$criteria->params = array(
		':staffCode'=>$staffCode,
		':status'=>'ACTIVE',
		':date'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
	
	$LeaveApplication = LeaveApplication::model()->findAll($criteria);
	
			
			
			if($LeaveApplication) { 
				
				//$LeaveApplication = $late['LeaveApplication'];
				foreach($LeaveApplication as $i=>$leave){ ?>
			
			<a href="<?php echo Yii::app()->createURL('leaveApplication/ViewApproval/', array('id'=>$leave->id));?>" target="_blank"><?php 
	echo $leave->refNo;
	?></a><br>
	<?php echo $leave->reason->content; ?>
	<br>From: <?php 
	echo $leave->StartDateSlot;
	?><br>
	To:  <?php 
	echo $leave->EndDateSlot;
	?><br>
	<?php echo $leave->ApprovalStatus;?> 
				
			<?php } }else{ ?>
				-
			<?php } ?>
		</td>
		<td rowspan="2">
			
			<?php 
			unset($criteria);
	$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
	
	$criteria->params = array(
		':staffCode'=>$staffCode,
		
		':timeRecord'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
			$AttendanceRemarks = AttendanceRemarks::model()->find($criteria);
			if($AttendanceRemarks && $AttendanceRemarks->remark != ""){ 
			
			 ?>
				<?php echo nl2br($AttendanceRemarks->remark); ?>
			<?php }else{  ?>
				-
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td><?php echo (isset($othersArray[$staffCode]['clockout']))?$othersArray[$staffCode]['clockout']:"-";?></td>
	</tr>
		
	<?php } }?>
</table>
	    </div>
    </div>
	    
	    
    </div>
  </div>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body">
        <form id="remarkFrom">
          <div class="form-group">
            <label for="message-text" class="control-label">Remark:</label>
            <textarea class="form-control" id="message-text" rows="5" name="remark"></textarea>
          </div>
		  <input type="hidden" value="" name="staffcode" id="staffcode">
		  <input type="hidden" value="" name="date" id="date">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--a class="btn btn-primary" id="saveRemarkBtn">Save</a-->
		<?php echo CHtml::ajaxLink('Save', 
			Yii::app()->createURL('AttendanceRemarks/createRemark'),
			array(
				'dataType'=>'json',
                'type' => 'post',
				"data"=>'js:$("#remarkFrom").serialize()',
				'success'=>'js:function(data,status){
					if(data.remark==""){
						 $("#remark_"+data.staffcode).html("-");
					}else{
                    $("#remark_"+data.staffcode).html(data.remark.nl2br());
					}
                    $("#a_"+data.staffcode).attr("data-content", data.remark.nl2br());
                    $("#myModal").modal("hide");
					$("#myModal").on("hidden.bs.modal", function (e) {
						$("#remark_"+data.staffcode).fadeOut().fadeIn();
					})
					

                }'
			),
			array('class'=>'btn btn-primary')
			); ?>
		<?php /* echo CHtml::ajax(array(
            'url'=>array('classroom/update'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)"
			)); */?>
      </div>
    </div>
  </div>
</div>
<script>
String.prototype.nl2br = function()
{
    return this.replace(/\n/g, "<br />");
}
String.prototype.br2nl = function()
{
    return this.replace(/<br ?\/?>/g, "");
}
$(function(){
	$('#myModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var title = button.data('title') // Extract info from data-* attributes
  //var content = button.data('content') // Extract info from data-* attributes
  var date = button.data('date') // Extract info from data-* attributes
  var staffcode = button.data('staffcode') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  
  
  
  var modal = $(this);
  modal.find('.modal-title').text('Remark for ' + title);
  //modal.find('.modal-body textarea').val(content.br2nl());
  modal.find('.modal-body input[name=staffcode]').val(staffcode);
  modal.find('.modal-body input[name=date]').val(date);
  
  <?php echo CHtml::ajax(array(
            'url'=>Yii::app()->createURL('AttendanceRemarks/getRemark'),
            'data'=> "js:{staffcode:staffcode,date:date}",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"js:function(data,status){
				modal.find('.modal-body textarea').val(data.remark.br2nl());
			}"
	));?>
  //console.log(content);
});
});
</script>