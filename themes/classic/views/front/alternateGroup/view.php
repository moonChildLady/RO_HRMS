<?php
$this->breadcrumbs=array(
	'Alternate Groups'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List AlternateGroup','url'=>array('index')),
array('label'=>'Create AlternateGroup','url'=>array('create')),
array('label'=>'Update AlternateGroup','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete AlternateGroup','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage AlternateGroup','url'=>array('admin')),
);
?>

<h1>View AlternateGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'staffCode',
		'groupID',
		'status',
),
)); ?>
