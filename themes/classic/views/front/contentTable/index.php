<?php
$this->breadcrumbs=array(
	'Content Tables',
);

$this->menu=array(
array('label'=>'Create ContentTable','url'=>array('create')),
array('label'=>'Manage ContentTable','url'=>array('admin')),
);
?>

<h1>Content Tables</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
