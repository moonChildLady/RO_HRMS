<?php
$this->breadcrumbs=array(
	'Admin Users'=>array('index'),
	'Manage',
);

/* $this->menu=array(
array('label'=>'List AdminUsers','url'=>array('index')),
array('label'=>'Create AdminUsers','url'=>array('create')),
); */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('admin-users-grid', {
data: $(this).serialize()
});
return false;
});
");

?>

<h3>Manage Admin Users</h3>
<div class="btn-group">
	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
	<span class="caret"></span>
	<span class="sr-only">Toggle Dropdown</span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<li><a href="<?php echo Yii::app()->createUrl('adminUsers/create');?>">Create</a></li>
	</ul>
</div>
<!--p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p-->

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php /* $this->renderPartial('_search',array(
	'model'=>$model,
)); */ ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'admin-users-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'admin_id',
		//'user_id',
		//array('name'=>'user_id', 'value'=>(!empty($model->useradmin->enName))?$model->useradmin->enName:$model->user_id),
		array('name'=>'useradmin', 'value'=>'$data->useradmin->enName'),
		array('name'=>'events', 'value'=>'$data->events->eventName'),
		//'event_id',
		'status',
array(
'class'=>'booster.widgets.TbButtonColumn',
'template'=>'{view}{update}', //Only shows Delete button
),
),
)); ?>
