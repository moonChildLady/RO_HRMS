<?php
/* @var $this LwwSelectionController */
/* @var $model LwwSelection */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lww-selection-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'regNo'); ?>
		<?php echo $form->textField($model,'regNo',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'regNo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch01'); ?>
		<?php echo $form->textField($model,'ch01'); ?>
		<?php echo $form->error($model,'ch01'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch02'); ?>
		<?php echo $form->textField($model,'ch02'); ?>
		<?php echo $form->error($model,'ch02'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch03'); ?>
		<?php echo $form->textField($model,'ch03'); ?>
		<?php echo $form->error($model,'ch03'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch04'); ?>
		<?php echo $form->textField($model,'ch04'); ?>
		<?php echo $form->error($model,'ch04'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch05'); ?>
		<?php echo $form->textField($model,'ch05'); ?>
		<?php echo $form->error($model,'ch05'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch06'); ?>
		<?php echo $form->textField($model,'ch06'); ?>
		<?php echo $form->error($model,'ch06'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch07'); ?>
		<?php echo $form->textField($model,'ch07'); ?>
		<?php echo $form->error($model,'ch07'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch08'); ?>
		<?php echo $form->textField($model,'ch08'); ?>
		<?php echo $form->error($model,'ch08'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch09'); ?>
		<?php echo $form->textField($model,'ch09'); ?>
		<?php echo $form->error($model,'ch09'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch10'); ?>
		<?php echo $form->textField($model,'ch10'); ?>
		<?php echo $form->error($model,'ch10'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch11'); ?>
		<?php echo $form->textField($model,'ch11'); ?>
		<?php echo $form->error($model,'ch11'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch12'); ?>
		<?php echo $form->textField($model,'ch12'); ?>
		<?php echo $form->error($model,'ch12'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch13'); ?>
		<?php echo $form->textField($model,'ch13'); ?>
		<?php echo $form->error($model,'ch13'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch14'); ?>
		<?php echo $form->textField($model,'ch14'); ?>
		<?php echo $form->error($model,'ch14'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch15'); ?>
		<?php echo $form->textField($model,'ch15'); ?>
		<?php echo $form->error($model,'ch15'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch16'); ?>
		<?php echo $form->textField($model,'ch16'); ?>
		<?php echo $form->error($model,'ch16'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch17'); ?>
		<?php echo $form->textField($model,'ch17'); ?>
		<?php echo $form->error($model,'ch17'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch18'); ?>
		<?php echo $form->textField($model,'ch18'); ?>
		<?php echo $form->error($model,'ch18'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch19'); ?>
		<?php echo $form->textField($model,'ch19'); ?>
		<?php echo $form->error($model,'ch19'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ch20'); ?>
		<?php echo $form->textField($model,'ch20'); ?>
		<?php echo $form->error($model,'ch20'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IPAddress'); ?>
		<?php echo $form->textField($model,'IPAddress',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'IPAddress'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parentName'); ?>
		<?php echo $form->textField($model,'parentName',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'parentName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SMS'); ?>
		<?php echo $form->textField($model,'SMS',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'SMS'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Financial'); ?>
		<?php echo $form->textField($model,'Financial',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Financial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Declaration'); ?>
		<?php echo $form->textField($model,'Declaration',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'Declaration'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Born'); ?>
		<?php echo $form->textField($model,'Born',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Born'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'TravelDoc'); ?>
		<?php echo $form->textField($model,'TravelDoc',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'TravelDoc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastLogin'); ?>
		<?php echo $form->textField($model,'lastLogin'); ?>
		<?php echo $form->error($model,'lastLogin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'createDate'); ?>
		<?php echo $form->textField($model,'createDate'); ?>
		<?php echo $form->error($model,'createDate'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'saveMode'); ?>
		<?php echo $form->textField($model,'saveMode'); ?>
		<?php echo $form->error($model,'saveMode'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->