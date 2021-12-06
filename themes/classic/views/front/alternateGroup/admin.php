<?php

$criteria = new CDbCriteria;
$criteria->addCondition("type = :type");
$criteria->params = array(
	':type'=>'LEAVEGROUP',
);
		
$reasonIDs = ContentTable::model()->findAll($criteria);

$this->breadcrumbs=array(
	'Alternate Groups'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List AlternateGroup','url'=>array('index')),
array('label'=>'Create AlternateGroup','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('alternate-group-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Alternate Groups</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'alternate-group-grid',
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
		array(
			'name'=>'groupID',
			'value'=>'$data->GroupName0->content',
			'header'=> CHtml::encode($model->getAttributeLabel('groupID')),
			'filter' => CHtml::dropDownList( 'AlternateGroup[groupID]', $model->groupID,
					CHtml::listData( $reasonIDs, 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
		),
		//'groupID',
		//'status',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
