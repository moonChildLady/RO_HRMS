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

	<?php //echo $form->textFieldGroup($model,'staffCode',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	
	<?php 
	if($model->isNewRecord){
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
		
	}else{?>
		<h3><?php //echo $model->staffCode0->FullnamewithStaffCode;?></h3>	
		<?php }?>

	<?php //echo $form->textFieldGroup($model,'startDate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<div class="row">
	<div class="col-md-6">
	<?php echo $form->datePickerGroup(
		$model,
		'startDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":"",
					'endDate'=>(Yii::app()->user->checkAccess('eLeave Admin') || Yii::app()->user->checkAccess('eLeave Admin 2'))?'':'2019-12-31',
				),
				'htmlOptions'=>array(
					'class'=>'col-sm-5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year')); 
?>
</div>
<div class="col-md-6">
	<?php echo $form->dropDownListGroup(
			$model,
			'startDateType',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => array("ALL"=>"All Day","AM"=>"AM", "PM"=>"PM"),
					'htmlOptions' => array(),
				)
			)
		); ?>
</div>
</div>

	<div class="row">
	<div class="col-md-6">
	<?php echo $form->datePickerGroup(
		$model,
		'endDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'endDate'=>date('Y').'-12-31',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'col-sm-5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year')); 
?>
</div>
<div class="col-md-6">
	<?php echo $form->dropDownListGroup(
			$model,
			'endDateType',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => array("ALL"=>"All Day","AM"=>"AM", "PM"=>"PM"),
					'htmlOptions' => array(),
				)
			)
		); ?>
</div>
</div>
	
	


		
	<?php //echo $form->textFieldGroup($model,'duration',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php //echo $form->textFieldGroup($model,'reasonID',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	
	<?php echo $form->dropDownListGroup(
			$model,
			'reasonID',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($reasonIDs), 'id', 'content'),
					'htmlOptions' => array(
						'prompt'=>'Please Choose',
						
					),
				)
			)
	); ?>

	<?php echo $form->textAreaGroup($model,'reasonRemarks', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	<?php //echo $form->textFieldGroup($model,'commentID',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	
	<?php echo $form->dropDownListGroup(
			$model,
			'commentID',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($commentIDs), 'id', 'content'),
					'htmlOptions' => array(
						'prompt'=>'Please Choose',
						
					),
				)
			)
	); ?>
	
	
	<?php echo $form->textAreaGroup($model,'commentRemarks', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	<?php //echo $form->textFieldGroup($model,'attachmentID',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	
	
	<div class="row">
	<div class="col-md-6">
	<?php echo $form->fileFieldGroup($model, 'attachment',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'hint' =>$model->isNewRecord ? '' : 'Current attachment will be replaced when upload a new attachment.',
			)
		); ?>
	</div>
	<?php if(!$model->isNewRecord && $model->attachmentID){ ?>
	<div class="col-md-6">
	<div class="panel panel-default">
  <div class="panel-heading">Uploaded Attachment</div>
  <div class="panel-body">
    <a href="<?php echo Yii::app()->createURL("LeaveApplication/getAttachment", array('code'=>md5($model->attachments->id.$model->attachments->createDate))); ?>">Download</a>
	<?php if(pathinfo($model->attachments->fileLocation, PATHINFO_EXTENSION)=="jpg" || pathinfo($model->attachments->fileLocation, PATHINFO_EXTENSION)=="png" || pathinfo($model->attachments->fileLocation, PATHINFO_EXTENSION)=="jpeg") { ?>
	<img src="<?php echo $this->getPhoto(md5($model->attachments->id.$model->attachments->createDate)); ?>" class="img-responsive">
	<?php } ?>
  </div>
</div>
	</div>
	<?php } ?>
	</div>
	
	
<?php if(Yii::app()->user->checkAccess('admin')){ ?>
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
<?php } ?>

	
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
