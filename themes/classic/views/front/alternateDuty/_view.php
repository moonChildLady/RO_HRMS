<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dutyDate')); ?>:</b>
	<?php echo CHtml::encode($data->dutyDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stauts')); ?>:</b>
	<?php echo CHtml::encode($data->stauts); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('groupID')); ?>:</b>
	<?php echo CHtml::encode($data->groupID); ?>
	<br />


</div>