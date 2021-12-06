<?php
$this->breadcrumbs=array(
	'Alternate Duties'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List AlternateDuty','url'=>array('index')),
	array('label'=>'Create AlternateDuty','url'=>array('create')),
	array('label'=>'View AlternateDuty','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage AlternateDuty','url'=>array('admin')),
	);
	?>

	<h1>Update AlternateDuty <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>