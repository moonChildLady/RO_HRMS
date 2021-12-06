<?php
$this->breadcrumbs=array(
	'Holidays'=>array('index'),
	'Create',
);

/* $this->menu=array(
array('label'=>'List Holidays','url'=>array('index')),
array('label'=>'Manage Holidays','url'=>array('admin')),
); */
?>

<h3>New Holidays</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>