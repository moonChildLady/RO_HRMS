<?php
$this->breadcrumbs=array(
	'Alternate Duties'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List AlternateDuty','url'=>array('index')),
array('label'=>'Create AlternateDuty','url'=>array('create')),
array('label'=>'Update AlternateDuty','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete AlternateDuty','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage AlternateDuty','url'=>array('admin')),
);
?>

<h1>View AlternateDuty #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'dutyDate',
		'stauts',
		'groupID',
),
)); ?>
