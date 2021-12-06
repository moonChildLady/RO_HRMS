<?php
$this->breadcrumbs=array(
	'Attendance Records'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List AttendanceRecords','url'=>array('index')),
	array('label'=>'Create AttendanceRecords','url'=>array('create')),
	array('label'=>'View AttendanceRecords','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage AttendanceRecords','url'=>array('admin')),
	);
	?>

	<h1>Update AttendanceRecords <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>