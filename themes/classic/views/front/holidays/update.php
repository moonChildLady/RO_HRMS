<?php
$this->breadcrumbs=array(
	'Holidays'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/* 	$this->menu=array(
	array('label'=>'List Holidays','url'=>array('index')),
	array('label'=>'Create Holidays','url'=>array('create')),
	array('label'=>'View Holidays','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Holidays','url'=>array('admin')),
	); */
	?>

	<h3>Update Holidays <?php echo $model->eventDate; ?></h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>