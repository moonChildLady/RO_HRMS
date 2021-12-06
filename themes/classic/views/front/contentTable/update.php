<?php
$this->breadcrumbs=array(
	'Content Tables'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List ContentTable','url'=>array('index')),
	array('label'=>'Create ContentTable','url'=>array('create')),
	array('label'=>'View ContentTable','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ContentTable','url'=>array('admin')),
	);
	?>

	<h1>Update ContentTable <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>