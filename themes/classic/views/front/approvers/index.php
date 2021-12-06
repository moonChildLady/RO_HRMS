<?php
$this->breadcrumbs=array(
	'Approvers',
);

$this->menu=array(
array('label'=>'Create Approvers','url'=>array('create')),
array('label'=>'Manage Approvers','url'=>array('admin')),
);
?>

<h1>Approvers</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
