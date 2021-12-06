<?php
/* @var $this ProgrameInfoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Programe Infos',
);

$this->menu=array(
	array('label'=>'Create ProgrameInfo', 'url'=>array('create')),
	array('label'=>'Manage ProgrameInfo', 'url'=>array('admin')),
);
?>

<h1>Programe Infos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
