<?php
$this->breadcrumbs=array(
	'Leave Application Applies'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List LeaveApplicationApply','url'=>array('index')),
array('label'=>'Create LeaveApplicationApply','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('leave-application-apply-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3>Manage Leave Application Period</h3>

<div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('LeaveApplicationApply/create');?>">Application Period</a></li>
    
   
   
  </ul>
  
  
</div>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'leave-application-apply-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'id',
		'startDate',
		'endDate',
		'applyStartDate',
		'applyEndDate',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
