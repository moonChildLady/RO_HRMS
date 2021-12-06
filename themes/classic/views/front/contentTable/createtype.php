<?php
$this->breadcrumbs=array(
	'Content Tables'=>array('index'),
	'Create',
);

/* $this->menu=array(
array('label'=>'List ContentTable','url'=>array('index')),
array('label'=>'Manage ContentTable','url'=>array('admin')),
); */
?>

<h3>Create <?php echo Yii::app()->getRequest()->getParam('type');?></h3>

<?php echo $this->renderPartial('_formtype', array('model'=>$model)); ?>