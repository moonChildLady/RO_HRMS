<?php
$this->breadcrumbs=array(
	'Report Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
//array('label'=>'List ReportLog','url'=>array('index')),
array('label'=>'Create ReportLog','url'=>array('reportLogCreate')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('report-log-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3>Manage Cover Page of SSP</h3>

<!--p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<!--div class="search-form" style="display:none">
	<?php $this->renderPartial('reportLog_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'report-log-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'id',
		'version',
		'date',
		'author',
		'description',
		'remark',
array(
'class'=>'booster.widgets.TbButtonColumn',
'template'=>'{update}', //Only shows Delete button
'updateButtonUrl'=>'Yii::app()->urlManager->createUrl("appl/reportLogUpdate", array("id"=>$data->id))',
),
),
)); ?>
