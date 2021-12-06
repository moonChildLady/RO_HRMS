<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startDate')); ?>:</b>
	<?php echo CHtml::encode($data->startDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('endDate')); ?>:</b>
	<?php echo CHtml::encode($data->endDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('applyStartDate')); ?>:</b>
	<?php echo CHtml::encode($data->applyStartDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('applyEndDate')); ?>:</b>
	<?php echo CHtml::encode($data->applyEndDate); ?>
	<br />


</div>