<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_id')); ?>:</b>
	<?php echo CHtml::encode($data->sub_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_name')); ?>:</b>
	<?php echo CHtml::encode($data->sub_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quota')); ?>:</b>
	<?php echo CHtml::encode($data->quota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acayear')); ?>:</b>
	<?php echo CHtml::encode($data->acayear); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subevtid')); ?>:</b>
	<?php echo CHtml::encode($data->subevtid); ?>
	<br />


</div>