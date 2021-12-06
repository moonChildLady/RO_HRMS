<?php
$this->breadcrumbs=array(
	'Target Groups',
);

$this->menu=array(
array('label'=>'Create TargetGroup','url'=>array('create')),
array('label'=>'Manage TargetGroup','url'=>array('admin')),
);
?>

<h1>Target Groups</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
