<?php
$this->breadcrumbs=array(
	'Holidays'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Holidays','url'=>array('index')),
array('label'=>'Create Holidays','url'=>array('create')),
array('label'=>'Update Holidays','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Holidays','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Holidays','url'=>array('admin')),
);
?>

<h1>View Holidays #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'holidayName',
		'eventDate',
),
)); ?>
