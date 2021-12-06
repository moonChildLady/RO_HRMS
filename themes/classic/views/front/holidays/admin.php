<?php
$this->breadcrumbs=array(
	'Holidays'=>array('index'),
	'Manage',
);

/* $this->menu=array(
array('label'=>'List Holidays','url'=>array('index')),
array('label'=>'Create Holidays','url'=>array('create')),
); */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('holidays-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3>Manage Holidays</h3>
<div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('Holidays/create');?>">Holidays</a></li>
   
   
  </ul>
  
  
</div>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'holidays-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'id',
		'holidayName',
		'eventDate',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
