<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'alternate-duty-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->datePickerGroup($model,'dutyDate',array('widgetOptions'=>array('options'=>array(),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); ?>

	<?php echo $form->dropDownListGroup($model,'stauts', array('widgetOptions'=>array('data'=>array("YES"=>"YES","NO"=>"NO",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

	<?php echo $form->textFieldGroup($model,'groupID',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>10)))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
