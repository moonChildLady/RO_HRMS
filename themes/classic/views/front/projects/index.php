<?php
$this->breadcrumbs=array(
	'Projects',
);

$this->menu=array(
array('label'=>'Create Projects','url'=>array('create')),
array('label'=>'Manage Projects','url'=>array('admin')),
);
?>

<h1>Projects</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
