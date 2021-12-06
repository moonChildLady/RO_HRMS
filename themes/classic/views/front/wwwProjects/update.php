<?php
$this->breadcrumbs=array(
	'Www Projects'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List wwwProjects','url'=>array('index')),
	array('label'=>'Create wwwProjects','url'=>array('create')),
	array('label'=>'View wwwProjects','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage wwwProjects','url'=>array('admin')),
	);
	?>

	<h1>Update wwwProjects <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model, 'typeModel'=>$typeModel, 'ImagesModel'=>$ImagesModel)); ?>