<?php
$this->breadcrumbs=array(
	'Attendance Remarks'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List AttendanceRemarks','url'=>array('index')),
array('label'=>'Create AttendanceRemarks','url'=>array('create')),
array('label'=>'Update AttendanceRemarks','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete AttendanceRemarks','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage AttendanceRemarks','url'=>array('admin')),
);
?>

<h1>View AttendanceRemarks #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'staffCode',
		'timeRecord',
		'createdBy',
		'createDate',
),
)); ?>
