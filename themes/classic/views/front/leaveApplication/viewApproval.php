


<?php
$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	$model->id,
);

/* $this->menu=array(
array('label'=>'List LeaveApplication','url'=>array('index')),
array('label'=>'Create LeaveApplication','url'=>array('create')),
array('label'=>'Update LeaveApplication','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete LeaveApplication','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage LeaveApplication','url'=>array('admin')),
); */
?>

<?php
/* echo strtolower(Yii::app()->request->urlReferrer)."<br>";
echo strtolower(Yii::app()->getBaseUrl(true).Yii::app()->createURL("LeaveApplication/ViewApproval", array("id"=>$model->id)));
if(Yii::app()->request->urlReferrer == Yii::app()->getBaseUrl(true).Yii::app()->createURL("LeaveApplication/ViewApproval", array("id"=>$model->id))){
	echo "1";
	Yii::app()->user->setReturnUrl(Yii::app()->getBaseUrl(true).Yii::app()->createURL("LeaveApplication/ManageApproval"));
} */
    foreach(Yii::app()->user->getFlashes() as $key => $message) { 
	    //glyphicon glyphicon-ok
	    if($key=="success"){
	    $span = "glyphicon glyphicon-ok";
    }else{
	    $span = "glyphicon glyphicon-remove";
    }
    ?>
    <div class="alert alert-<?php echo $key;?>" role="<?php echo $key;?>">
  <span class="<?php echo $span;?>" aria-hidden="true"></span>
  
 <?php echo $message;?>
</div>
    <?php } ?>

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Leave Application Ref No.<?php echo $model->refNo;?></h3>
  </div>
  <div class="panel-body">
  <!--div class="table-responsive"-->
	<table class="table table-bordered">
		<tr>
			<td width="30%">Ref. No</td>
			<td><?php echo $model->refNo;?></td>
		</tr>
		<tr>
			<td width="30%">Staff</td>
			<td><?php echo $model->staffCode0->FullnamewithStaffCode;?> (<?php echo $model->staffCode0->staffEmployments->position->content;?>)</td>
		</tr>
		<?php 
			
			if($model->reasonID==67 || $model->reasonID==68){ 
			
				$finalOut = $this->getBalanceByDate($model, date('Y-m-d', strtotime($model->createDate)));
			?>
		<!--tr>
			<td width="30%">Balance as of <?php echo date('Y-m-d', strtotime($model->createDate));?></td>
			
			<!--p>Balance as of today is <span class="label label-<?php echo ($finalOut <=0)?"danger":"success";?>" style="font-size:16px"><?php echo $finalOut;?></span> day(s).</p>
			
			
			<td><?php echo $finalOut;?> day(s)</td>
			
		</tr-->
		
		<!--tr>
			<td>Balance as of <?php echo date('Y', strtotime($model->createDate));?>-12-31</td>
			<td>
				<?php 
					$finalOut1 = $this->getBalanceByDate($model, date("Y-", strtotime($model->startDate)).'12-31');
					echo $finalOut1;
				?>
				day(s)
			</td>
		</tr-->
		<?php }  ?>
		<tr>
			<td width="30%">Leave Requested</td>
			<td>
			<?php
			
			
			echo $this->clacDuration($model->id);
			?> day(s)
			
			
			</td>
		</tr>
		<tr>
			<td width="30%">Date Range</td>
			<td><p><?php echo date("Y-m-d", strtotime($model->startDate));?> (<?php echo date("D", strtotime($model->startDate));?>) [<?php echo $model->startDateType;?>] to <?php echo date("Y-m-d", strtotime($model->endDate));?> (<?php echo date("D", strtotime($model->endDate));?>) [<?php echo $model->endDateType;?>]</p>
			</td>
		</tr>
		<?php 
			
			if($model->reasonID==67 || $model->reasonID==68){ 
				$remainBalance = $this->loadRemainBalance($model->staffCode, date("Y", strtotime($model->startDate))-1);
				$remainingapply = $this->loadStaffApplicationDeductionPeroid($model->staffCode, date("Y", strtotime($model->startDate))."-01-01", date("Y", strtotime($model->startDate))."-09-30");
				if($remainBalance && $remainBalance->remaining-$remainingapply < 0){
					$remainBal = $remainBalance->remaining-$remainingapply;
				}else{
					$remainBal = 0;
				}
				
				
				$finalOut2 = $this->getBalanceByDate($model, date("Y-", strtotime($model->startDate)).'12-31');
				//var_dump($finalOut2+$remainBal);
				//echo $this->loadStaffApplicationDeduction($model->staffCode, date("Y", strtotime($model->startDate)), 'ACTIVE', 'YES');
				
			?>
		<tr>
			<td>Balance as of <?php echo date("Y-", strtotime($model->startDate)).'12-31';?><br>
(After deduction of the requested leave)
</td>
			<!--td><?php //echo ($finalOut2+$remainBal)-$this->clacDuration($model->id);?> day(s)</td-->
			<td><?php 
			$balanceASYearEnd = $this->staffLeaveDetail($model->staffCode, date("Y", strtotime($model->startDate)));
			
			if($balanceASYearEnd != null){
			
			$rounded = round($balanceASYearEnd[7], 1);
		$getInt = intval($rounded);
		$decimal = $rounded-$getInt;
		$finalOut = 0;
		if($decimal >= 0.5){
			$finalOut = $getInt+0.5;
		}else{
			$finalOut = $getInt;
		}
			echo $finalOut." day(s)";
		}else{
			
			echo "N/A";
		}			
			?> </td>
		</tr>
		<?php } ?>
		
		<tr>
			<td width="30%">Leave Type</td>
			<td><?php echo strtoupper(nl2br($model->ReasonwithRemarks));?></td>
		</tr>
		<tr>
			<td width="30%"><?php echo $model->getAttributeLabel('commentID');?></td>
			<td><?php echo strtoupper(nl2br($model->CommentwithRemarks));?></td>
		</tr>
		<tr>
			<td width="30%"><?php echo $model->getAttributeLabel('attachments');?></td>
			<td>
			
			<?php if($model->attachmentID){ ?>
			<a href="<?php
			
			echo Yii::app()->createURL("LeaveApplication/getAttachment", array('code'=>md5($model->attachments->id.$model->attachments->createDate))); ?>" target="_blank">Download [<?php echo strtoupper(pathinfo($model->attachments->fileLocation, PATHINFO_EXTENSION));
			?>]
			
			
			
			</a>
	<?php if(pathinfo($model->attachments->fileLocation, PATHINFO_EXTENSION)=="jpg" || pathinfo($model->attachments->fileLocation, PATHINFO_EXTENSION)=="png" || pathinfo($model->attachments->fileLocation, PATHINFO_EXTENSION)=="jpeg") { ?>
	<img src="<?php echo $this->getPhoto(md5($model->attachments->id.$model->attachments->createDate)); ?>" class="img-responsive">
	<?php } ?>
	<?php }else{ ?> -
	<?php } ?>
	</td>
		</tr>
		<tr>
			<td width="30%"><?php echo $model->getAttributeLabel('createDate');?></td>
			<td><?php echo $model->createDate;?></td>
		</tr>
	<tr>
		<td>Approval Record</td>
		<td>
		<?php 
		
		$logs = $this->loadApprovalLog($model->id);
		$exist = array();
		if($logs){
			foreach($logs as $i=>$log){
				if($log->status =="APPROVED"){
							$label = "success";
							$text = "Approved";
						}else{
							$label = "danger";
							$text = "Rejected";
						}
			array_push($exist, $log->approver);
			?>
			<p><span class="label label-<?php echo $label;?>"><?php echo $text;?></span> <?php echo $log->approver0->Fullname;?></p>			
						
		<?php } }
		
			$label = "warning";
			$text = "Pending";
			foreach($approvers as $i=>$approver){ 
			
			if(!in_array($approver->approver, $exist)){
			?>
				
				<p><span class="label label-<?php echo $label;?>"><?php echo $text;?></span> <?php echo $approver->approver0->Fullname;?></p>		
				
			<?php } } ?>
				
		
				
		</td>

	</tr>
	<tr>
			<td width="30%"><?php echo $model->getAttributeLabel('status');?></td>
			<td><?php echo $model->status;?></td>
		</tr>
	<?php if($this->isApprover($model->staffCode) || ( $model->reasonID =="66" && Yii::app()->user->checkAccess('hr admin'))){?>
		<tr>
			<td>Action</td>
			
			<?php 
			
			
			
			$logApproved = $this->checkApprovalLog($model->id, Yii::app()->user->getState('staffCode'));
			
			
			
			
			if($logApproved){ 
			
				if($logApproved->status =="APPROVED"){
							$label = "success";
							$text = "Approved";
						}else{
							$label = "danger";
							$text = "Rejected";
						}
			?>
				<td>You <?php echo $text;?> on <?php echo $log->createDate;?>.</td>
			<?php }else{ ?>
			<td>
			<?php 
			$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
				'id'=>'leave-application-form',
				'enableAjaxValidation'=>false,
				'enableClientValidation' => true,
				'htmlOptions'=>array(
					'enctype' => 'multipart/form-data',
					'class' => 'well'
				),
				'clientOptions' => array(
                'validateOnSubmit' => true,
				),
				)); 
			?>
			<?php echo $form->errorSummary($model); ?>
			
			<?php echo $form->dropDownListGroup(
			$model,
			'ApproveDropdown',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
					
				),
				'widgetOptions' => array(
					//'prompt'=>'Please choose',
					'data' => array("APPROVED"=>"Approve","REJECTED"=>"Reject"),
					'htmlOptions' => array(
						'prompt'=>'Please choose'
					),
				),
				
			)
		); ?>
		<?php echo $form->textAreaGroup($model,'commentRemarks', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>
		<div class="form-actions">
	<div class="btn-group btn-group-justified" role="group" aria-label="">
  <div class="btn-group" role="group">
  

  
	<?php $this->widget('booster.widgets.TbButton', array(
			//'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Submit',
			'id'=>'submitModal',
			'htmlOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#myModal',
			),

		)); ?>
	</div>
