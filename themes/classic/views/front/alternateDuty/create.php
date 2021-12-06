<?php
$this->breadcrumbs=array(
	'Alternate Duties'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List AlternateDuty','url'=>array('index')),
array('label'=>'Manage AlternateDuty','url'=>array('admin')),
);
?>

<h1>Create AlternateDuty</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>