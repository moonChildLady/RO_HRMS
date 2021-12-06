<?php
$this->breadcrumbs=array(
	'Attendance Remarks'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List AttendanceRemarks','url'=>array('index')),
array('label'=>'Manage AttendanceRemarks','url'=>array('admin')),
);
?>

<h1>Create AttendanceRemarks</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>