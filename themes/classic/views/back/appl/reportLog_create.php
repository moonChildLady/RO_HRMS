<?php
$this->breadcrumbs=array(
	'Report Logs'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List ReportLog','url'=>array('index')),
array('label'=>'Manage ReportLog','url'=>array('admin')),
);
?>

<h1>Create ReportLog</h1>

<?php echo $this->renderPartial('reportLog_form', array('model'=>$model)); ?>