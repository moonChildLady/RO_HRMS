<?php
$this->breadcrumbs=array(
	'Alternate Groups'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List AlternateGroup','url'=>array('index')),
	array('label'=>'Create AlternateGroup','url'=>array('create')),
	array('label'=>'View AlternateGroup','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage AlternateGroup','url'=>array('admin')),
	);
	?>

	<h1>Update AlternateGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>