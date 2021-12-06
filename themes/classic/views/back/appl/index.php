<?php
$this->breadcrumbs=array(
	'Appls',
);

$this->menu=array(
array('label'=>'Create Appl','url'=>array('create')),
array('label'=>'Manage Appl','url'=>array('admin')),
);
?>

<h1>Appls</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
