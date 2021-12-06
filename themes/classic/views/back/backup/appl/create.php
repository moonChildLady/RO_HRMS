<?php
$this->breadcrumbs=array(
	'Appls'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Appl','url'=>array('index')),
array('label'=>'Manage Appl','url'=>array('admin')),
);
?>

<h1>Create Appl</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>