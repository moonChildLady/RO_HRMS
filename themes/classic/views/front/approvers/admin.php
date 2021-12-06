<?php
$this->breadcrumbs=array(
	'Approvers'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Approvers','url'=>array('index')),
array('label'=>'Create Approvers','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('approvers-grid', {
data: $(this).serialize()
});
return false;
});
");


$criteria1=new CDbCriteria;
$criteria1->addCondition("type = 'ELEAVE'");
$criteria1->order = "content ASC";
?>

<h3>Manage Approvers</h3>

<div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('Approvers/create');?>">Approvers</a></li>
   
   
  </ul>
  
  
</div>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'approvers-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'id',
		'staffCode',
		array(
			'name'=>'Fullname',
			'value'=>'$data->staffCode0->Fullname',
			'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		//'approver',
		array(
			'name'=>'approverFullname',
			'value'=>'$data->approver0->Fullname',
			//'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		array(
			'name'=>'position',
			'value'=>'$data->position0->content',
			//'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			'filter' => CHtml::dropDownList( 'Approvers[position]', $model->position,
					CHtml::listData( ContentTable::model()->findAll( $criteria1 ), 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
		),
		'startDate',
		'endDate',
		//'position',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
