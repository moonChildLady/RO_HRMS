<?php
$this->breadcrumbs=array(
	'Admin Users'=>array('index'),
	$model->admin_id=>array('view','id'=>$model->admin_id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List AdminUsers','url'=>array('index')),
	array('label'=>'Create AdminUsers','url'=>array('create')),
	array('label'=>'View AdminUsers','url'=>array('view','id'=>$model->admin_id)),
	array('label'=>'Manage AdminUsers','url'=>array('admin')),
	);
	?>

	<h1>Update AdminUsers <?php echo $model->admin_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>