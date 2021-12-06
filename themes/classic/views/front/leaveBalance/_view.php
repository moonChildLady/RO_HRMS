<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('staffCode')); ?>:</b>
	<?php echo CHtml::encode($data->staffCode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('balanceDate')); ?>:</b>
	<?php echo CHtml::encode($data->balanceDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('balance')); ?>:</b>
	<?php echo CHtml::encode($data->balance); ?>
	<br />


</div>