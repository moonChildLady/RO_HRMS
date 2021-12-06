<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'events-permit-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'event_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->dropDownListGroup($model,'S1', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

	<?php echo $form->dropDownListGroup($model,'S2', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

	<?php echo $form->dropDownListGroup($model,'S3', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

	<?php echo $form->dropDownListGroup($model,'S4', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

	<?php echo $form->dropDownListGroup($model,'S5', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

	<?php echo $form->dropDownListGroup($model,'S6', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

	<?php echo $form->dropDownListGroup($model,'S7', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

	<?php echo $form->dropDownListGroup($model,'TEST', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

	<?php echo $form->dropDownListGroup($model,'status', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
