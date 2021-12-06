<?php
$this->breadcrumbs=array(
	'Alternate Groups',
);

$this->menu=array(
array('label'=>'Create AlternateGroup','url'=>array('create')),
array('label'=>'Manage AlternateGroup','url'=>array('admin')),
);
?>

<h1>Alternate Groups</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
