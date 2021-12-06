<?php
$this->breadcrumbs=array(
	'Attendance Records'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List AttendanceRecords','url'=>array('index')),
array('label'=>'Manage AttendanceRecords','url'=>array('admin')),
);
?>

<h1>Create Attendance Records</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>