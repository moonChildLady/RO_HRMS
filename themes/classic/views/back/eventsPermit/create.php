<?php
$this->breadcrumbs=array(
	'Events Permits'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List EventsPermit','url'=>array('index')),
array('label'=>'Manage EventsPermit','url'=>array('admin')),
);
?>

<h1>Create EventsPermit</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>