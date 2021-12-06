<?php
$this->breadcrumbs=array(
	'Approvers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	/* $this->menu=array(
	array('label'=>'List Approvers','url'=>array('index')),
	array('label'=>'Create Approvers','url'=>array('create')),
	array('label'=>'View Approvers','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Approvers','url'=>array('admin')),
	); */
	?>

	<h1>Update Approvers <?php echo $model->staffCode0->Fullname; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>