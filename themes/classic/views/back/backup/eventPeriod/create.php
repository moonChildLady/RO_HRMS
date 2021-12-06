<?php
/* @var $this EventPeriodController */
/* @var $model EventPeriod */

$this->breadcrumbs=array(
	'Event Periods'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EventPeriod', 'url'=>array('index')),
	array('label'=>'Manage EventPeriod', 'url'=>array('admin')),
);
?>

<h1>Create EventPeriod</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>