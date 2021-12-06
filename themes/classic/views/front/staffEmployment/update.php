<?php
$this->breadcrumbs=array(
	'Staff Employments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/* 	$this->menu=array(
	array('label'=>'List StaffEmployment','url'=>array('index')),
	array('label'=>'Create StaffEmployment','url'=>array('create')),
	array('label'=>'View StaffEmployment','url'=>array('view','id'=>$model->staffCode)),
	array('label'=>'Manage StaffEmployment','url'=>array('admin')),
	); */
	?>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<p class="bg-' . $key . '">' . $message . "</p>\n";
    }
?>
	<h3>Update Staff Record #<?php echo $model->staffCode; ?></h3>


<?php echo $this->renderPartial('_form',array('model'=>$model,'StaffModel'=>$StaffModel,'groupModel'=>$groupModel, 'timeSlotModel'=>$timeSlotModel, 'CWRModel'=>$CWRModel, 'DepartmentModel'=>$DepartmentModel)); ?>