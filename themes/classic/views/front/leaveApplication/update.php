<?php
$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	/* $this->menu=array(
	array('label'=>'List LeaveApplication','url'=>array('index')),
	array('label'=>'Create LeaveApplication','url'=>array('create')),
	array('label'=>'View LeaveApplication','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage LeaveApplication','url'=>array('admin')),
	); */
	?>

	<h3>Update Leave Application [<?php echo $model->staffCode0->FullnamewithStaffCode; ?>] [Ref. No.: <?php echo $model->refNo;?>]</h3>
<?php 
$type = Yii::app()->request->getParam('type', null);
if(Yii::app()->user->checkAccess('eLeave Admin')){ 
	echo $this->renderPartial('_form',array('model'=>$model,'type'=>$type,
	'modelUser'=>$modelUser,));
}else{
	echo $this->renderPartial('_formstaff',array('model'=>$model,'type'=>$type,
	'modelUser'=>$modelUser,));
}

 ?>
