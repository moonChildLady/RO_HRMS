<?php
$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	'Create',
);

/* $this->menu=array(
array('label'=>'List LeaveApplication','url'=>array('index')),
array('label'=>'Manage LeaveApplication','url'=>array('admin')),
); */
?>
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Personal Information</h3>
  </div>
  <div class="panel-body">
	<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<tr>
			<td width="30%">Staff Code</td>
			<td><?php echo $modelUser->staffCode0->staffCode;?></td>
		</tr>
		<tr>
			<td width="30%">Name</td>
			<td><?php echo $modelUser->staffCode0->Fullname;?> <?php echo $modelUser->staffCode0->chineseName;?></td>
		</tr>
		<tr>
			<td width="30%">Email</td>
			<td><?php echo $modelUser->staffCode0->email;?></td>
		</tr>
		<tr>
			<td width="30%">Position</td>
			<td><?php echo $modelUser->staffCodeEmploy->position->content;?></td>
		</tr>
		<tr>
			<td width="30%">Join Date</td>
			<td><?php echo date("Y-m-d", strtotime($modelUser->staffCodeEmploy->startDate));?></td>
		</tr>
	</table>
</div>
  </div>
  </div>
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">New Leave Application</h3>
  </div>
  <div class="panel-body">
  
<?php 

echo $this->renderPartial('_applyleave', array(
	'model'=>$model,
	'LeaveApplicationApply'=>$LeaveApplicationApply,
	'modelUser'=>$modelUser,
)); 

?>

</div>
</div>