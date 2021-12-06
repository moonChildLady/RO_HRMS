<?php
/* @var $this EventPeriodController */
/* @var $model EventPeriod */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-period-form',
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
		<?php echo $form->labelEx($model,'evenetName'); ?>
		<?php echo $form->textField($model,'evenetName',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'evenetName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'startDay'); ?>
		<?php echo $form->textField($model,'startDay'); ?>
		<?php echo $form->error($model,'startDay'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endDay'); ?>
		<?php echo $form->textField($model,'endDay'); ?>
		<?php echo $form->error($model,'endDay'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->