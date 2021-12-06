<?php
/* @var $this LwwSelectionController */
/* @var $model LwwSelection */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'regNo'); ?>
		<?php echo $form->textField($model,'regNo',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch01'); ?>
		<?php echo $form->textField($model,'ch01'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch02'); ?>
		<?php echo $form->textField($model,'ch02'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch03'); ?>
		<?php echo $form->textField($model,'ch03'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch04'); ?>
		<?php echo $form->textField($model,'ch04'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch05'); ?>
		<?php echo $form->textField($model,'ch05'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch06'); ?>
		<?php echo $form->textField($model,'ch06'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch07'); ?>
		<?php echo $form->textField($model,'ch07'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch08'); ?>
		<?php echo $form->textField($model,'ch08'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch09'); ?>
		<?php echo $form->textField($model,'ch09'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch10'); ?>
		<?php echo $form->textField($model,'ch10'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch11'); ?>
		<?php echo $form->textField($model,'ch11'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch12'); ?>
		<?php echo $form->textField($model,'ch12'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch13'); ?>
		<?php echo $form->textField($model,'ch13'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch14'); ?>
		<?php echo $form->textField($model,'ch14'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch15'); ?>
		<?php echo $form->textField($model,'ch15'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch16'); ?>
		<?php echo $form->textField($model,'ch16'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch17'); ?>
		<?php echo $form->textField($model,'ch17'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch18'); ?>
		<?php echo $form->textField($model,'ch18'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch19'); ?>
		<?php echo $form->textField($model,'ch19'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ch20'); ?>
		<?php echo $form->textField($model,'ch20'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IPAddress'); ?>
		<?php echo $form->textField($model,'IPAddress',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'parentName'); ?>
		<?php echo $form->textField($model,'parentName',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SMS'); ?>
		<?php echo $form->textField($model,'SMS',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Financial'); ?>
		<?php echo $form->textField($model,'Financial',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Declaration'); ?>
		<?php echo $form->textField($model,'Declaration',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Born'); ?>
		<?php echo $form->textField($model,'Born',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'TravelDoc'); ?>
		<?php echo $form->textField($model,'TravelDoc',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lastLogin'); ?>
		<?php echo $form->textField($model,'lastLogin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'createDate'); ?>
		<?php echo $form->textField($model,'createDate'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->