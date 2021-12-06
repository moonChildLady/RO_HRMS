<?php
$this->breadcrumbs=array(
	'Leave Application Applies'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List LeaveApplicationApply','url'=>array('index')),
	array('label'=>'Create LeaveApplicationApply','url'=>array('create')),
	array('label'=>'View LeaveApplicationApply','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage LeaveApplicationApply','url'=>array('admin')),
	);
	?>

	<h3>Update Applcation Peroid <?php echo $model->applyStartDate; ?> to <?php echo $model->applyEndDate; ?></h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>