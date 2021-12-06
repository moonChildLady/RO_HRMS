<?php
$this->breadcrumbs=array(
	'Leave Application Applies'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List LeaveApplicationApply','url'=>array('index')),
array('label'=>'Create LeaveApplicationApply','url'=>array('create')),
array('label'=>'Update LeaveApplicationApply','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete LeaveApplicationApply','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage LeaveApplicationApply','url'=>array('admin')),
);
?>

<h1>View LeaveApplicationApply #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'startDate',
		'endDate',
		'applyStartDate',
		'applyEndDate',
),
)); ?>
