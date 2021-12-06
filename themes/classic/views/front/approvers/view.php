<?php
$this->breadcrumbs=array(
	'Approvers'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Approvers','url'=>array('index')),
array('label'=>'Create Approvers','url'=>array('create')),
array('label'=>'Update Approvers','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Approvers','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Approvers','url'=>array('admin')),
);
?>

<h1>View Approvers #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'staffCode',
		'approver',
		'position',
),
)); ?>
