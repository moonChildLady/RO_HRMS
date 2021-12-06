<?php
$this->breadcrumbs=array(
	'Leave Balances',
);

$this->menu=array(
array('label'=>'Create LeaveBalance','url'=>array('create')),
array('label'=>'Manage LeaveBalance','url'=>array('admin')),
);
?>

<h1>Leave Balances</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
