<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('year')); ?>:</b>
	<?php echo CHtml::encode($data->year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code2')); ?>:</b>
	<?php echo CHtml::encode($data->code2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('projectTitle')); ?>:</b>
	<?php echo CHtml::encode($data->projectTitle); ?>
	<br />


</div>