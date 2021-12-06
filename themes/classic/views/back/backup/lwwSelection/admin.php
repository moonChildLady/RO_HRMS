<?php
/* @var $this LwwSelectionController */
/* @var $model LwwSelection */

$this->breadcrumbs=array(
	'Lww Selections'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LwwSelection', 'url'=>array('index')),
	array('label'=>'Create LwwSelection', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lww-selection-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Lww Selections</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'lww-selection-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'regNo',
		'ch01',
		'ch02',
		'ch03',
		'ch04',
		/*
		'ch05',
		'ch06',
		'ch07',
		'ch08',
		'ch09',
		'ch10',
		'ch11',
		'ch12',
		'ch13',
		'ch14',
		'ch15',
		'ch16',
		'ch17',
		'ch18',
		'ch19',
		'ch20',
		'email',
		'IPAddress',
		'parentName',
		'SMS',
		'Financial',
		'Declaration',
		'Born',
		'TravelDoc',
		'lastLogin',
		'createDate',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
