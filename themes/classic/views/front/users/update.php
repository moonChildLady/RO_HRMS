<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	/* $this->menu=array(
	array('label'=>'List Users','url'=>array('index')),
	array('label'=>'Create Users','url'=>array('create')),
	array('label'=>'View Users','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Users','url'=>array('admin')),
	); */
	?>

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Update User <?php echo $model->staffCode0->FullnamewithStaffCode;?></h3>
  </div>
  <div class="panel-body">

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>

</div>
</div>