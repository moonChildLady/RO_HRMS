<?php
$this->breadcrumbs=array(
	'Staff Employments'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List StaffEmployment','url'=>array('index')),
array('label'=>'Create StaffEmployment','url'=>array('create')),
array('label'=>'Update StaffEmployment','url'=>array('update','id'=>$model->staffCode)),
array('label'=>'Delete StaffEmployment','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage StaffEmployment','url'=>array('admin')),
);
?>

<h1>Staff #<?php echo $model->staffCode; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'staffCode',
		'startDate',
		'endDate',
		'Basis',
		'positionID',
),
)); ?>
