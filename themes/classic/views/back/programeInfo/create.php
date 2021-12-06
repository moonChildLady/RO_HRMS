<?php
/* @var $this ProgrameInfoController */
/* @var $model ProgrameInfo */

$this->breadcrumbs=array(
	'Programe Infos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProgrameInfo', 'url'=>array('index')),
	array('label'=>'Manage ProgrameInfo', 'url'=>array('admin')),
);
?>

<h1>Create ProgrameInfo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>