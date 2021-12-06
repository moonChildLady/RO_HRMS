<?php
$this->breadcrumbs=array(
	'Attendance Remarks',
);

$this->menu=array(
array('label'=>'Create AttendanceRemarks','url'=>array('create')),
array('label'=>'Manage AttendanceRemarks','url'=>array('admin')),
);
?>

<h1>Attendance Remarks</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
