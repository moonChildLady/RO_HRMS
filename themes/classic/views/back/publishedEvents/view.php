<?php
$this->breadcrumbs=array(
	'Published Events'=>array('index'),
	$model->event_id,
);

/* $this->menu=array(
array('label'=>'List PublishedEvents','url'=>array('index')),
array('label'=>'Create PublishedEvents','url'=>array('create')),
array('label'=>'Update PublishedEvents','url'=>array('update','id'=>$model->event_id)),
array('label'=>'Delete PublishedEvents','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->event_id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PublishedEvents','url'=>array('admin')),
); */
?>

<h1>View PublishedEvents #<?php echo $model->event_id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'event_id',
		'eventName',
		'dbName',
		'controller',
		'slipName',
		'startDate',
		'endDate',
		'extStart',
		'extEnd',
		'url',
		//'InputBy',
		array('label'=>'InputBy', 'value'=>$model->inputBy->enName),
		array('label'=>'ModifyBy', 'value'=>(!empty($model->modifyBy->enName))?$model->modifyBy->enName:""),
		//'ModifyBy',
		'academicYear',
		'publishDate',
		'lastUpdate',
		'shown',
		'status',
),
)); ?>
<a class="btn btn-default" href="<?php echo Yii::app()->request->urlReferrer;?>" role="button">Back</a>
