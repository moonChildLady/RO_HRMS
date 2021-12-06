<?php
$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	'Manage',
);

/* $this->menu=array(
array('label'=>'List LeaveApplication','url'=>array('index')),
array('label'=>'Create LeaveApplication','url'=>array('create')),
); */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('leave-application-grid', {
data: $(this).serialize()
});
return false;
});
");
$marriage1 = 0;
$marriage = 0;

$criteria = new CDbCriteria;
$criteria->addCondition("type = :type");
$criteria->params = array(
	':type'=>'LEAVEREASON',
);
		
$reasonIDs = ContentTable::model()->findAll($criteria);

$criteria1 = new CDbCriteria;
$criteria1->addCondition("type = :type");
$criteria1->params = array(
	':type'=>'LEAVECOMMENT',
);
		
$commentIDs = ContentTable::model()->findAll($criteria1);
$staffCode = Yii::app()->user->getState('staffCode');
?>

<h3>Apply Leave Applications</h3>

<div class="well">

<p><a href="<?php echo Yii::app()->createURL("LeaveApplication/getAttachment", array("code"=>"41425d4b7fd14e22bb62b4dd9f1b2c50")); ?>" class="btn btn-success">Download the user manual</a></p>


</div>
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">AL Balance</h3>
  </div>

  <div class="panel-body">
  
