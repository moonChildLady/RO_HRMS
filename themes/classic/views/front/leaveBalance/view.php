<?php
$this->breadcrumbs=array(
	'Leave Balances'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List LeaveBalance','url'=>array('index')),
array('label'=>'Create LeaveBalance','url'=>array('create')),
array('label'=>'Update LeaveBalance','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete LeaveBalance','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage LeaveBalance','url'=>array('admin')),
);
?>

<h1>View LeaveBalance #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'staffCode',
		'balanceDate',
		'balance',
),
)); ?>
