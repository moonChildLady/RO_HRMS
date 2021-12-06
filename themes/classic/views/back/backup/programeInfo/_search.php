<?php
/* @var $this ProgrameInfoController */
/* @var $model ProgrameInfo */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'pid'); ?>
		<?php echo $form->textField($model,'pid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quotaMin'); ?>
		<?php echo $form->textField($model,'quotaMin',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quotaTarget'); ?>
		<?php echo $form->textField($model,'quotaTarget',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quotaMax'); ?>
		<?php echo $form->textField($model,'quotaMax',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'permLvl'); ?>
		<?php echo $form->textField($model,'permLvl',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'permLvl2'); ?>
		<?php echo $form->textField($model,'permLvl2',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'chName'); ?>
		<?php echo $form->textField($model,'chName',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'enName'); ?>
		<?php echo $form->textField($model,'enName',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'programeId'); ?>
		<?php echo $form->textField($model,'programeId',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cost'); ?>
		<?php echo $form->textField($model,'cost',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'location'); ?>
		<?php echo $form->textField($model,'location',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s1Quota'); ?>
		<?php echo $form->textField($model,'s1Quota',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s2Quota'); ?>
		<?php echo $form->textField($model,'s2Quota',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s3Quota'); ?>
		<?php echo $form->textField($model,'s3Quota',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s4Quota'); ?>
		<?php echo $form->textField($model,'s4Quota',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'s5Quota'); ?>
		<?php echo $form->textField($model,'s5Quota',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->