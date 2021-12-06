<?php
/* @var $this LwwSelectionController */
/* @var $model LwwSelection */

$this->breadcrumbs=array(
	'Lww Selections'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LwwSelection', 'url'=>array('index')),
	array('label'=>'Manage LwwSelection', 'url'=>array('admin')),
);
?>

<h1>Create LwwSelection</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>