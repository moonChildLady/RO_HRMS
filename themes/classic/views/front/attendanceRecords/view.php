<?php
$this->breadcrumbs=array(
	'Attendance Records'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List AttendanceRecords','url'=>array('index')),
array('label'=>'Create AttendanceRecords','url'=>array('create')),
array('label'=>'Update AttendanceRecords','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete AttendanceRecords','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage AttendanceRecords','url'=>array('admin')),
);
?>

<h1>View AttendanceRecords #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'staffCode',
		'timeRecord',
		'remarks',
),
)); ?>
