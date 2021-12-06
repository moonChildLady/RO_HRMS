<?php
$this->breadcrumbs=array(
	'Report Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List ReportLog','url'=>array('index')),
array('label'=>'Create ReportLog','url'=>array('create')),
array('label'=>'Update ReportLog','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete ReportLog','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage ReportLog','url'=>array('admin')),
);
?>

<h1>View ReportLog #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'version',
		'date',
		'author',
		'description',
		'remark',
),
)); ?>
