<?php
$this->breadcrumbs=array(
	'Leave Balances'=>array('index'),
	'Manage',
);

/* $this->menu=array(
array('label'=>'List LeaveBalance','url'=>array('index')),
array('label'=>'Create LeaveBalance','url'=>array('create')),
); */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('leave-balance-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3>Manage Entitlement</h3>

<div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('LeaveBalance/create');?>">Entitlement</a></li>
   
   
  </ul>
  
  
</div>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'leave-balance-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'id',
		'staffCode',
		array(
			'name'=>'Fullname',
			'value'=>'($data->staffCode0)?$data->staffCode0->Fullname:""',
			'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		'balanceDate',
		'balance',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
