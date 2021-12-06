<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staffCode')); ?>:</b>
	<?php echo CHtml::encode($data->staffCode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('departmentID')); ?>:</b>
	<?php echo CHtml::encode($data->departmentID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('divisionID')); ?>:</b>
	<?php echo CHtml::encode($data->divisionID); ?>
	<br />


</div>