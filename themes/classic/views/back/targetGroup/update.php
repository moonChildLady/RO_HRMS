<?php
$this->breadcrumbs=array(
	'Target Groups'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List TargetGroup','url'=>array('index')),
	array('label'=>'Create TargetGroup','url'=>array('create')),
	array('label'=>'View TargetGroup','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TargetGroup','url'=>array('admin')),
	);
	?>

	<h1>Update TargetGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>