<?php 
$YearALTaken = array();
foreach($model as $i=>$data){ 
		if($data->reasonID=='67' && date('Y-m-d', strtotime($data->startDate)) > '2018-03-22' && $data->status=='ACTIVE' &&  $this->isApproved($data->id, $data->staffCode)){
			$YearALTaken[date('Y', strtotime($data->startDate))][] = $this->clacDuration($data->id);
		}
}
?>
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Personal Information (From <?php echo $startDate;?> To <?php echo $endDate;?>)</h3>
  </div>
  <div class="panel-body">
  <div class="row">
  <div class="col-md-4">
  
	<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<tr>
			<td width="30%">Staff Code</td>
			<td><?php echo $modelUser->staffCode;?></td>
		</tr>
		<tr>
			<td width="30%">Name</td>
			<td><?php echo $modelUser->Fullname;?> <?php echo $modelUser->chineseName;?></td>
		</tr>
		<tr>
			<td width="30%">Email</td>
			<td><?php echo $modelUser->email;?></td>
		</tr>
		<tr>
			<td width="30%">Position</td>
			<td><?php echo $modelUser->staffEmployments->position->content;?></td>
		</tr>
		<tr>
			<td width="30%">Join Date</td>
			<td><?php echo date("Y-m-d", strtotime($modelUser->staffEmployments->startDate));?></td>
		</tr>
	</table>
