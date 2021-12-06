<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'regNo'); ?>
		<?php echo $form->textField($model,'regNo',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'regNo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'enName'); ?>
		<?php echo $form->textField($model,'enName',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'enName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'chName'); ?>
		<?php echo $form->textField($model,'chName',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'chName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'classLvl'); ?>
		<?php echo $form->textField($model,'classLvl',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'classLvl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'classCode'); ?>
		<?php echo $form->textField($model,'classCode',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'classCode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'classNumber'); ?>
		<?php echo $form->textField($model,'classNumber',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'classNumber'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->textField($model,'gender',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'resigned'); ?>
		<?php echo $form->textField($model,'resigned',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'resigned'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'schYear'); ?>
		<?php echo $form->textField($model,'schYear',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'schYear'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userGroup'); ?>
		<?php echo $form->textField($model,'userGroup',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'userGroup'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dob'); ?>
		<?php echo $form->textField($model,'dob',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'dob'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hkid'); ?>
		<?php echo $form->textField($model,'hkid',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'hkid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reentry'); ?>
		<?php echo $form->textField($model,'reentry',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'reentry'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reentry_expiry'); ?>
		<?php echo $form->textField($model,'reentry_expiry',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'reentry_expiry'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->textField($model,'state',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passport'); ?>
		<?php echo $form->textField($model,'passport',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'passport'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passport_expiry'); ?>
		<?php echo $form->textField($model,'passport_expiry',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'passport_expiry'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'conduct'); ?>
		<?php echo $form->textField($model,'conduct',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'conduct'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->