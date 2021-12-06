<?php
$this->breadcrumbs=array(
	'Sspresults'=>array('index'),
	$model->results_id=>array('view','id'=>$model->results_id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List SSPResults','url'=>array('index')),
	array('label'=>'Create SSPResults','url'=>array('create')),
	array('label'=>'View SSPResults','url'=>array('view','id'=>$model->results_id)),
	array('label'=>'Manage SSPResults','url'=>array('admin')),
	);
	?>

	<h1>Update SSPResults <?php echo $model->results_id; ?></h1>

<?php echo $this->renderPartial('_form_SSPResult',array('model'=>$model)); ?>