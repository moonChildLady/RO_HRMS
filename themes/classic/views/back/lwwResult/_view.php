<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('result_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->result_id),array('view','id'=>$data->result_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('regNo')); ?>:</b>
	<?php echo CHtml::encode($data->regNo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('choice')); ?>:</b>
	<?php echo CHtml::encode($data->choice); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pid')); ?>:</b>
	<?php echo CHtml::encode($data->pid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remark')); ?>:</b>
	<?php echo CHtml::encode($data->remark); ?>
	<br />


</div>