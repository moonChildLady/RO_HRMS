<?php
$this->breadcrumbs=array(
	'Events Permits'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List EventsPermit','url'=>array('index')),
	array('label'=>'Create EventsPermit','url'=>array('create')),
	array('label'=>'View EventsPermit','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage EventsPermit','url'=>array('admin')),
	);
	?>

	<h1>Update EventsPermit <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>