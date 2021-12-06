<?php
$this->breadcrumbs=array(
	'Admin Users',
);

$this->menu=array(
array('label'=>'Create AdminUsers','url'=>array('create')),
array('label'=>'Manage AdminUsers','url'=>array('admin')),
);
?>

<h1>Admin Users</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
