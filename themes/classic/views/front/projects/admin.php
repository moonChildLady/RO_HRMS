<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	'Manage',
);

/* $this->menu=array(
array('label'=>'List Projects','url'=>array('index')),
array('label'=>'Create Projects','url'=>array('create')),
); */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('projects-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3>Projects</h3>

<div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('projects/create');?>">Project</a></li>
    
   
  </ul>
</div>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'projects-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'id',
		'year',
		'code',
		'code2',
		'projectTitle',
		'startDate',
		'endDate',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