<?php if($leaveBalance) { ?>
<div class="table-responsive">
	

			<table class="table table-striped table-bordered">
				<tr>
					<th width="30%">Period</th>
					<th>Entitlement</th>
					<th>AL Bal (Including all applied leaves)</th>
					<!--th>Including approved leaves only</th-->
					<th>Balance brought from last year</th>
					<th>Remaining from Last Year</th>
					
				</tr>
				<?php 
				foreach($leaveBalance as $i=>$balance) {


				

					
				$begin = new DateTime($balance->balanceDate);
				$getYear = date('Y', strtotime($balance->balanceDate));
				$end = new DateTime($getYear.'-12-31');
				$calcurrentDay1 = $begin->diff($end);
				$calcurrentDay = $calcurrentDay1->format('%a');
				
				$da1 = new DateTime();
				$da2 = new DateTime($StaffEmployment->startDate);
				$diffY = $da2->diff($da1);
		//echo $diff->y;
		if($StaffEmployment->Basis==62){
			if($diffY->y<=2){
				$ALtotal=7;
			}else{
				$ALtotal=7+($diffY->y-2);
			}
		}else{
			$ALtotal = 14;
		}
		
		//$entitlement = ($ALtotal/365)*($calcurrentDay->days+1);

				
				
				if($getYear=='2018'){
					$entitlement = (14/365)*($calcurrentDay);
				}else{
					$entitlement = $ALtotal;
				}
				//$totalBal = $entitlement+$balance->balance;
				$totalBal = $entitlement+$balance->balance;
				//echo $totalBal;
				?>
				
				
				<tr id="Year_<?php echo $getYear;?>">
					<td>FROM <?php //echo $getYear."-01-01";?><?php echo $begin->format('Y-m-d');?> TO <?php echo $end->format('Y-m-d');?></td>
					<td><?php if($getYear=='2018'){
					$entitlement = (14/365)*($calcurrentDay);
				}else{
					//$entitlement = $ALtotal;
					
					$YearEnd = new DateTime('2019-12-31');
	
	if(date('Y', strtotime($StaffEmployment->startDate)) == $getYear ){
		$joinDate = new DateTime($StaffEmployment->startDate);
		///$firstYearProDay = $YearEnd->diff($joinDate);
		$firstYearProDay = $joinDate->diff($YearEnd);
		$entitlement = ($ALtotal/365)*($firstYearProDay->days+1);
		
		
		$asToday = $joinDate->diff($end);
		$entitlementUpToToday = ($ALtotal/365)*($asToday->days+1);
	}else{
		$entitlement = ($ALtotal/365)*($begin->diff($YearEnd)->days+1);
		
		//$entitlementUpToToday = ($ALtotal/365)*($calcurrentDay+1);
	}
					//$entitlement = $entitlementUpToToday;
					
				}
				
				$getInt = intval(round($entitlement,1));
				$decimal = round($entitlement,1)-$getInt;
				$finalOut = 0;
				if($decimal >= 0.5){
					$finalOut = $getInt+0.5;
				}else{
					$finalOut = $getInt;
				}
				echo $finalOut;
				?></td>
					<td><?php
					
					
					if(date('Y', strtotime($StaffEmployment->startDate)) == $getYear ){
						$totalBal = $entitlement;
					}
						
//echo $totalBal."|";
						$remainBalance = $this->loadRemainBalance($staffCode, ($getYear-1));
						$remainingapply = $this->loadStaffApplicationDeductionPeroid($staffCode, $getYear."-01-01", $getYear."-09-30");
						$remainBal = 0;
						if($remainBalance){
							$remainBal += $remainBalance->remaining;
						}
						$remainBal -= $remainingapply;
						/* if($remainBalance && $remainBalance->remaining-$remainingapply < 0){
							$remainBal = $remainBalance->remaining-$remainingapply;
							//echo $remainBalance->remaining."|";
						}else{
							$remainBal = 0;
						} */
						
						//echo $remainingapply."|".$remainBal."|";
						
						
						$allApplied = $totalBal-$this->loadStaffApplicationDeduction($staffCode, $getYear, 'ACTIVE', 'NO')+$remainBal;
						$rounded = round($allApplied+$balance->balance, 1);
						$getInt = intval($rounded);
						$decimal = $rounded-$getInt;
						$finalOut = 0;
						if($rounded >= 0){
						if($decimal >= 0.5){
							$finalOut = $getInt+0.5;
						}else{
							$finalOut = $getInt;
						}
							echo $finalOut;
						}else{
							
							if($rounded <= 0){
								echo round($rounded/5, 1) * 5;
							}
						}
						
						?></td>
					<!--td><?php 
						$allApplied = $totalBal-$this->loadStaffApplicationDeduction($staffCode, $getYear, 'ACTIVE', 'YES')+$remainBal;
						$rounded = round($allApplied, 1);
						$getInt = intval($rounded);
						$decimal = $rounded-$getInt;
						$finalOut = 0;
						if($decimal >= 0.5){
							$finalOut = $getInt+0.5;
						}else{
							$finalOut = $getInt;
						}
						echo $finalOut;
						?>
					</td-->
					<td>
					<?php if($getYear=='2018'){ ?>
					-
					<?php }else{ 
					
					$remainBalance = $this->loadRemainBalance($staffCode, ($getYear-1));
						if($remainBalance && $remainBalance->remaining > 0){
							//echo $remainBalance->remaining;
							$getInt = intval(round($remainBalance->remaining,1));
				$decimal = round($remainBalance->remaining,1)-$getInt;
				$finalOut = 0;
				if($decimal >= 0.5){
					$finalOut = $getInt+0.5;
				}else{
					$finalOut = $getInt;
				}
				echo $finalOut;
						}else{
							echo "0";
						}
					?>
					
					<?php } ?>
					</td>
					<td>
					<?php if($getYear=='2018'){ ?>
					-
					<?php }else{ 
					$remainingapply = $this->loadStaffApplicationDeductionPeroid($staffCode, $getYear."-01-01", $getYear."-09-30");
					//echo $remainingapply;
					$remainBalance = $this->loadRemainBalance($staffCode, ($getYear-1));
						if($remainBalance && $remainBalance->remaining-$remainingapply > 0){
							
							//echo ($remainBalance->remaining-$remainingapply);
							$getInt = intval(round($remainBalance->remaining-$remainingapply,1));
				$decimal = round($remainBalance->remaining-$remainingapply,1)-$getInt;
				$finalOut = 0;
				if($decimal >= 0.5){
					$finalOut = $getInt+0.5;
				}else{
					$finalOut = $getInt;
				}
				echo $finalOut;
						}else{
							echo "0";
						}
					?>
					
					<?php } ?>
					</td>
				</tr>
				<?php } ?>
				
				
			</table>
			
		</div>
<?php }else{ ?>
<p>No Record(s).</p>
<?php } ?>
  </div>
</div>
<?php 
//echo $this->checkProbation($staffCode, date('Y-m-d'))['ProbationDate'];
if(!$this->checkProbation($staffCode, date('Y-m-d'))['isProbation'] && $StaffEmployment){ 
//echo $this->checkProbation($staffCode, date('Y-m-d'))['ProbationDate'];
$sickLeaveData = $this->sickLeaveTotal($staffCode, date('Y-m-d'));
?>
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Full Paid Sick Leave Balance</h3>
  </div>

  <div class="panel-body">
  <div class="table-responsive">
	

			<table class="table table-striped table-bordered">
				<tr>
					<th width="30%">Period</th>
					<th>Entitlement</th>
					<th>Balance</th>
				</tr>
				<tr>
					<td>FROM <?php echo $sickLeaveData['from'];?> TO <?php echo $sickLeaveData['to'];?></td>
					<td><?php echo $sickLeaveData['entitlement'];?></td>
					<td>
					<?php
					$balanceSickLeave = $sickLeaveData['entitlement']-$this->loadStaffApplicationDeductionSickLeavePeroid($staffCode, $sickLeaveData['from'], date('Y-').'12-31');
					echo $balanceSickLeave;
					?></td>
					
				</tr>
				
				
			</table>
  </div>
  </div>
</div>
<?php } ?>
<div class="row">
	
	<?php 
