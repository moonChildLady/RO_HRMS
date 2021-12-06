<?php
/* @var $this UsersController */
/* @var $data Users */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('regNo')); ?>:</b>
	<?php echo CHtml::encode($data->regNo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enName')); ?>:</b>
	<?php echo CHtml::encode($data->enName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chName')); ?>:</b>
	<?php echo CHtml::encode($data->chName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('classLvl')); ?>:</b>
	<?php echo CHtml::encode($data->classLvl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('classCode')); ?>:</b>
	<?php echo CHtml::encode($data->classCode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('classNumber')); ?>:</b>
	<?php echo CHtml::encode($data->classNumber); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('resigned')); ?>:</b>
	<?php echo CHtml::encode($data->resigned); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('schYear')); ?>:</b>
	<?php echo CHtml::encode($data->schYear); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userGroup')); ?>:</b>
	<?php echo CHtml::encode($data->userGroup); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dob')); ?>:</b>
	<?php echo CHtml::encode($data->dob); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hkid')); ?>:</b>
	<?php echo CHtml::encode($data->hkid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reentry')); ?>:</b>
	<?php echo CHtml::encode($data->reentry); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reentry_expiry')); ?>:</b>
	<?php echo CHtml::encode($data->reentry_expiry); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passport')); ?>:</b>
	<?php echo CHtml::encode($data->passport); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passport_expiry')); ?>:</b>
	<?php echo CHtml::encode($data->passport_expiry); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('conduct')); ?>:</b>
	<?php echo CHtml::encode($data->conduct); ?>
	<br />

	*/ ?>

</div>