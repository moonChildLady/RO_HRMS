<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staffCode')); ?>:</b>
	<?php echo CHtml::encode($data->staffCode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startDate')); ?>:</b>
	<?php echo CHtml::encode($data->startDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('endDate')); ?>:</b>
	<?php echo CHtml::encode($data->endDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('duration')); ?>:</b>
	<?php echo CHtml::encode($data->duration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reasonID')); ?>:</b>
	<?php echo CHtml::encode($data->reasonID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reasonRemarks')); ?>:</b>
	<?php echo CHtml::encode($data->reasonRemarks); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('commentID')); ?>:</b>
	<?php echo CHtml::encode($data->commentID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('commentRemarks')); ?>:</b>
	<?php echo CHtml::encode($data->commentRemarks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attachmentID')); ?>:</b>
	<?php echo CHtml::encode($data->attachmentID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createDate')); ?>:</b>
	<?php echo CHtml::encode($data->createDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createdBy')); ?>:</b>
	<?php echo CHtml::encode($data->createdBy); ?>
	<br />

	*/ ?>

</div>