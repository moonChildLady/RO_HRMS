<?php
$this->breadcrumbs=array(
	'Appls'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Appl','url'=>array('index')),
array('label'=>'Create Appl','url'=>array('create')),
array('label'=>'Update Appl','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Appl','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Appl','url'=>array('admin')),
);
?>

<h1>View Appl #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'evtid',
		'pre',
		'acayear',
		'stid',
		'remks',
		'parentName',
		'phoneNo',
		'event',
		'appdate',
),
)); ?>
