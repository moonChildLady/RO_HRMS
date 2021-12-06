<?php
$this->breadcrumbs=array(
	'Report Logs',
);

$this->menu=array(
array('label'=>'Create ReportLog','url'=>array('create')),
array('label'=>'Manage ReportLog','url'=>array('admin')),
);
?>

<h1>Report Logs</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
