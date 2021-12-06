<?php 
$criteria2 = new CDbCriteria;
//$criteria2->addCondition("staffCode != :staffCode");
$criteria2->params = array(
	//':staffCode'=>Yii::app()->user->getState('staffCode'),
);
$criteria2->order = "staffCode ASC";	
$staffs = Staff::model()->findAll($criteria2);

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'attendance-records-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldGroup($model,'staffCode',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	
	<?php 
	
	echo $form->select2Group(
			$model,
			'staffCode',
			array(
				//'data'=>CHtml::listData(($staffs), 'id', 'staffCode'),
				/* 'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				), */
				'widgetOptions' => array(
					//'asDropDownList' => false,
					
					'data'=>CHtml::listData(($staffs), 'staffCode', 'FullnamewithStaffCode'),
					'options'=>array(
						'placeholder'=>'Select Staff',
					),
					
				)
			)
		);
?>

	<?php //echo $form->textFieldGroup($model,'timeRecord',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<?php echo $form->dateTimePickerGroup(
		$model,
		'timeRecord',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd hh:ii',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'span5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); 
?>
	
	<?php echo $form->dropDownListGroup(
			$model,
			'type',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => array("Clock-in"=>"Clock-in","Clock-out"=>"Clock-out"),
					'htmlOptions' => array(
						//'prompt'=>'Please Chooses',
						
					),
				)
			)
	); ?>

	<?php //echo $form->textAreaGroup($model,'remarks', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
