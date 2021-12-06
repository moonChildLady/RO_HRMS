<?php
$this->breadcrumbs=array(
	'Staff',
);

$this->menu=array(
array('label'=>'Create Staff','url'=>array('create')),
array('label'=>'Manage Staff','url'=>array('admin')),
);
?>

<h1>Staff</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
