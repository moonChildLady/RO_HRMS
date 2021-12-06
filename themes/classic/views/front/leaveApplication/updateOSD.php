<?php
$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	/* $this->menu=array(
	array('label'=>'List LeaveApplication','url'=>array('index')),
	array('label'=>'Create LeaveApplication','url'=>array('create')),
	array('label'=>'View LeaveApplication','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage LeaveApplication','url'=>array('admin')),
	); */
	?>
<?php foreach(Yii::app()->user->getFlashes() as $key => $message) {
?>




<div class="alert alert-<?php echo $key;?> alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
 <?php echo $message;?>
</div>
<?php } ?>
	<h3>Update Leave Application [<?php echo $model->staffCode0->FullnamewithStaffCode; ?>] [Ref. No.: <?php echo $model->refNo;?>]</h3>
<?php 

echo $this->renderPartial('_formOSD',array('model'=>$model));

 ?>
