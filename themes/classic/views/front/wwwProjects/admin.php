<?php
$this->breadcrumbs=array(
	'Www Projects'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List wwwProjects','url'=>array('index')),
array('label'=>'Create wwwProjects','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('www-projects-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h3>Manage Projects</h3>

<div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('WwwProjects/create');?>">Create Project</a></li>
    
   
  </ul>
</div>

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'www-projects-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'title',
		'projectName',
		'location',
		'nature',
		'contractSum',
		/*
		'clientName',
		'architect',
		'mainContrator',
		'status',
		'createDate',
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
