<?php 


$criteria = new CDbCriteria;
$criteria->addCondition("type = :type");
$criteria->params = array(
	':type'=>'LEAVEREASON',
);
		
$reasonIDs = ContentTable::model()->findAll($criteria);


$criteria1 = new CDbCriteria;
$criteria1->addCondition("type = :type");
$criteria1->params = array(
	':type'=>'LEAVECOMMENT',
);
		
$commentIDs = ContentTable::model()->findAll($criteria1);

$criteria2 = new CDbCriteria;

if(Yii::app()->controller->action->id == "create"){
$criteria2->addCondition("staffCode != :staffCode");
$criteria2->params = array(
	':staffCode'=>Yii::app()->user->getState('staffCode'),
);
}

$criteria2->order = "staffCode ASC";
		
$staffs = Staff::model()->findAll($criteria2);


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
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Export Leave Application</h3>
  </div>
  <div class="panel-body">
<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldGroup($model,'staffCode',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	<div class="row">
	<div class="col-md-12">
	<?php 
	echo $form->select2Group(
			$model,
			'staffCode',
			array(
			'hint'=>'Leave blank if export for all staff.',
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
		);?>
</div>
</div>
	<?php //echo $form->textFieldGroup($model,'startDate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<div class="row">
	<div class="col-md-12">
	<?php echo $form->datePickerGroup(
		$model,
		'startDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'viewformat' => 'mm-dd/yyyy',
					'startDate'=>date('Y').'-01-01'
				),
				'htmlOptions'=>array(
					'class'=>'col-sm-5',
					'value'=>date('Y').'-01-01',
					'disabled'=>true
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year')); 
?>
</div>
<input type="hidden" name="LeaveApplication[startDate]" value="<?php echo date('Y').'-01-01';?>">
</div>

	<div class="row">
	<div class="col-md-12">
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
</div>

</div>
	
	


		
	
<div class="form-actions">
<div class="btn-group btn-group-justified" role="group" aria-label="">
  <div class="btn-group" role="group">
    <a class="btn btn-default" href="<?php echo Yii::app()->request->urlReferrer;?>" role="button">Back</a>
  </div>
  <div class="btn-group" role="group">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'success',
			'label'=>'Export',
		)); ?>
	</div>
</div>
</div>


<?php $this->endWidget(); ?>
</div>
</div>