<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->staffCode,
);

?>
<!--div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Settings</h3>
  </div>
  <div class="panel-body">
  
  
	<div class="btn-group">
  <a class="btn btn btn-success" href="<?php echo Yii::app()->createURL("users/changepassword");?>" role="button">Change Password</a>
</div>


  </div>
</div-->
  


<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Personal Information</h3>
  </div>
  <div class="panel-body">
  <div class="table-responsive">
	<table class="table table-bordered table-striped">
		<tr>
			<td width="30%">Staff Code</td>
			<td><?php echo $model->staffCode0->staffCode;?></td>
		</tr>
		<tr>
			<td width="30%">Name</td>
			<td><?php echo $model->staffCode0->Fullname;?> <?php echo $model->staffCode0->chineseName;?></td>
		</tr>
		<tr>
			<td width="30%">Email</td>
			<td><?php echo $model->staffCode0->email;?></td>
		</tr>
		<tr>
			<td width="30%">Position</td>
			<td><?php echo $model->staffCodeEmploy->position->content;?></td>
		</tr>
		<tr>
			<td width="30%">Join Date</td>
			<td><?php echo date("Y-m-d", strtotime($model->staffCodeEmploy->startDate));?></td>
		</tr>
	</table>
</div>
</div>
</div>