//echo $this->checkProbation($staffCode, date('Y-m-d'))['ProbationDate'];
if(!$this->checkProbation($staffCode, date('Y-m-d'))['isProbation'] && $StaffEmployment){ 
//echo $this->checkProbation($staffCode, date('Y-m-d'))['ProbationDate'];

?>
<div class="col-md-6">
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Marriage Leave Balance</h3>
  </div>

  <div class="panel-body">
  <div class="table-responsive">
	

			<table class="table table-striped table-bordered">
				<tr>
					<th>Period</th>
					<th width="30%">Entitlement</th>
					<th>Balance</th>
				</tr>
				<tr>
					<td>Employment Peroid</td>
					<td>3</td>
					<td>
					<?php
					$marriage = 3-$this->loadStaffMarriage($staffCode);
					echo $marriage;
					?>
					</td>
				</tr>
				
				
			</table>
  </div>
  </div>
</div>
</div>
<div class="col-md-6">
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Birthday Leave Balance</h3>
  </div>

  <div class="panel-body">
  <div class="table-responsive">
	<?php 
	
	if($StaffEmployment->staffCode0->dob!=""){ ?>

			<table class="table table-striped table-bordered">
				<tr>
					<th>Period</th>
					<th width="30%">Entitlement</th>
					<th>Balance</th>
				</tr>
				<tr>
					<td><?php 
					$date = new DateTime($StaffEmployment->staffCode0->dob);
					
					if($date->format('m') == "1" || $date->format('m') == "12"){
						
						if($date->format('m') == "1"){
							$date->modify('first day of this month');
							
							$firstday= $date->format('m-d');
							
							$date->modify('last day of this month');
							$date->modify('+2 month');
							$lastday= $date->format('m-d');
						}
						
						if($date->format('m') == "12"){
							$date->modify('first day of this month');
							$date->modify('-2 month');
							$firstday= $date->format('m-d');
							
							$date->modify('last day of this month');
							$date->modify('+2 month');
							$lastday= $date->format('m-d');
						}
						
					}else{
					
					//First day of month
					$date->modify('first day of this month');
					$date->modify('-1 month');
					$firstday= $date->format('m-d');
					//Last day of month
					$date->modify('last day of this month');
					$date->modify('+2 month');
					$lastday= $date->format('m-d');
					}
					?>
					FROM <?php echo $firstday;?> TO <?php echo $lastday;?></td>
					<td>1</td>
					<td>
					<?php
					$marriage1 = 1-$this->loadStaffBirthdayLeave($staffCode);
					echo $marriage1;
					?>
					</td>
				</tr>
				
				
			</table>
	<?php } ?>
  </div>
  </div>
</div>
</div>
<?php } ?>
	
