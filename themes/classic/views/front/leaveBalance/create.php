<?php
$this->breadcrumbs=array(
	'Leave Balances'=>array('index'),
	'Create',
);

/* $this->menu=array(
array('label'=>'List LeaveBalance','url'=>array('index')),
array('label'=>'Manage LeaveBalance','url'=>array('admin')),
); */
?>

<h3>New Leave Balance</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>