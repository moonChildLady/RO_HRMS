<?php
$this->breadcrumbs=array(
	'Events Permits',
);

$this->menu=array(
array('label'=>'Create EventsPermit','url'=>array('create')),
array('label'=>'Manage EventsPermit','url'=>array('admin')),
);
?>

<h1>Events Permits</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
