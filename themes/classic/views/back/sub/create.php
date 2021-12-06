<?php
$this->breadcrumbs=array(
	'Subs'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Sub','url'=>array('index')),
array('label'=>'Manage Sub','url'=>array('admin')),
);
?>

<h1>Create Sub</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>