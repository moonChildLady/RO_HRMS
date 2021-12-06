<?php 

$criteria2 = new CDbCriteria;
//$criteria2->addCondition("staffCode != :staffCode");
$criteria2->params = array(
	//':staffCode'=>Yii::app()->user->getState('staffCode'),
);
$criteria2->order = "staffCode ASC";	
$staffs = Staff::model()->findAll($criteria2);

$criteria1 = new CDbCriteria;
$criteria1->addCondition("type = :type");
$criteria1->params = array(
	':type'=>'ELEAVE',
);
		
$commentIDs = ContentTable::model()->findAll($criteria1);


$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'approvers-form',
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
	<?php //echo $form->textFieldGroup($model,'approver',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	
	<?php 
	
	echo $form->select2Group(
			$model,
			'approver',
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

<?php echo $form->dropDownListGroup(
			$model,
			'position',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($commentIDs), 'id', 'content'),
					'htmlOptions' => array(),
				)
			)
		); ?>
<?php echo $form->datePickerGroup(
		$model,
		'startDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					'viewformat' => 'yyyy-mm-dd',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'col-sm-5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year')); 
?>

<?php if(!$model->isNewRecord) { ?>
	<?php echo $form->checkboxGroup(
			$model,
			'deleteApprover',
			array(
				'widgetOptions' => array(
					'htmlOptions' => array(
						//'disabled' => true
					)
				)
			)
		); ?>
<?php } ?>
	
	<?php //echo $form->textFieldGroup($model,'position',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
