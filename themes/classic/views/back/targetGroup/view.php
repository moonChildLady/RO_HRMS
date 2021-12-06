<?php
$this->breadcrumbs=array(
	'Target Groups'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List TargetGroup','url'=>array('index')),
array('label'=>'Create TargetGroup','url'=>array('create')),
array('label'=>'Update TargetGroup','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete TargetGroup','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage TargetGroup','url'=>array('admin')),
);
?>

<h1>View TargetGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'event_id',
		'classLevel',
		'status',
),
)); ?>
