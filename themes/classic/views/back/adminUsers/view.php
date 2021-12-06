<?php
$this->breadcrumbs=array(
	'Admin Users'=>array('index'),
	$model->admin_id,
);

/* $this->menu=array(
array('label'=>'List AdminUsers','url'=>array('index')),
array('label'=>'Create AdminUsers','url'=>array('create')),
array('label'=>'Update AdminUsers','url'=>array('update','id'=>$model->admin_id)),
array('label'=>'Delete AdminUsers','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->admin_id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage AdminUsers','url'=>array('admin')),
); */
?>

<h1>View AdminUsers #<?php echo $model->admin_id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		//'admin_id',
		//'user_id',
		array('label'=>'User Name', 'value'=>$model->useradmin->enName),
		array('label'=>'Event Name', 'value'=>$model->events->eventName),
		//'event_id',
		'status',
),
)); ?>
<a class="btn btn-default" href="<?php echo Yii::app()->request->urlReferrer;?>" role="button">Back</a>