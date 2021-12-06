<?php
/* @var $this EventPeriodController */
/* @var $model EventPeriod */

$this->breadcrumbs=array(
	'Event Periods'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EventPeriod', 'url'=>array('index')),
	array('label'=>'Create EventPeriod', 'url'=>array('create')),
	array('label'=>'View EventPeriod', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EventPeriod', 'url'=>array('admin')),
);
?>

<h1>Update EventPeriod <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>