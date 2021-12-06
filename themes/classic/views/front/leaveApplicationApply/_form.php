<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'leave-application-apply-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldGroup($model,'startDate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	
	<?php echo $form->dateTimePickerGroup(
		$model,
		'startDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd hh:ii:00',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'span5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); 
?>
	
	<?php //echo $form->textFieldGroup($model,'endDate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	
	<?php echo $form->dateTimePickerGroup(
		$model,
		'endDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd hh:ii:00',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'span5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); 
?>

	<?php echo $form->datePickerGroup($model,'applyStartDate',array('widgetOptions'=>array('options'=>array(),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); ?>

	<?php echo $form->datePickerGroup($model,'applyEndDate',array('widgetOptions'=>array('options'=>array(),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
