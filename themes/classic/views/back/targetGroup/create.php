<?php
$this->breadcrumbs=array(
	'Target Groups'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List TargetGroup','url'=>array('index')),
array('label'=>'Manage TargetGroup','url'=>array('admin')),
);
?>

<h1>Create TargetGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>