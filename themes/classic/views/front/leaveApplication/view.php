


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
  <div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<td width="30%">Ref. No</td>
			<td><?php echo $model->refNo;?></td>
		</tr>
		<tr>
			<td width="30%">Staff</td>
			<td><?php echo $model->staffCode0->FullnamewithStaffCode;?></td>
		</tr>
		<tr>
			<td width="30%">Duration</td>
			
			<td><p><?php echo date("Y-m-d", strtotime($model->startDate));?> (<?php echo date("D", strtotime($model->startDate));?>) [<?php echo $model->startDateType;?>] to <?php echo date("Y-m-d", strtotime($model->endDate));?> (<?php echo date("D", strtotime($model->endDate));?>) [<?php echo $model->endDateType;?>]</p>
			<?php
			
			
			echo $this->clacDuration($model->id);
			?> Day(s)
			</p>
			
			</td>
		</tr>
		<tr>
			<td width="30%"><?php echo $model->getAttributeLabel('reasonID');?></td>
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
			
			echo Yii::app()->createURL("LeaveApplication/getAttachment", array('code'=>md5($model->attachments->id.$model->attachments->createDate))); ?>">Download [<?php echo strtoupper(pathinfo($model->attachments->fileLocation, PATHINFO_EXTENSION));
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
		<tr>
			<td width="30%"><?php echo $model->getAttributeLabel('status');?></td>
			<td><?php echo $model->status;?></td>
		</tr>
	</tr>


	</table>
  </div>
  </div>
</div>

<div class="btn-group btn-group-justified" role="group" aria-label="">
  <div class="btn-group" role="group">
    <a class="btn btn-default" href="<?php echo Yii::app()->createURL("LeaveApplication/Listview");?>" role="button">Back</a>
  </div>
  
  
  
</div>


