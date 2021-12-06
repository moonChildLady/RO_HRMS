<?php
$this->breadcrumbs=array(
	'Www Projects'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List wwwProjects','url'=>array('index')),
array('label'=>'Manage wwwProjects','url'=>array('admin')),
);
?>

<h1>Create Projects</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'typeModel'=>$typeModel, 'ImagesModel'=>$ImagesModel)); ?>