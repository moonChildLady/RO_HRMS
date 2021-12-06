<?php
$this->breadcrumbs=array(
	'Www Projects'=>array('index'),
	$model->title,
);

$this->menu=array(
array('label'=>'List wwwProjects','url'=>array('index')),
array('label'=>'Create wwwProjects','url'=>array('create')),
array('label'=>'Update wwwProjects','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete wwwProjects','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage wwwProjects','url'=>array('admin')),
);
?>

<h1>View wwwProjects #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'title',
		'projectName',
		'location',
		'nature',
		'contractSum',
		'clientName',
		'architect',
		'mainContrator',
		'status',
		'createDate',
),
)); ?>
