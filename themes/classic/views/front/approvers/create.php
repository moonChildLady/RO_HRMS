<?php
$this->breadcrumbs=array(
	'Approvers'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Approvers','url'=>array('index')),
array('label'=>'Manage Approvers','url'=>array('admin')),
);
?>

<h1>Create Approvers</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>