<?php
$this->breadcrumbs=array(
	'Lww Results',
);

$this->menu=array(
array('label'=>'Create LwwResult','url'=>array('create')),
array('label'=>'Manage LwwResult','url'=>array('admin')),
);
?>

<h1>Lww Results</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
