<?php
$this->breadcrumbs=array(
	'Staff Employments'=>array('index'),
	'Create',
);

/*
$this->menu=array(
array('label'=>'List StaffEmployment','url'=>array('index')),
array('label'=>'Manage StaffEmployment','url'=>array('admin')),

);*/
?>

<h3>Create Staff</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'StaffModel'=>$StaffModel,'groupModel'=>$groupModel, 'timeSlotModel'=>$timeSlotModel, 'CWRModel'=>$CWRModel, 'DepartmentModel'=>$DepartmentModel)); ?>