<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('evtid')); ?>:</b>
	<?php echo CHtml::encode($data->evtid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subevtid')); ?>:</b>
	<?php echo CHtml::encode($data->subevtid); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('ts')); ?>:</b>
	<?php echo CHtml::encode($data->ts); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('choice')); ?>:</b>
	<?php echo CHtml::encode($data->choice); ?>
	<br />

	*/ ?>

</div>