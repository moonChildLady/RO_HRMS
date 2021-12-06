<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	'Create',
);

/* $this->menu=array(
array('label'=>'List Projects','url'=>array('index')),
array('label'=>'Manage Projects','url'=>array('admin')),
); */
?>

<h3>Create Projects</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>