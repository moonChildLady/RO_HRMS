<?php
/* @var $this ProgrameInfoController */
/* @var $model ProgrameInfo */

$this->breadcrumbs=array(
	'Programe Infos'=>array('index'),
	$model->pid=>array('view','id'=>$model->pid),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProgrameInfo', 'url'=>array('index')),
	array('label'=>'Create ProgrameInfo', 'url'=>array('create')),
	array('label'=>'View ProgrameInfo', 'url'=>array('view', 'id'=>$model->pid)),
	array('label'=>'Manage ProgrameInfo', 'url'=>array('admin')),
);
?>

<h1>Update ProgrameInfo <?php echo $model->pid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>