<?php
$this->breadcrumbs=array(
	'Holidays',
);

$this->menu=array(
array('label'=>'Create Holidays','url'=>array('create')),
array('label'=>'Manage Holidays','url'=>array('admin')),
);
?>

<h1>Holidays</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
