<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'admin-users-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldGroup($model,'user_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	
	<?php echo $form->dropDownListGroup($model,'user_id', array('widgetOptions'=>array('data'=>CHtml::listData(Users::model()->findAll(array('condition' => 'classLvl = :classLvl', 'params'=>array(':classLvl'=> '0'))), 'id', 'enName'), 'htmlOptions'=>array('class'=>'input-large','prompt' =>'Please Choose')))); ?>

	<?php //echo $form->textFieldGroup($model,'event_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	
	<?php echo $form->dropDownListGroup($model,'event_id', array('widgetOptions'=>array('data'=>CHtml::listData(PublishedEvents::model()->findAll(array('condition' => 'status = :status', 'params'=>array(':status'=> 'Y'))), 'event_id', 'eventName'), 'htmlOptions'=>array('class'=>'input-large','prompt' =>'Please Choose')))); ?>

	<?php echo $form->dropDownListGroup($model,'status', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	<a class="btn btn-default" href="<?php echo Yii::app()->request->urlReferrer;?>" role="button">Back</a>
</div>

<?php $this->endWidget(); ?>
