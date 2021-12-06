<?php
$this->breadcrumbs=array(
	'Attendance Remarks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List AttendanceRemarks','url'=>array('index')),
	array('label'=>'Create AttendanceRemarks','url'=>array('create')),
	array('label'=>'View AttendanceRemarks','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage AttendanceRemarks','url'=>array('admin')),
	);
	?>

	<h1>Update AttendanceRemarks <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>