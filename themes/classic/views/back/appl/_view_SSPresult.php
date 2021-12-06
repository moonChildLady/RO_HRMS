<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('results_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->results_id),array('view','id'=>$data->results_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stid')); ?>:</b>
	<?php echo CHtml::encode($data->stid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acayear')); ?>:</b>
	<?php echo CHtml::encode($data->acayear); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('x3')); ?>:</b>
	<?php echo CHtml::encode($data->x3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('x3pre')); ?>:</b>
	<?php echo CHtml::encode($data->x3pre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('x2')); ?>:</b>
	<?php echo CHtml::encode($data->x2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('x2pre')); ?>:</b>
	<?php echo CHtml::encode($data->x2pre); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('class')); ?>:</b>
	<?php echo CHtml::encode($data->class); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('classpre')); ?>:</b>
	<?php echo CHtml::encode($data->classpre); ?>
	<br />

	*/ ?>

</div>