</div>
<?php 
//echo $this->getLongServiceYear($staffCode);
if($this->getLongServiceYear($staffCode)%6==0 && $this->getLongServiceYear($staffCode) != 0){
//echo $this->getLongServiceYear($staffCode);
$totalOfServiceYear = ($this->getLongServiceYear($staffCode)/6 >1)?2:1;
$period = $this->getLongServiceYearDetails($staffCode);
$startDate = $StaffEmployment->startDate;
//echo $startDate;
$d1 = new DateTime($startDate);
//echo iterator_count($period);
//echo $value->format('Y-m-d');

?>
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Long Service Balance</h3>
  </div>

  <div class="panel-body">
  <div class="table-responsive">
	

			<table class="table table-striped table-bordered">
				<tr>
					<th width="30%">Accrual period</th>
					<th>Entitlement</th>
					<th>Balance</th>
				</tr>
				<?php 
				$j=1;
				//foreach ($period as $key => $value) { 
					//echo $j;
					//if($j==(iterator_count($period)-1)){
						
						
				?>
				<tr>
					<td>FROM <?php 
					echo $d1->modify('+'.$this->getLongServiceYear($staffCode).' year')->format('Y-m-d');
					
					?> TO <?php echo $d1->modify('+1 year')->modify('-1 day')->format('Y-m-d');?></td>
					<td><?php echo $totalOfServiceYear;?></td>
					<td><?php echo $totalOfServiceYear-$this->loadStaffLongServiceLeave($staffCode);?></td>
				</tr>
				<?php 
				
				//} 
				//$j++;
				//} ?>
			</table>
</div>
  </div>
</div>
<?php } ?>
<div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New Application <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <!--li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/createbystaff');?>">Leave [Jan to Sep]</a></li-->
	<li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/createbystaff',array('month'=>9));?>">Leave [Oct to Dec]</a></li>
	
	<?php 
	if($LeaveApplicationApply){
	foreach($LeaveApplicationApply as $i=>$leaveApply){ ?>
	<li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/ApplyLeveApplication',array('id'=>$leaveApply->id));?>">Leave [<?php echo date("M Y", strtotime($leaveApply->applyStartDate));?> to <?php echo date("M Y", strtotime($leaveApply->applyEndDate));?>]</a></li>
	<?php } } ?>
	
	
	<?php if($marriage1 == "1" && !$this->checkProbation($staffCode, date('Y-m-d'))['isProbation']){ ?>
    <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/createbystaff', array('type'=>'130'));?>">Birthday Leave</a></li>
	<?php } ?>
	<?php 
if($this->getLongServiceYear($staffCode)%6==0 && $this->getLongServiceYear($staffCode)!=0){	?>
<?php if($totalOfServiceYear-$this->loadStaffLongServiceLeave($staffCode) > 0){ ?>
	 <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/createbystaff', array('type'=>'128'));?>">Long Service Leave</a></li>
	 
	 
<?php } } ?>

<?php 
if(!$this->checkProbation($staffCode, date('Y-m-d'))['isProbation']){
if(3-$this->loadStaffMarriageLeave($staffCode) > 0){ ?>
	 <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/createbystaff', array('type'=>'129'));?>">Marriage Leave</a></li>
	 
	 
<?php } ?>

<?php } ?>
   
  </ul>
</div>
<!--div class="btn-group pull-left">
  
  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
  Annual Leave (AL) entitlement
