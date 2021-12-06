<?php
$this->breadcrumbs=array(
	'Subs',
);

$this->menu=array(
array('label'=>'Create Sub','url'=>array('create')),
array('label'=>'Manage Sub','url'=>array('admin')),
);
?>

<h1>Subs</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
