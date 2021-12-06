<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	'Manage',
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('users-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3>Manage Users</h3>




<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'users-grid',
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
		//'password',
		'resigned',
array(
'class'=>'booster.widgets.TbButtonColumn',
'template'=>'{update}{changeuser}',
'buttons'=>array
    (
		'changeuser'=>array(
			'label'=>'Change Role',
            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
            'url'=>'Yii::app()->createUrl("users/ChangeRole", array("staffCode"=>$data->staffCode))',
		),
	),
),
),
)); ?>
