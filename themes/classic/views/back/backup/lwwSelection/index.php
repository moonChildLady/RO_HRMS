<?php
/* @var $this LwwSelectionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Lww Selections',
);

$this->menu=array(
	array('label'=>'Create LwwSelection', 'url'=>array('create')),
	array('label'=>'Manage LwwSelection', 'url'=>array('admin')),
);
?>

<h1>Lww Selections</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
