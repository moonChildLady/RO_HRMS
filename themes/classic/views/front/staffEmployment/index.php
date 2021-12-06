<?php
$this->breadcrumbs=array(
	'Staff Employments',
);

$this->menu=array(
array('label'=>'Create StaffEmployment','url'=>array('create')),
array('label'=>'Manage StaffEmployment','url'=>array('admin')),
);
?>

<h1>Staff Employments</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
