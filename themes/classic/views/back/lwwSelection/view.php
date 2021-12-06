<?php
/* @var $this LwwSelectionController */
/* @var $model LwwSelection */

$this->breadcrumbs=array(
	'Lww Selections'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LwwSelection', 'url'=>array('index')),
	array('label'=>'Create LwwSelection', 'url'=>array('create')),
	array('label'=>'Update LwwSelection', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LwwSelection', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LwwSelection', 'url'=>array('admin')),
);
?>

<h1>View LwwSelection #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'regNo',
		'ch01',
		'ch02',
		'ch03',
		'ch04',
		'ch05',
		'ch06',
		'ch07',
		'ch08',
		'ch09',
		'ch10',
		'ch11',
		'ch12',
		'ch13',
		'ch14',
		'ch15',
		'ch16',
		'ch17',
		'ch18',
		'ch19',
		'ch20',
		'email',
		'IPAddress',
		'parentName',
		'SMS',
		'Financial',
		'Declaration',
		'Born',
		'TravelDoc',
		'lastLogin',
		'createDate',
		'saveMode'
	),
)); ?>
