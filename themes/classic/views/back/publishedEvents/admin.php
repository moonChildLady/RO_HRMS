<?php
$this->breadcrumbs=array(
	'Published Events'=>array('index'),
	'Manage',
);

/*$this->menu=array(
array('label'=>'List PublishedEvents','url'=>array('index')),
array('label'=>'Create PublishedEvents','url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('published-events-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3>Manage Published Events</h3>
<div class="btn-group">
	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
	<span class="caret"></span>
	<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a href="<?php echo Yii::app()->createUrl('PublishedEvents/create');?>">Create</a></li>
	</ul>
</div>
<!--p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<!--div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div--><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'published-events-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'event_id',
		'academicYear',
		'eventName',
		//'dbName',
		'startDate',
		'endDate',
		'extStart',
		'extEnd',
		'publishDate',
		'lastUpdate',
		'shown',
		'status',
		/*
		'controller',
		'slipName',
		'endDate',
		'extStart',
		'extEnd',
		'url',
		'InputBy',
		'ModifyBy',
		'academicYear',
		'publishDate',
		'lastUpdate',
		'shown',
		'status',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
'template'=>'{view}{update}',
),
),
)); ?>
