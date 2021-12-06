<?php
$this->breadcrumbs=array(
	'Admin Users'=>array('index'),
	'Create',
);

/* $this->menu=array(
array('label'=>'List AdminUsers','url'=>array('index')),
array('label'=>'Manage AdminUsers','url'=>array('admin')),
); */
?>

<h3>Create AdminUsers</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>