</div>
</div>
<div class="col-md-8">
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<tr>
					<th>YEAR</th>
					<th>AL Taken</th>
					<th>Entitlement</th>
					<th>Balance brought from last year</th>
					<th>last Year Taken</th>
					<th>Remaining from last Year</th>
					
					
				</tr>
		<?php 
		
		$upToDateBAL = array();
		
		if(!empty($YearALTaken)) { ?>		
		<?php foreach($YearALTaken as $year=>$days){ 
		
		$remainBalance = $this->loadRemainBalance($staffCode, ($year-1));
		
		//$remainingapply = $this->loadStaffApplicationDeductionPeroid($staffCode, $year."-01-01", $year."-09-30");
		if($remainBalance){
			$applyendate= date('Y-m-d', strtotime("+1 day", strtotime($remainBalance->endDate)));
		}else{
			$applyendate= $year."-03-31";
		}
		
		
		
		$remainingapply = (date('Y', strtotime($modelUser->staffEmployments->startDate))==$year)?0:$this->loadStaffApplicationDeductionPeroid($staffCode, $year."-01-01", $applyendate);
		
		
	
	if($remainBalance && $remainBalance->remaining-$remainingapply > 0){
		//$getLastYearBL = round($remainBalance->remaining-$remainingapply,2);
		
		$getInt = intval(round($remainBalance->remaining-$remainingapply,1));
		$decimal = round($remainBalance->remaining-$remainingapply,1)-$getInt;
		$getLastYearBL = 0;
		if($decimal >= 0.5){
			$getLastYearBL = $getInt+0.5;
		}else{
			$getLastYearBL = $getInt;
		}
		
	}else{
		$getLastYearBL = 0;
	} 
	$leaveInfo = $this->staffLeaveDetail($staffCode, $year);
		?>
				<tr>
					<td><?php echo $year;?></td>
					<td><?php echo array_sum($days);?></td>
					
					<td><?php 
					//$array_keys = array_keys($YearALTaken);
					//$last_key = end($array_keys);
					//if($last_key == $year){
					//	$getTotalBal= $this->getTotalBal($staffCode, $endDate);
					//	//echo $endDate;
					//}else{
					//	$getTotalBal = $this->getTotalBal($staffCode, $year."-12-31");
					//}
					$getTotalBal = ($leaveInfo[5]!=null)?floor($leaveInfo[5]*2)/2:"-";
					echo $getTotalBal;
					?></td>
					<td><?php echo ($remainBalance)?$remainBalance->remaining:0;
					//$balanceBroughtLastYear = $this->staffLeaveDetail($staffCode, $year)[3];
					//echo $balanceBroughtLastYear;
					?></td>
					<td><?php echo $remainingapply;?></td>
					<td><?php echo $getLastYearBL;?></td>
					
					
				</tr>
		<?php 
		
		
		$upToDateBAL[$year]['ALTaken'] = array_sum($days);
		$upToDateBAL[$year]['entitlement'] = $getTotalBal;
		$upToDateBAL[$year]['remainBalance'] = ($remainBalance)?$remainBalance->remaining:0;
		$upToDateBAL[$year]['LastYearBL'] = $getLastYearBL;
		} ?>
		<?php }else{ ?>
		<?php for($i=date("Y", strtotime($modelUser->staffEmployments->startDate));$i<=date('Y');$i++){ 
		$begin = new DateTime($i.'-01-01');
		$end = new DateTime();
	$calcurrentDay = $begin->diff($end);
	
		$da1 = new DateTime($i.'-12-31');
	$da2 = new DateTime($modelUser->staffEmployments->startDate);
	$diffY = $da2->diff($da1);
		if($modelUser->staffEmployments->Basis==62){
		if($diffY->y<=2){
			$ALtotal=7;
			
			$addOne2NextYear = 0;
			
			
		}else{
			if(7+($diffY->y-2) >= 14){
				$ALtotal= 14;
			}else{
				$ALtotal= 7+($diffY->y-2);
			}
			$addOne2NextYear = 0;
			
		}
		
		$da11 = new DateTime($i.'-01-01');
		$da22 = new DateTime($i.date('-m-d', strtotime($modelUser->staffEmployments->startDate)));
		$diff11 = $da22->diff($da11);
		$diff22 = $da22->diff($da1);
		$diff33 = $da11->diff($da1);
		$sub1 = ($diffY->y+1 >=3)?1:0;
		
		if((($ALtotal-$addOne2NextYear)*($diff11->days)+($ALtotal+$sub1)*($diff22->days+1))/($diff33->days+1) >=14){
			$ALtotal = 14;
		}else{
		
		$ALtotal = (($ALtotal-$addOne2NextYear)*($diff11->days)+($ALtotal+$sub1)*($diff22->days+1))/($diff33->days+1);
		}
		//if($balance->staffCode == "1222"){
		//echo $ALtotal."|".$addOne2NextYear."|".$diff11->days."|".$ALtotal."|".$sub1."|".($diff22->days+1)."|".($diff33->days+1)."<br>";
		//echo (($ALtotal-$addOne2NextYear)*($diff11->days)+($ALtotal+$sub1)*($diff22->days+1))/($diff33->days+1);
		//exit;
		//}
	}else{
		$ALtotal = 14;
	}
	
		$YearEnd = new DateTime($i.'-12-31');
	
	if(date('Y', strtotime($modelUser->staffEmployments->startDate)) == $i ){
		$joinDate = new DateTime($modelUser->staffEmployments->startDate);
		$firstYearProDay = $YearEnd->diff($joinDate);
		$entitlement = ($ALtotal/365)*($firstYearProDay->days+1);
		
		
		$asToday = $joinDate->diff($end);
		$entitlementUpToToday = ($ALtotal/365)*($asToday->days+1);
	}else{
		$entitlement = ($ALtotal/365)*($begin->diff($da1)->days+1);
		
		$entitlementUpToToday = ($ALtotal/365)*($calcurrentDay->days+1);
	}
		
		$remainBalance = $this->loadRemainBalance($staffCode, ($i-1));
		//$remainingapply = $this->loadStaffApplicationDeductionPeroid($staffCode, $i."-01-01", $i."-09-30");
		if($remainBalance){
		$remainingapply = $this->loadStaffApplicationDeductionPeroid($staffCode, $i."-01-01", $i.date('-m-d', strtotime("+1 day", strtotime($remainBalance->endDate))));
		
		//$remainingapply = (date('Y', strtotime($modelUser->staffEmployments->startDate))==$year)?0:$this->loadStaffApplicationDeductionPeroid($staffCode, $year."-01-01", $applyendate);
		
		
		if($remainBalance && $remainBalance->remaining-$remainingapply > 0){
		//$getLastYearBL = round($remainBalance->remaining-$remainingapply,2);
			
			$getInt = intval(round($remainBalance->remaining-$remainingapply,1));
			$decimal = round($remainBalance->remaining-$remainingapply,1)-$getInt;
			$getLastYearBL = 0;
			if($decimal >= 0.5){
				$getLastYearBL = $getInt+0.5;
			}else{
				$getLastYearBL = $getInt;
			}
		}else{
			$getLastYearBL = 0;
		} 
		}else{
			$getLastYearBL = 0;
			$remainingapply = 0;
		}
	
	
		?>
			<tr>
				<td><?php echo $i;?></td>
				<td>0</td>
				<td><?php echo round($entitlement,1);?></td>
				<td><?php echo ($remainBalance)?$remainBalance->remaining:0;?></td>
				<td><?php echo $remainingapply;?></td>
				<td><?php echo $getLastYearBL;?></td>
			</tr>	
		<?php 
		
		//$upToDateBAL[$year]['remainingapply'] = $remainingapply;
		$upToDateBAL[$i]['ALTaken'] = 0;
		$upToDateBAL[$i]['entitlement'] = $entitlement;
		$upToDateBAL[$i]['remainBalance'] = ($remainBalance)?$remainBalance->remaining:0;
		$upToDateBAL[$i]['LastYearBL'] = $getLastYearBL;
		} ?>
		<?php }

		

		?>
			
		</table>
	</div>
	
	<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<tr>
					<th width="30%">Up to <?php echo $endDate;?></th>
					<td><?php 
					//echo $upToDateBAL[date('Y', strtotime($endDate))]['remainBalance'];
					if(isset($upToDateBAL[date('Y', strtotime($endDate))])){
						echo round($upToDateBAL[date('Y', strtotime($endDate))]['entitlement']+($upToDateBAL[date('Y', strtotime($endDate))]['remainBalance']-$upToDateBAL[date('Y', strtotime($endDate))]['ALTaken'])-$upToDateBAL[date('Y', strtotime($endDate))]['LastYearBL'],1);
					}
					
					?></td>
				</tr>
			</table>
	</div>
	
	
	</div>
	
	
	</div>




  </div>
  </div>
