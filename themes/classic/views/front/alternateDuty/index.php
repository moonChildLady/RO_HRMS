<?php
$this->breadcrumbs=array(
	'Alternate Duties',
);

$this->menu=array(
array('label'=>'Create AlternateDuty','url'=>array('create')),
array('label'=>'Manage AlternateDuty','url'=>array('admin')),
);
?>

<h1>Alternate Duties</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
