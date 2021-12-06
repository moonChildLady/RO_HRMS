<?php
$this->breadcrumbs=array(
	'Sspresults'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List SSPResults','url'=>array('index')),
array('label'=>'Manage SSPResults','url'=>array('admin')),
);
?>

<h1>Create SSPResults</h1>

<?php echo $this->renderPartial('_form_SSPResult', array('model'=>$model)); ?>