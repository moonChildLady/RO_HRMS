<?php
$this->breadcrumbs=array(
	'Appls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Appl','url'=>array('index')),
	array('label'=>'Create Appl','url'=>array('create')),
	array('label'=>'View Appl','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Appl','url'=>array('admin')),
	);
	?>

	<h1>Update Appl <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>