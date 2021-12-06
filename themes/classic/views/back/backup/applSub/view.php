<?php
$this->breadcrumbs=array(
	'Appl Subs'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List ApplSub','url'=>array('index')),
array('label'=>'Create ApplSub','url'=>array('create')),
array('label'=>'Update ApplSub','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete ApplSub','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage ApplSub','url'=>array('admin')),
);
?>

<h1>View ApplSub #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'evtid',
		'subevtid',
		'pre',
		'acayear',
		'stid',
		'ts',
		'choice',
),
)); ?>
