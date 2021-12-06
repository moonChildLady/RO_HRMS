<?php
$this->breadcrumbs=array(
	'Lww Results'=>array('index'),
	$model->result_id,
);

$this->menu=array(
array('label'=>'List LwwResult','url'=>array('index')),
array('label'=>'Create LwwResult','url'=>array('create')),
array('label'=>'Update LwwResult','url'=>array('update','id'=>$model->result_id)),
array('label'=>'Delete LwwResult','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->result_id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage LwwResult','url'=>array('admin')),
);
?>

<h1>View LwwResult #<?php echo $model->result_id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'result_id',
		'regNo',
		'choice',
		'pid',
		'remark',
),
)); ?>
