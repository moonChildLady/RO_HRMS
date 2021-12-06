<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Projects','url'=>array('index')),
array('label'=>'Create Projects','url'=>array('create')),
array('label'=>'Update Projects','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Projects','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Projects','url'=>array('admin')),
);
?>

<h1>View Projects #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'year',
		'code',
		'code2',
		'projectTitle',
),
)); ?>
