<?php
$this->breadcrumbs=array(
	'Sspresults'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List SSPResults','url'=>array('index')),
array('label'=>'Create SSPResults','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('sspresults-grid', {
data: $(this).serialize()
});
return false;
});
");

?>

<h1>Manage Sspresults</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search_SSPresult',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'sspresults-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'results_id',
		'stid',
		//'acayear',
		'x3',
		'x3pre',
		'x2',
		array(            // display 'create_time' using an expression
          'name'=>'x2',
          'value'=>'$data->Sub->sub_name',
        ),
		'x2pre',
		'class',
		'classpre',
		
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
