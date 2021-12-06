<?php
$this->breadcrumbs=array(
	'Lww Results'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List LwwResult','url'=>array('index')),
array('label'=>'Manage LwwResult','url'=>array('admin')),
);
?>

<h1>Create LwwResult</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>