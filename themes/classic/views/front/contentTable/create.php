<?php
$this->breadcrumbs=array(
	'Content Tables'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List ContentTable','url'=>array('index')),
array('label'=>'Manage ContentTable','url'=>array('admin')),
);
?>

<h1>Create ContentTable</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>