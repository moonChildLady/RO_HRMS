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
  
<div class="table-responsive">
	

			<table class="table table-striped table-bordered">
				<tr>
					<th width="30%">Period</th>
					<th>Entitlement</th>
					<th>AL Bal (Including all applied leaves)</th>
					<th>Balance brought from last year</th>
					<th>Remaining from Last Year</th>
					
				</tr>
				<?php for($i=date('Y');$i>=2019;$i--){ 
				$leaveInfo = $this->staffLeaveDetail($staffCode, $i);
				//var_dump($leaveInfo);
				?>
				<tr>
					<td>FROM 
					<?php 
					$startDate = $StaffEmployment->startDate;
					if($i== date('Y', strtotime($startDate))){
						echo date('Y-m-d', strtotime($startDate));
					}else{
						echo $i."-01-01";
					}
					?>
					TO <?php echo $i."-12-31";?></td>
					<td><?php echo ($leaveInfo[5]!=null)?floor($leaveInfo[5]*2)/2:"-";?></td>
					<td><?php echo ($leaveInfo[7]!=null)?floor($leaveInfo[7]*2)/2:"-";?></td>
					<td><?php echo ($leaveInfo[3]!=null)?floor($leaveInfo[3]*2)/2:$leaveInfo[3];?></td>
					<td><?php echo ($leaveInfo[4]!=null)?floor($leaveInfo[4]*2)/2:$leaveInfo[4];?></td>
				</tr>
				<?php } ?>
				</table>
  </div>
</div>
</div>
<?php 
//echo Yii::app()->user->getState('staffCode');
//echo $this->checkProbation($staffCode, date('Y-m-d'))['isProbation'];
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