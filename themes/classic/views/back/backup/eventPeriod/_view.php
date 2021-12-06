<?php
/* @var $this EventPeriodController */
/* @var $data EventPeriod */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('evenetName')); ?>:</b>
	<?php echo CHtml::encode($data->evenetName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startDay')); ?>:</b>
	<?php echo CHtml::encode($data->startDay); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('endDay')); ?>:</b>
	<?php echo CHtml::encode($data->endDay); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>