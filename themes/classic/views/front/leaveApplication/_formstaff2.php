<?php 
$staffCode = Yii::app()->user->getState('staffCode');
$month = Yii::app()->request->getParam('month', 1);
$criteria = new CDbCriteria;



$criteria->addCondition("type = :type");
$criteria->params = array(
	':type'=>'LEAVEREASON',
);

if($type == null){
	//$criteria->addNotINCondition("id", array("130"));
	$criteria->addNotINCondition("id", array("128","129","130"));
}

if(!$this->checkProbation($staffCode, date('Y-m-d'))['isProbation']){
	if($this->getLongServiceYear($staffCode)%6==0){
		
	}else{
		$criteria->addNotINCondition("id", array("128"));
	}
	
}else{
	$criteria->addNotINCondition("id", array("129"));
}
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
	
	$ALTypeArray = array("66","67","83","84","110","68","85","131");
	$spTypeArray = array("130","128","129");
	if(in_array($type, $ALTypeArray) || $type==null){
		
	$datetime1 = new DateTime();
	$datetime2 = new DateTime('2019-10-02');
	$interval1 = $datetime1->diff($datetime2);
	
	/* if(date('m') <= $month){
		$interval = $interval1->format('+%ad');
	}else{
		$interval = $interval1->format('-%ad');
	} */
	
	$interval = $datetime2->format('Y-m-d');
	
	$datetime3 = new DateTime();
	$datetime4 = new DateTime('2019-12-31');
	$interval5 = $datetime3->diff($datetime4);
	$interval_ = $interval5->format('+%ad');
	
	/* if(date('m') >= $month){
		$interval_ = $interval5->format('+%ad');
	}else{
		$interval_ = $interval5->format('-%ad');
	} */
	
	$interval_ = $datetime4->format('Y-m-d');
	
	}elseif(in_array($type, $spTypeArray)){
	
	if($type=="130"){
		/* $date = new DateTime($modelUser->staffCode0->dob);
	
		//First day of month
		$date->modify('first day of this month');
		$firstday= $date->format('m-d');
		//Last day of month
		$date->modify('last day of this month');
		$lastday= $date->format('m-d');
		
		$datetime1 = new DateTime();
		$datetime2 = new DateTime(date('Y-').$firstday);
		$datetime2->modify('+1 day');
		$interval1 = $datetime1->diff($datetime2);
		
		if(date('m', strtotime($modelUser->staffCode0->dob)) == date('m')){
			$interval = $interval1->format('-%ad');
		}else{
			$interval = $interval1->format('+%ad');
		} */
		
		
			if(date('m', strtotime($modelUser->staffCode0->dob)) == "12"){
			$date = new DateTime($modelUser->staffCode0->dob);
			
			
			//Last day of month
			$date->modify('last day of this month');
			$lastday= $date->format('m-d');
			//First day of month
			$date->modify('-2 month');
			$date->modify('first day of this month');
			$firstday= $date->format('m-d');
			
			
			$datetime1 = new DateTime();
			$datetime2 = new DateTime(date('Y-').$firstday);
			//$datetime2->modify('+1 day');
			$interval1 = $datetime1->diff($datetime2);
			
			//$interval = $interval1->format('+%ad');
			$interval = $datetime2->format('Y-m-d');
			
		}elseif(date('m', strtotime($modelUser->staffCode0->dob)) == "01"){
			$date = new DateTime($modelUser->staffCode0->dob);
			//First day of month
			
			$date->modify('first day of this month');
			$firstday= $date->format('m-d');
			
			//Last day of month
			$date->modify('+2 month');
			$date->modify('last day of this month');
			$lastday= $date->format('m-d');
			
			$datetime1 = new DateTime();
			$datetime2 = new DateTime(date('Y-').$firstday);
			//$datetime2->modify('+1 day');
			$interval1 = $datetime1->diff($datetime2);
			
			
			//$interval = $interval1->format('-%ad');
			$interval = $datetime2->format('Y-m-d');
			
			
		}else{
		
		$date = new DateTime($modelUser->staffCode0->dob);
		//First day of month
		$date->modify('-1 month');
		$date->modify('first day of this month');
		$firstday= $date->format('m-d');
		//Last day of month
		$date->modify('+2 month');
		$date->modify('last day of this month');
		$lastday= $date->format('m-d');
		
		$datetime1 = new DateTime();
		$datetime2 = new DateTime(date('Y-').$firstday);
		//$datetime2->modify('+1 day');
		$interval1 = $datetime1->diff($datetime2);
		
		
		$interval = $datetime2->format('Y-m-d');
		
		/* if(date('m', strtotime($modelUser->staffCode0->dob)) >= date('m')){
			
			
			if(date('m', strtotime($modelUser->staffCode0->dob)) == date('m')){
				$interval = $interval1->format('-%ad');
			}else{
				$interval = $interval1->format('+%ad');
			}
		}else{
			
			$interval = $interval1->format('-%ad');
			
		} */
		
		
		
		}
		//echo $firstday;
		//echo $lastday;
		//$interval = $interval1->format('-%ad');
		
		
		
		$datetime3 = new DateTime();
		$datetime4 = new DateTime(date('Y-').$lastday);
		//$datetime4->modify('+1 day');
		$interval5 = $datetime3->diff($datetime4);
		
		
		//$interval_ = $interval5->format('+%ad');
		$interval_ = $datetime4->format('Y-m-d');
		
		if($lastday < date('m-d')){
			throw new CHttpException(500,'Birthday leave apply before the Birthday month only.');
		}
	}
	
	if($type=="128" && $this->getLongServiceYear($staffCode)%6==0){
		$period = $this->getLongServiceYearDetails($staffCode);
		
		$startDate = $modelUser->staffCodeEmploy->startDate;
		$d1 = new DateTime($startDate);
		$start = $d1->modify('+'.$this->getLongServiceYear($staffCode).' year')->format('Y-m-d');
		$end = $d1->modify('+1 year')->format('Y-m-d');
		/* foreach ($period as $key => $value) { 
			if($key==(count($period))){
				$start = $value->format('Y-m-d');
				$end = $value->modify('+1 year')->modify('-1 day')->format('Y-m-d');
			}
		} */
		
		$datetime1 = new DateTime();
		$datetime2 = new DateTime($start);
		//$datetime2->modify('+1 day');
		$interval1 = $datetime1->diff($datetime2);
		//$interval = $interval1->format('-%ad');
		$interval = $datetime2->format('Y-m-d');
		
		
		$datetime3 = new DateTime();
		$datetime4 = new DateTime($end);
		//$datetime4->modify('+1 day');
		$interval5 = $datetime3->diff($datetime4);
		//$interval_ = $interval5->format('+%ad');
		$interval_ = $datetime4->format('Y-m-d');
		
		
	}
	
	if($type=="129"){
		$interval = "";
		$interval_ = "";
	}
		//echo $interval;
		//echo $interval_;
		
		
	}else{
		throw new CHttpException(500,'Error');
	}
	//echo $interval_;
	echo $form->datePickerGroup(
		$model,
		'startDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					'startDate'=>$interval,
					'endDate'=>$interval_,
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
					'startDate'=>$interval,
					'endDate'=>$interval_,
					
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
	
	<?php 
	if(!in_array($type, $ALTypeArray)  && $type!=null){
		?>
	$("#LeaveApplication_reasonID").val('<?php echo $type;?>');
	$("#LeaveApplication_startDateType").val('ALL');
	<?php if($type=="129"){ ?>
		$("#LeaveApplication_endDateType").val('ALL');
	<?php } ?>
	
	$("#LeaveApplication_reasonID option").each(function(i,v){
		if($(v).val()!='<?php echo $type;?>'){
			$(v).attr("disabled", true);
			$(v).hide();
		}
	});
	
	
	$("#LeaveApplication_startDateType option").each(function(i,v){
		if($(v).val()!='ALL'){
			$(v).attr("disabled", true);
			$(v).hide();
		}
	});
	<?php if($type=="129"){ ?>
		$("#LeaveApplication_endDateType option").each(function(i,v){
		if($(v).val()!='ALL'){
			$(v).attr("disabled", true);
			$(v).hide();
		}
	});
	<?php } ?>
	//$("#LeaveApplication_reasonID").attr("disabled", true);
	//$("#LeaveApplication_startDateType").attr("disabled", true);
	<?php if($type=="130"){ ?>
		$("#endDateSection").hide();
	<?php } ?>
	<?php } ?>
	
});
</script>