</button>
</div-->
<?php $this->widget('booster.widgets.TbExtendedGridView',array(
'id'=>'leave-application-grid',
'dataProvider'=>$model->userListView(),
//'template' => "{extendedSummary}\n{items}\n{pager}",
'template' => "{items}\n{pager}",
'ajaxUpdate'=>false,
'filter'=>$model,
'afterAjaxUpdate' => 'reinstallDatePicker',
'columns'=>array(
		//'id',
		array(
		'name'=>'refNo',
		'type'=>'raw',
		'value'=>'CHtml::link("$data->refNo",array("view", "id"=>$data->id))',
),
		//'staffCode',
/*
		array(
			'name'=>'Fullname',
			'value'=>'$data->staffCode0->Fullname',
			'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
		),
*/
		array(
			'name'=>'startDate',
			//'value'=>'($data->endDate)?date("Y-m-d", strtotime($data->endDate)):""',
			'value'=>'$data->StartDateSlot',
			'filter' => $this->widget(
    'booster.widgets.TbDatePicker',
    array(
		'model'=>$model,
		'value'=>$model->startDate,
        'name' => 'LeaveApplication[startDate]',
		
        'htmlOptions' => array(
			//'class'=>'col-md-4',
			    //'id'=>'date',
		),
		'options'=>array(
			'format' => 'yyyy-mm-dd',
			'viewformat' => 'yyyy-mm-dd',
			'autoclose'=>true,
			'clearBtn'=>true
			)
    ),true,false
)
			
		),
		array(
			'name'=>'endDate',
			//'value'=>'($data->endDate)?date("Y-m-d", strtotime($data->endDate)):""',
			'value'=>'$data->EndDateSlot',
			'filter' => $this->widget(
    'booster.widgets.TbDatePicker',
    array(
		'model'=>$model,
		'value'=>$model->endDate,
        'name' => 'LeaveApplication[endDate]',
		
        'htmlOptions' => array(
			'class'=>'col-md-2',
			    //'id'=>'date',
		),
		'options'=>array(
			'format' => 'yyyy-mm-dd',
			'viewformat' => 'yyyy-mm-dd',
			'autoclose'=>true,
			'clearBtn'=>true
			)
    ),true,false
)
			
		),
		//'startDate',
		//'endDate',
		
		//'duration',
		array(
			'name'=>'reasonID',
			'type'=>'raw',
			'value'=>'nl2br($data->ReasonwithRemarks)',
			'filter' => CHtml::dropDownList( 'LeaveApplication[reasonID]', $model->reasonID,
					CHtml::listData( $reasonIDs, 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
			
			
		),
		/*
array(
			'name'=>'commentID',
			'type'=>'raw',
			'value'=>'($data->commentID!=null):nl2br($data->CommentwithRemarks)?""',
			'filter' => CHtml::dropDownList( 'LeaveApplication[commentID]', $model->commentID,
			CHtml::listData( $commentIDs, 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
			
			
		),
*/
		//'reasonID',
		array(
			'type'=>'raw',
			'name'=>'ApprovalStatus',
			'value'=>'$data->ApprovalStatus',
		),
		'createDate',
		//'DurationDay',
		array(
			'type'=>'raw',
			'name'=>'DurationDayLabel',
			'value'=>'$data->DurationDay',
			'filter' => "",
		),
		/* array(
			'type'=>'raw',
			'name'=>'LeaveBalanceLabel',
			'value'=>'$data->LeaveBalance',
			'filter' => "",
		), */
		//'LeaveBalance',
		//'createdBy',
		
		/*
		'reasonRemarks',
		'commentID',
		'commentRemarks',
		'attachmentID',
		
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
'buttons'=>array(
	'update'=>array(
	//'label'=>'...',     //Text label of the button.
    'url'=>'Yii::app()->createURL("LeaveApplication/update", array("id"=>$data->id,"type"=>$data->reasonID))',       //A PHP expression for generating the URL of the button.
    //'imageUrl'=>'...',  //Image URL of the button.
    //'options'=>array(), //HTML options for the button tag.
    //'click'=>'...',     //A JS function to be invoked when the button is clicked.
    'visible'=>'leaveApplicationController::checkApprovalLogExist($data->id)!=true',   //A PHP expression for determining whether the button is visible.
	),
	'delete'=>array(
	//'label'=>'...',     //Text label of the button.
    //'url'=>'...',       //A PHP expression for generating the URL of the button.
    //'imageUrl'=>'...',  //Image URL of the button.
    //'options'=>array(), //HTML options for the button tag.
    //'click'=>'...',     //A JS function to be invoked when the button is clicked.
    'visible'=>'(leaveApplicationController::checkApprovalLogExist($data->id)!=true && $data->createdBy==Yii::app()->user->getState("staffCode"))',   //A PHP expression for determining whether the button is visible.
	),
	
),
),
),
'extendedSummary' => array(
        'title' => 'Leave Records',
        'columns' => array(
            'DurationDayLabel' => array('label'=>'Grand Total (days)', 'class'=>'TbSumOperation')
        )
    ),
'extendedSummaryOptions' => array(
        'class' => 'well pull-right',
       
    ),
)); ?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Annual Leave (AL) entitlement</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
			<table class="table table-striped table-bordered">
				<tr>
					<td>Balance Date</td>
					<td>Opening Balance (days)</td>
				</tr>
				<?php foreach($leaveBalance as $i=>$balance) { 
				$begin = new DateTime($balance->balanceDate);
				$end = new DateTime(date('Y-m-d'));
				$calcurrentDay1 = $begin->diff($end);
				$calcurrentDay = $calcurrentDay1->format('%a');
				$entitlement = (14/365)*($calcurrentDay);
				
				?>
					<tr>
						<td>until <?php echo $balance->balanceDate; ?></td>
						<td><?php echo $balance->balance; ?></td>
					</tr>
				<?php } ?>
				<tr>
					<td>unti Now <?php echo date('Y-m-d');?></td>
					<td><?php echo round($entitlement,2)+$balance->balance; ?></td>
					
				</tr>
			</table>
			
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--button type="button" class="btn btn-primary">Save changes</button-->
      </div>
    </div>
  </div>
</div>
<?php
/* function to re install date picker after filter the result. if you don’t use it then after filter the result calendar will not shown in filter box */
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
jQuery('#LeaveApplication_startDate').datepicker({'format':'yyyy-mm-dd','viewformat':'yyyy-mm-dd','autoclose':true,'language':'en','clearBtn':true});

jQuery('#LeaveApplication_endDate').datepicker({'format':'yyyy-mm-dd','viewformat':'yyyy-mm-dd','autoclose':true,'language':'en','clearBtn':true});
}
");
?>
<script>
$(function(){
	$("#Year_<?php echo (date('Y')-1);?>").hide();
});
</script>