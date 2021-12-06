<?php
/* @var $this ProgrameInfoController */
/* @var $data ProgrameInfo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->pid), array('view', 'id'=>$data->pid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quotaMin')); ?>:</b>
	<?php echo CHtml::encode($data->quotaMin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quotaTarget')); ?>:</b>
	<?php echo CHtml::encode($data->quotaTarget); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quotaMax')); ?>:</b>
	<?php echo CHtml::encode($data->quotaMax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('permLvl')); ?>:</b>
	<?php echo CHtml::encode($data->permLvl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('permLvl2')); ?>:</b>
	<?php echo CHtml::encode($data->permLvl2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chName')); ?>:</b>
	<?php echo CHtml::encode($data->chName); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('enName')); ?>:</b>
	<?php echo CHtml::encode($data->enName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('programeId')); ?>:</b>
	<?php echo CHtml::encode($data->programeId); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
	<?php echo CHtml::encode($data->cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($data->location); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s1Quota')); ?>:</b>
	<?php echo CHtml::encode($data->s1Quota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s2Quota')); ?>:</b>
	<?php echo CHtml::encode($data->s2Quota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s3Quota')); ?>:</b>
	<?php echo CHtml::encode($data->s3Quota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s4Quota')); ?>:</b>
	<?php echo CHtml::encode($data->s4Quota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('s5Quota')); ?>:</b>
	<?php echo CHtml::encode($data->s5Quota); ?>
	<br />

	*/ ?>

</div>