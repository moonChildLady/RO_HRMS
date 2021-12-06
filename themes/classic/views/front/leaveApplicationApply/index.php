<?php
$this->breadcrumbs=array(
	'Leave Application Applies',
);

$this->menu=array(
array('label'=>'Create LeaveApplicationApply','url'=>array('create')),
array('label'=>'Manage LeaveApplicationApply','url'=>array('admin')),
);
?>

<h1>Leave Application Applies</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
