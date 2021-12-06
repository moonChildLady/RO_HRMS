<?php
$this->breadcrumbs=array(
	'Alternate Groups'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List AlternateGroup','url'=>array('index')),
array('label'=>'Manage AlternateGroup','url'=>array('admin')),
);
?>

<h1>Create AlternateGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>