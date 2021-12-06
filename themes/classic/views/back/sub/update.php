<?php
$this->breadcrumbs=array(
	'Subs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Sub','url'=>array('index')),
	array('label'=>'Create Sub','url'=>array('create')),
	array('label'=>'View Sub','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Sub','url'=>array('admin')),
	);
	?>

	<h1>Update Sub <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>