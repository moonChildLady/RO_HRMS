<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staffCode')); ?>:</b>
	<?php echo CHtml::encode($data->staffCode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('groupID')); ?>:</b>
	<?php echo CHtml::encode($data->groupID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>