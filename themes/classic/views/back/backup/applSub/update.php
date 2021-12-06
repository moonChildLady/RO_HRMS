<?php
$this->breadcrumbs=array(
	'Appl Subs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List ApplSub','url'=>array('index')),
	array('label'=>'Create ApplSub','url'=>array('create')),
	array('label'=>'View ApplSub','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ApplSub','url'=>array('admin')),
	);
	?>

	<h1>Update ApplSub <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>