<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">Leave Application (From <?php echo $startDate;?> To <?php echo $endDate;?>)</h3>
	</div>
	<div class="panel-body">
	<div class="row">
	
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<tr>
					<th>REF</th>
					<th>APPLY DATE</th>
					<th>FM</th>
					<th>TO</th>
					<th>DAY</th>
					<th>STATUS</th>
					<th width="20%">TYPE</th>
					<th>STATUS2</th>
					<th>Original Supporting Doc</th>
				</tr>

		<?php foreach($model as $i=>$data){ 
		if($data->reasonID=='67' && date('Y-m-d', strtotime($data->startDate)) > '2018-03-22' && $data->status=='ACTIVE'){
			$YearALTaken[date('Y', strtotime($data->startDate))][] = $this->clacDuration($data->id);
		}
		
		
		if($this->isRejected($data->id, $data->staffCode)){
			$statusText = "REJECTED";
		}else{
			if($this->isApproved($data->id, $data->staffCode)){
				$statusText = "APPROVED";
			}else{
				$statusText = "NOT APPROVED";
			}
		}
		
		?>
				<tr>
					<td><?php echo $data->refNo;?></td>
					<td><?php echo date('Y-m-d', strtotime($data->createDate));?></td>
					<td><?php echo date('Y-m-d (D)', strtotime($data->startDate))." (".$data->startDateType.")";?></td>
					<td><?php echo date('Y-m-d (D)', strtotime($data->endDate))." (".$data->endDateType.")";?></td>
					<td><?php echo $this->clacDuration($data->id);?></td>
					<td><?php echo $statusText;?></td>
					<td><?php echo $data->reason->content;?></td>
					<td><?php echo $data->status;?></td>
					<td><?php echo $data->HRStatus0->content;?></td>
				</tr>
		<?php } ?>
			</table>
		</div>
	</div>
	
	
	</div>
</div>