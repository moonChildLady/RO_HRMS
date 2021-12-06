<?php
$this->breadcrumbs=array(
	'Subs'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Sub','url'=>array('index')),
array('label'=>'Create Sub','url'=>array('create')),
array('label'=>'Update Sub','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Sub','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Sub','url'=>array('admin')),
);
?>

<h1>View Sub #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'sub_id',
		'sub_name',
		'quota',
		'acayear',
		'subevtid',
		'id',
),
)); ?>
