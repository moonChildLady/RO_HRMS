<?php
/* @var $this EventPeriodController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Event Periods',
);

$this->menu=array(
	array('label'=>'Create EventPeriod', 'url'=>array('create')),
	array('label'=>'Manage EventPeriod', 'url'=>array('admin')),
);
?>

<h1>Event Periods</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
