<?php
$this->breadcrumbs=array(
	'Leave Application Applies'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List LeaveApplicationApply','url'=>array('index')),
array('label'=>'Manage LeaveApplicationApply','url'=>array('admin')),
);
?>

<h3>Create Application Period</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>