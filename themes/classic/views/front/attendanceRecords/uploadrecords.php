<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'attendance-records-form',
	'enableAjaxValidation'=>false,
	 'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . '">' . $message . "</div>\n";
    }
?>
<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	
	
	<?php echo $form->fileFieldGroup($model, 'uploadfiles',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'hint' =>'Please upload the excel file [xls]',
			)
		); ?>
	

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Upload',
		)); ?>
</div>

<?php $this->endWidget(); ?>