</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4>Reminder</h4>
    </div>
 
    <div class="modal-body">
        <p>Once you have confirmed, you CAN NOT roll back the action!</p>
        <p>Are you sure to continue?</p>
    </div>
 
    <div class="modal-footer">
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'context' => 'primary',
                'label' => 'Yes',
                'buttonType'=>'submit',
                //'url' => '#',
                'htmlOptions' => array('class' => 'btn-lg'),
            )
        ); ?>
        <?php $this->widget(
            'booster.widgets.TbButton',
            array(
                'label' => 'No',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
</div>
</div>
</div>
<?php $this->endWidget(); ?>
</td>
			<?php } ?>
		</tr>
	<?php } ?>
	</table>
  <!--/div-->
  
  
  </div>
</div>

<div class="btn-group btn-group-justified" role="group" aria-label="">
  <div class="btn-group" role="group">
    <a class="btn btn-default" href="<?php echo Yii::app()->request->urlReferrer;?>" role="button">Back</a>
  </div>
  
  
  
</div>
<script>
$("#submitModal").prop("disabled", true);
/* $("#myModal").modal({

  keyboard: false,
  backdrop: 'static',

}); */
$('body').on('change','#LeaveApplication_ApproveDropdown',function(){
	if($(this).val()==""){
		//console.log($(this));
		$("#submitModal").prop("disabled", true);
		
	}else{
		$("#submitModal").prop("disabled", false);
	}
	
});
</script>

