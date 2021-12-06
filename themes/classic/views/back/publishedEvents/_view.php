<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('event_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->event_id),array('view','id'=>$data->event_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eventName')); ?>:</b>
	<?php echo CHtml::encode($data->eventName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dbName')); ?>:</b>
	<?php echo CHtml::encode($data->dbName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('controller')); ?>:</b>
	<?php echo CHtml::encode($data->controller); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slipName')); ?>:</b>
	<?php echo CHtml::encode($data->slipName); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('startDate')); ?>:</b>
	<?php echo CHtml::encode($data->startDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('endDate')); ?>:</b>
	<?php echo CHtml::encode($data->endDate); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('extStart')); ?>:</b>
	<?php echo CHtml::encode($data->extStart); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extEnd')); ?>:</b>
	<?php echo CHtml::encode($data->extEnd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('InputBy')); ?>:</b>
	<?php echo CHtml::encode($data->InputBy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ModifyBy')); ?>:</b>
	<?php echo CHtml::encode($data->ModifyBy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('academicYear')); ?>:</b>
	<?php echo CHtml::encode($data->academicYear); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('publishDate')); ?>:</b>
	<?php echo CHtml::encode($data->publishDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastUpdate')); ?>:</b>
	<?php echo CHtml::encode($data->lastUpdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shown')); ?>:</b>
	<?php echo CHtml::encode($data->shown); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>