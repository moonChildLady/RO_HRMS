<?php
/* @var $this ProgrameInfoController */
/* @var $model ProgrameInfo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'programe-info-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pid'); ?>
		<?php echo $form->textField($model,'pid'); ?>
		<?php echo $form->error($model,'pid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quotaMin'); ?>
		<?php echo $form->textField($model,'quotaMin',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'quotaMin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quotaTarget'); ?>
		<?php echo $form->textField($model,'quotaTarget',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'quotaTarget'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quotaMax'); ?>
		<?php echo $form->textField($model,'quotaMax',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'quotaMax'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'permLvl'); ?>
		<?php echo $form->textField($model,'permLvl',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'permLvl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'permLvl2'); ?>
		<?php echo $form->textField($model,'permLvl2',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'permLvl2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'chName'); ?>
		<?php echo $form->textField($model,'chName',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'chName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'enName'); ?>
		<?php echo $form->textField($model,'enName',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'enName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'programeId'); ?>
		<?php echo $form->textField($model,'programeId',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'programeId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cost'); ?>
		<?php echo $form->textField($model,'cost',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s1Quota'); ?>
		<?php echo $form->textField($model,'s1Quota',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'s1Quota'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s2Quota'); ?>
		<?php echo $form->textField($model,'s2Quota',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'s2Quota'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s3Quota'); ?>
		<?php echo $form->textField($model,'s3Quota',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'s3Quota'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s4Quota'); ?>
		<?php echo $form->textField($model,'s4Quota',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'s4Quota'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'s5Quota'); ?>
		<?php echo $form->textField($model,'s5Quota',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'s5Quota'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->