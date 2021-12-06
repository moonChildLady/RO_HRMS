<?php
$this->breadcrumbs=array(
	'Appls'=>array('index'),
	'Manage',
);
/*
$this->menu=array(
array('label'=>'List Appl','url'=>array('index')),
array('label'=>'Create Appl','url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('appl-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3>Manage SSP</h3>
<div class="btn-group">
	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Export
	<span class="caret"></span>
	<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/print/all');?>">Print Slip  [All]</a></li>
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/print/submit');?>">Print Slip [Submitted]</a></li>
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/print/nonsubmit');?>">Print Slip [Non-submitted]</a></li>
		<li class="divider"></li>
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/CreateExcel/choices');?>">Data Collection [Student Preference]</a></li>
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/CreateExcel/rawdata');?>">Data Collection [Student Slip]</a></li>
		
		<li class="divider"></li>
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/CreateExcel/CombindExcel');?>">Result [All]</a></li>
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/CreateExcel/qoutacheck');?>">Result [Quota Checking]</a></li>
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/CreateExcel/studentPre');?>">Result [Quota Preference]</a></li>

		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/CreateExcel/electivelist');?>">Result [Elective List]</a></li>
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/CreateExcel/classlist');?>">Result [Class List]</a></li>
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/CreateExcel/nonenrolled');?>">Result [Non-allocated List]</a></li>
		<li><a href="<?php echo Yii::app()->createUrl('backend/appl/CreateExcel/nonsubmit');?>">Result [Non-submitted]</a></li>
		
		
	</ul>
</div>

<!--p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'appl-grid',
'dataProvider'=>$model->search($criteria),
'filter'=>$model,
'columns'=>array(
		
		
		
		
		'regNo',
		'enName',
		'chName',
		'classLvl',
		'classCode',
		'classNumber',
		/*
		'b.parentName',
		'b.phoneNo',
		'remks',
		'acayear',
		'pre',
		'id',
		'evtid',
		
		
		'event',
		'appdate',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
'template'=>'{view}', //Only shows Delete button
'viewButtonUrl'=>'Yii::app()->urlManager->createUrl("appl/print", array("id"=>$data->regNo))',
),
),
)); ?>
