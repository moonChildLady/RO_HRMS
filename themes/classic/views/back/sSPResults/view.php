<?php
$this->breadcrumbs=array(
	'Sspresults'=>array('index'),
	$model->results_id,
);

$this->menu=array(
array('label'=>'List SSPResults','url'=>array('index')),
array('label'=>'Create SSPResults','url'=>array('create')),
array('label'=>'Update SSPResults','url'=>array('update','id'=>$model->results_id)),
array('label'=>'Delete SSPResults','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->results_id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage SSPResults','url'=>array('admin')),
);
?>

<h1>View SSPResults #<?php echo $model->results_id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'results_id',
		'stid',
		'acayear',
		'x3',
		'x3pre',
		'x2',
		'x2pre',
		'class',
		'classpre',
),
)); ?>
