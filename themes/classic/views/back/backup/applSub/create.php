<?php
$this->breadcrumbs=array(
	'Appl Subs'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List ApplSub','url'=>array('index')),
array('label'=>'Manage ApplSub','url'=>array('admin')),
);
?>

<h1>Create ApplSub</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>