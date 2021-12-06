<?php
$this->breadcrumbs=array(
	'Sspresults',
);

$this->menu=array(
array('label'=>'Create SSPResults','url'=>array('create')),
array('label'=>'Manage SSPResults','url'=>array('admin')),
);
?>

<h1>Sspresults</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view_SSPresult',
)); ?>
