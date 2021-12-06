<?php
$this->breadcrumbs=array(
	'Www Projects',
);

$this->menu=array(
array('label'=>'Create wwwProjects','url'=>array('create')),
array('label'=>'Manage wwwProjects','url'=>array('admin')),
);
?>

<h1>Www Projects</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
