<?php
$this->breadcrumbs=array(
	'Content Tables'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List ContentTable','url'=>array('index')),
array('label'=>'Create ContentTable','url'=>array('create')),
array('label'=>'Update ContentTable','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete ContentTable','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage ContentTable','url'=>array('admin')),
);
?>

<h1>View ContentTable #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'content',
		'type',
),
)); ?>
