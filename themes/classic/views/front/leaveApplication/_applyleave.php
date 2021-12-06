<?php 
$staffCode = Yii::app()->user->getState('staffCode');

$criteria = new CDbCriteria;



$criteria->addCondition("type = :type");
$criteria->params = array(
	':type'=>'LEAVEREASON',
);

$criteria->addNotINCondition("id", array("128","129","130","160"));
//,"129","128"
$criteria->order = "content ASC";
$reasonIDs = ContentTable::model()->findAll($criteria);





$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'leave-application-form',
	'enableAjaxValidation'=>true,
	//'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	 'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropDownListGroup(
			$model,
			'reasonID',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				//'hint'=>'',
				'widgetOptions' => array(
					'data' => CHtml::listData(($reasonIDs), 'id', 'content'),
					'htmlOptions' => array(
						'prompt'=>'Please Choose',
						
						
					),
				)
			)
	); ?>	
	<div class="row">
	<div class="col-md-6">
	<?php 
	$startDate = $LeaveApplicationApply->applyStartDate;
	$endDate = $LeaveApplicationApply->applyEndDate;
	
	
	echo $form->datePickerGroup(
		$model,
		'startDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					//'min'
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
	<?php 
	
	
	echo $form->dropDownListGroup(
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

	<div class="row" id="endDateSection">
	<div class="col-md-6">
	<?php 
	
	
	echo $form->datePickerGroup(
		$model,
		'endDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					'startDate'=>$startDate,
					'endDate'=>$endDate,
					
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
	
	

<div id="reasonHints">
</div>

	<?php echo $form->textAreaGroup($model,'reasonRemarks', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	
	
	
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
<script>
$(function(){
	$("#LeaveApplication_reasonID").change(function(){
	var text = ""; 
		if($(this).val()=="66"){
			text='<div class="alert alert-danger" role="danger">Please submit the application along with the original medical certificate to the HR Department.</div>';
		}
		if($(this).val()=="83"){
			text='<div class="alert alert-danger" role="danger">Please upload the exam timetable or any supporting documents you have.</div>';
		}
		if($(this).val()=="84" || $(this).val()=="85"){
			text='<div class="alert alert-danger" role="danger">Please upload any supporting documents you have.</div>';
		}
		
		if($(this).val()=="131" || $(this).val()=="84" || $(this).val()=="85" || $(this).val()=="128"){
			$("#LeaveApplication_startDateType").val('ALL');
			$("#LeaveApplication_endDateType").val('ALL');
			
			$("#LeaveApplication_startDateType option, #LeaveApplication_endDateType option").each(function(i,v){
				if($(v).val()!='ALL'){
					$(v).attr("disabled", true);
					$(v).hide();
				}
			});
		}else{
			$("#LeaveApplication_startDateType option, #LeaveApplication_endDateType option").each(function(i,v){
				if($(v).val()!='ALL'){
					$(v).attr("disabled", false);
					
				}
				$(v).show();
			});
		}
		
		//console.log(text);
		
				
		$("#reasonHints").html(text);
	});
	
	
	
});
</script>