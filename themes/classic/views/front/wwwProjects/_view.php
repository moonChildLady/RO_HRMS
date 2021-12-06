<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('projectName')); ?>:</b>
	<?php echo CHtml::encode($data->projectName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nature')); ?>:</b>
	<?php echo CHtml::encode($data->nature); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contractSum')); ?>:</b>
	<?php echo CHtml::encode($data->contractSum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clientName')); ?>:</b>
	<?php echo CHtml::encode($data->clientName); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('architect')); ?>:</b>
	<?php echo CHtml::encode($data->architect); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mainContrator')); ?>:</b>
	<?php echo CHtml::encode($data->mainContrator); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createDate')); ?>:</b>
	<?php echo CHtml::encode($data->createDate); ?>
	<br />

	*/ ?>

</div>