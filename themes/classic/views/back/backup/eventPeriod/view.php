<?php
/* @var $this EventPeriodController */
/* @var $model EventPeriod */

$this->breadcrumbs=array(
	'Event Periods'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EventPeriod', 'url'=>array('index')),
	array('label'=>'Create EventPeriod', 'url'=>array('create')),
	array('label'=>'Update EventPeriod', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EventPeriod', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EventPeriod', 'url'=>array('admin')),
);
?>

<h1>View EventPeriod #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'evenetName',
		'startDay',
		'endDay',
		'status',
	),
)); ?>
