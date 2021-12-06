<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('holidayName')); ?>:</b>
	<?php echo CHtml::encode($data->holidayName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eventDate')); ?>:</b>
	<?php echo CHtml::encode($data->eventDate); ?>
	<br />


</div>