<?php 




$criteria3 = new CDbCriteria;
$criteria3->addCondition("type = :type");
$criteria3->params = array(
	':type'=>'HRLEAVE',
);
		
$HRStatus = ContentTable::model()->findAll($criteria3);

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'leave-application-form',
	'enableAjaxValidation'=>true,
	//'enableClientValidation' => true,
	'clientOptions' => array(
                'validateOnSubmit' => true,
	),
	 'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 


?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	
	
	

<?php echo $form->dropDownListGroup(
			$model,
			'HRStatus',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($HRStatus), 'id', 'content'),
					'htmlOptions' => array(
						'prompt'=>'Please Choose',
						
					),
				)
			)
	); ?>


	
	<?php //echo $form->textFieldGroup($model,'createDate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php //echo $form->textFieldGroup($model,'createdBy',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
<div class="form-actions">
<div class="btn-group btn-group-justified" role="group" aria-label="">
  <div class="btn-group" role="group">
    <a class="btn btn-default" href="<?php echo Yii::app()->request->urlReferrer;?>" role="button">Back</a>
  </div>
  <div class="btn-group" role="group">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Submit' : 'Save',
		)); ?>
	</div>
</div>
</div>


<?php $this->endWidget(); ?>
