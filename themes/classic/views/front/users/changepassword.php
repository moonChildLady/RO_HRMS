<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) { ?>
        
		<div class="well"><span style="font-size: 20px" class="label label-<?php echo $key;?>"><?php echo $message;?></span></div>
<?php } ?>
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Change Password</h3>
  </div>
  <div class="panel-body">
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'id' => 'users-form',
            'enableClientValidation' => true,
            'htmlOptions' => array('class' => 'well'),
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
     ));
?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->passwordFieldGroup($model,'old_password',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

	<?php echo $form->passwordFieldGroup($model,'new_password',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

	<?php echo $form->passwordFieldGroup($model,'repeat_password',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'success',
			'label'=>'Change Password',
		)); ?>
</div>

<?php $this->endWidget(); ?>
</div>
</div>