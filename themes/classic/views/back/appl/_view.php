<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('evtid')); ?>:</b>
	<?php echo CHtml::encode($data->evtid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pre')); ?>:</b>
	<?php echo CHtml::encode($data->pre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acayear')); ?>:</b>
	<?php echo CHtml::encode($data->acayear); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stid')); ?>:</b>
	<?php echo CHtml::encode($data->stid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remks')); ?>:</b>
	<?php echo CHtml::encode($data->remks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parentName')); ?>:</b>
	<?php echo CHtml::encode($data->parentName); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('phoneNo')); ?>:</b>
	<?php echo CHtml::encode($data->phoneNo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event')); ?>:</b>
	<?php echo CHtml::encode($data->event); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('appdate')); ?>:</b>
	<?php echo CHtml::encode($data->appdate); ?>
	<br />

	*/ ?>

</div>