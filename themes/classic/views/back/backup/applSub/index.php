<?php
$this->breadcrumbs=array(
	'Appl Subs',
);

$this->menu=array(
array('label'=>'Create ApplSub','url'=>array('create')),
array('label'=>'Manage ApplSub','url'=>array('admin')),
);
?>

<h1>Appl Subs</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
