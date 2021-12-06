<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'published-events-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldGroup($model,'eventName',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

	<?php echo $form->textFieldGroup($model,'dbName',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>45)))); ?>

	<?php echo $form->textFieldGroup($model,'controller',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>45)))); ?>

	<?php echo $form->textFieldGroup($model,'slipName',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

	<?php //echo $form->textFieldGroup($model,'startDate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

		<?php 
		echo $form->datetimePickerGroup(
			$model,
			'startDate',
			array(
				'widgetOptions' => array(
					'options' => array(
						//'language' => 'es',
						'format' => 'yyyy-mm-dd hh:ii:ss',
						'viewformat' => 'yyyy-mm-dd hh:ii:ss',
					),
				),
			'wrapperHtmlOptions' => array(
				'class' => 'span5',
			),
			//'hint' => 'Click inside! This is a super cool date field.',
			'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			));
		?>

	<?php //echo $form->textFieldGroup($model,'endDate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	
	<?php 
		echo $form->datetimePickerGroup(
			$model,
			'endDate',
			array(
				'widgetOptions' => array(
					'options' => array(
						//'language' => 'es',
						'format' => 'yyyy-mm-dd hh:ii:ss',
						'viewformat' => 'yyyy-mm-dd hh:ii:ss',
					),
				),
			'wrapperHtmlOptions' => array(
				'class' => 'span5',
			),
			//'hint' => 'Click inside! This is a super cool date field.',
			'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			));
		?>

	<?php //echo $form->textFieldGroup($model,'extStart',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php 
		echo $form->datetimePickerGroup(
			$model,
			'extStart',
			array(
				'widgetOptions' => array(
					'options' => array(
						//'language' => 'es',
						'format' => 'yyyy-mm-dd hh:ii:ss',
						'viewformat' => 'yyyy-mm-dd hh:ii:ss',
					),
				),
			'wrapperHtmlOptions' => array(
				'class' => 'span5',
			),
			//'hint' => 'Click inside! This is a super cool date field.',
			'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			));
		?>
	
	<?php //echo $form->textFieldGroup($model,'extEnd',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	
	<?php 
		echo $form->datetimePickerGroup(
			$model,
			'extEnd',
			array(
				'widgetOptions' => array(
					'options' => array(
						//'language' => 'es',
						'format' => 'yyyy-mm-dd hh:ii:ss',
						'viewformat' => 'yyyy-mm-dd hh:ii:ss',
					),
				),
			'wrapperHtmlOptions' => array(
				'class' => 'span5',
			),
			//'hint' => 'Click inside! This is a super cool date field.',
			'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
			));
		?>
		
	<?php echo $form->textFieldGroup($model,'url',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

	<?php //echo $form->textFieldGroup($model,'InputBy',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php //echo $form->textFieldGroup($model,'ModifyBy',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'academicYear',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php //echo $form->textFieldGroup($model,'publishDate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php //echo $form->textFieldGroup($model,'lastUpdate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->dropDownListGroup($model,'shown', array('widgetOptions'=>array('data'=>array("Y"=>"Y","N"=>"N",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

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
