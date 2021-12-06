<?php
/* @var $this LwwSelectionController */
/* @var $model LwwSelection */

$this->breadcrumbs=array(
	'Lww Selections'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LwwSelection', 'url'=>array('index')),
	array('label'=>'Create LwwSelection', 'url'=>array('create')),
	array('label'=>'View LwwSelection', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LwwSelection', 'url'=>array('admin')),
);
?>

<h1>Update LwwSelection <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>