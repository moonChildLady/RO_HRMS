<?php
$this->breadcrumbs=array(
	'Published Events',
);

$this->menu=array(
array('label'=>'Create PublishedEvents','url'=>array('create')),
array('label'=>'Manage PublishedEvents','url'=>array('admin')),
);
?>

<h1>Published Events</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
