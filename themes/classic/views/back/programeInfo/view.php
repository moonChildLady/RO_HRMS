<?php
/* @var $this ProgrameInfoController */
/* @var $model ProgrameInfo */

$this->breadcrumbs=array(
	'Programe Infos'=>array('index'),
	$model->pid,
);

$this->menu=array(
	array('label'=>'List ProgrameInfo', 'url'=>array('index')),
	array('label'=>'Create ProgrameInfo', 'url'=>array('create')),
	array('label'=>'Update ProgrameInfo', 'url'=>array('update', 'id'=>$model->pid)),
	array('label'=>'Delete ProgrameInfo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->pid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProgrameInfo', 'url'=>array('admin')),
);
?>

<h1>View ProgrameInfo #<?php echo $model->pid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'pid',
		'quotaMin',
		'quotaTarget',
		'quotaMax',
		'permLvl',
		'permLvl2',
		'chName',
		'enName',
		'programeId',
		'cost',
		'location',
		's1Quota',
		's2Quota',
		's3Quota',
		's4Quota',
		's5Quota',
	),
)); ?>
