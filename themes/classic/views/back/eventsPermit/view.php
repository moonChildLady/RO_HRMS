<?php
$this->breadcrumbs=array(
	'Events Permits'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List EventsPermit','url'=>array('index')),
array('label'=>'Create EventsPermit','url'=>array('create')),
array('label'=>'Update EventsPermit','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete EventsPermit','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage EventsPermit','url'=>array('admin')),
);
?>

<h1>View EventsPermit #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'event_id',
		'S1',
		'S2',
		'S3',
		'S4',
		'S5',
		'S6',
		'S7',
		'TEST',
		'status',
),
)); ?>
