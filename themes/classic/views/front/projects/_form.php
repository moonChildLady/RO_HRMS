<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'projects-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'year',array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'class'=>'span5',
				'maxlength'=>4
			)),
			'hint'=>'e.g: 2017',
			)); ?>
	
	<?php echo $form->textFieldGroup($model,'code',array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'class'=>'span5',
				'maxlength'=>100
			)),
			'hint'=>'e.g: 053',
			)); ?>
	
	<?php echo $form->textFieldGroup($model,'code2',array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'class'=>'span5',
				'maxlength'=>100
			)),
			'hint'=>'e.g: -MW-OTE-HCEL',
			)); ?>
	

	<?php echo $form->textAreaGroup($model,'projectTitle', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>
	
	
<?php echo $form->datePickerGroup(
		$model,
		'startDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'col-sm-5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year')); 
?>

<?php echo $form->datePickerGroup(
		$model,
		'endDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'col-sm-5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year')); 
?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
