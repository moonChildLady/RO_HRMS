<a href="<?php echo Yii::app()->createURL('AttendanceRecords/ReportLanding');?>" class="btn btn-primary">Back</a>
<h3>Leave Report <?php echo $_POST['AttendanceRecords']['month'];?></h3>
<div class="table-responsive">
<table class="table table-bordered">
	<tr>
		<th>Staff Code</th>
		<th>Name</th>
		<th>Attendance</th>
		<th>Leave Application</th>
		<th>Remark</th>
	</tr>
		
<?php
$key = array();
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
				
	$criteria = new CDbCriteria;
	$criteria->addCondition("staffCode = :staffCode");
	$criteria->addCondition("status = :status");
	$criteria->addCondition(":date between startDate and endDate");
	
	$criteria->params = array(
		':staffCode'=>$staff->staffCode,
		':status'=>'ACTIVE',
		':date'=>date('Y-m-d', strtotime($_POST['AttendanceRecords']['month']))
		
	);
	
	$LeaveApplication = LeaveApplication::model()->find($criteria);
			
	//if($LeaveApplication){
	//if(!in_array($staff->staffCode.$firsCLockIn->timeRecord, $key) && !empty($startTime)){
				
?>
<tr>
	<td><?php echo $staff->staffCode;?></td>
	<td><?php echo $staff->staffCode0->surName;?> <?php echo $staff->staffCode0->givenName;?> <?php echo $staff->staffCode0->chineseName;?></td>
	<td><?php echo $firsCLockIn->timeRecord;?>(<?php echo empty($startTime[0])?"":$startTime[0];?>)</td>
	<td>
	<?php
	if($LeaveApplication){
	?>
	<a href="<?php echo Yii::app()->createURL('leaveApplication/ViewApproval/', array('id'=>$LeaveApplication->id));?>" target="_blank"><?php 
	echo $LeaveApplication->refNo;
	?></a><br>
	<?php echo $LeaveApplication->reason->content; ?>
	<br>From: <?php 
	echo $LeaveApplication->StartDateSlot;
	?><br>
	To:  <?php 
	echo $LeaveApplication->EndDateSlot;
	?><br>
	<?php echo $LeaveApplication->ApprovalStatus;?> <?php } ?></td>
	<td>
	
		
		<?php 
		unset($criteria);
		
		
		
		
		?>
		
		<?php  ?>
	</td>
</tr>
<?php
				
				//Yii::log(date('H:i:s', strtotime($firsCLockIn->timeRecord))." |".$startTime[0]);
			$key[] = $staff->staffCode.$firsCLockIn->timeRecord;
			//}
			//}
			
		}else{ ?>
	
<tr>
	<td><?php echo $staff->staffCode;?></td>
	<td><?php echo $staff->staffCode0->surName;?> <?php echo $staff->staffCode0->givenName;?> <?php echo $staff->staffCode0->chineseName;?></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
<?php } } }
if(count($key)==0){ ?>
<tr>
				<td colspan="5">No records</td>
			</tr>
<?php } ?>
</table>
</div>