<?php
$this->breadcrumbs=array(
	'Lww Results'=>array('index'),
	$model->result_id=>array('view','id'=>$model->result_id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List LwwResult','url'=>array('index')),
	array('label'=>'Create LwwResult','url'=>array('create')),
	array('label'=>'View LwwResult','url'=>array('view','id'=>$model->result_id)),
	array('label'=>'Manage LwwResult','url'=>array('admin')),
	);
	?>

	<h1>Update LwwResult <?php echo $model->result_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>