<?php
$this->breadcrumbs=array(
	'Leave Balances'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/* 	$this->menu=array(
	array('label'=>'List LeaveBalance','url'=>array('index')),
	array('label'=>'Create LeaveBalance','url'=>array('create')),
	array('label'=>'View LeaveBalance','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage LeaveBalance','url'=>array('admin')),
	); */
	?>

	<h3>Update LeaveBalance <?php echo $model->stffCode0->Fullname; ?></h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>