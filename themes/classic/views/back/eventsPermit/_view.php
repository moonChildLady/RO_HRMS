<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_id')); ?>:</b>
	<?php echo CHtml::encode($data->event_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('S1')); ?>:</b>
	<?php echo CHtml::encode($data->S1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('S2')); ?>:</b>
	<?php echo CHtml::encode($data->S2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('S3')); ?>:</b>
	<?php echo CHtml::encode($data->S3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('S4')); ?>:</b>
	<?php echo CHtml::encode($data->S4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('S5')); ?>:</b>
	<?php echo CHtml::encode($data->S5); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('S6')); ?>:</b>
	<?php echo CHtml::encode($data->S6); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('S7')); ?>:</b>
	<?php echo CHtml::encode($data->S7); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('TEST')); ?>:</b>
	<?php echo CHtml::encode($data->TEST); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>