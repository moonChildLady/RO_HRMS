<?php
$this->breadcrumbs=array(
	'Published Events'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List PublishedEvents','url'=>array('index')),
array('label'=>'Manage PublishedEvents','url'=>array('admin')),
);
?>

<h1>Create PublishedEvents</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>