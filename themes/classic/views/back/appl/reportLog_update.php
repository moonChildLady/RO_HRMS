<?php
$this->breadcrumbs=array(
	'Report Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List ReportLog','url'=>array('index')),
	array('label'=>'Create ReportLog','url'=>array('create')),
	array('label'=>'View ReportLog','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ReportLog','url'=>array('admin')),
	);
	?>

	<h1>Update ReportLog <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('reportLog_form',array('model'=>$model)); ?>