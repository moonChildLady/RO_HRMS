<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'users-form',
	//'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	//'htmlOptions' => array('class' => 'well'),
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldGroup($model,'staffCode',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

	<?php //echo $form->textFieldGroup($model,'password',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	
	<?php echo $form->passwordFieldGroup($model,'new_password',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

	<?php echo $form->passwordFieldGroup($model,'repeat_password',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

	<?php echo $form->dropDownListGroup($model,'resigned', array('widgetOptions'=>array('data'=>array("YES"=>"YES","NO"=>"NO",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
