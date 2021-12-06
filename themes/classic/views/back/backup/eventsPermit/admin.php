<?php
$this->breadcrumbs=array(
	'Events Permits'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List EventsPermit','url'=>array('index')),
array('label'=>'Create EventsPermit','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('events-permit-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Events Permits</h1>

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
'id'=>'events-permit-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'event_id',
		'S1',
		'S2',
		'S3',
		'S4',
		/*
		'S5',
		'S6',
		'S7',
		'TEST',
		'status',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
