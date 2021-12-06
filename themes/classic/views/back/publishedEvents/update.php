<?php
$this->breadcrumbs=array(
	'Published Events'=>array('index'),
	$model->event_id=>array('view','id'=>$model->event_id),
	'Update',
);

	/* $this->menu=array(
	array('label'=>'List PublishedEvents','url'=>array('index')),
	array('label'=>'Create PublishedEvents','url'=>array('create')),
	array('label'=>'View PublishedEvents','url'=>array('view','id'=>$model->event_id)),
	array('label'=>'Manage PublishedEvents','url'=>array('admin')),
	); */
	?>

	<h3>Update Event <?php echo $model->eventName; ?></h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>