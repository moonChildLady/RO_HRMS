<?php
$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	'Create',
);

/* $this->menu=array(
array('label'=>'List LeaveApplication','url'=>array('index')),
array('label'=>'Manage LeaveApplication','url'=>array('admin')),
); */
?>
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">New Leave Application</h3>
  </div>
  <div class="panel-body">

  

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
</div>
