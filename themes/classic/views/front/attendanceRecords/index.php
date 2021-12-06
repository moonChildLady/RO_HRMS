<?php
$this->breadcrumbs=array(
	'Attendance Records',
);

$this->menu=array(
array('label'=>'Create AttendanceRecords','url'=>array('create')),
array('label'=>'Manage AttendanceRecords','url'=>array('admin')),
);
?>

<h1>Attendance Records</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
