<?php 


$criteria = new CDbCriteria;
$criteria->addCondition("type = :type");
$criteria->params = array(
	':type'=>'projectType',
);
		
$projectType = wwwContentTable::model()->findAll($criteria);

$checked = array();
if(!$model->isNewRecord){
	foreach($model->projectTypes as $i=>$type){
		$checked[] = $type->typeID;
	}
}

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'www-projects-form',
	'enableAjaxValidation'=>false,
	 'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textAreaGroup($model,'title', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	<?php echo $form->textAreaGroup($model,'projectName', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	<?php echo $form->textAreaGroup($model,'location', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	<?php echo $form->textAreaGroup($model,'nature', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	<?php echo $form->textAreaGroup($model,'contractSum', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	<?php echo $form->textAreaGroup($model,'clientName', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	<?php echo $form->textAreaGroup($model,'architect', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	<?php echo $form->textAreaGroup($model,'mainContrator', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')))); ?>

	
	
	<div class="form-group">
	<label class="control-label required" for="wwwProjects_status">Project Type <span class="required">*</span></label>
	
	<?php foreach($projectType as $i=>$type) { ?>
	<div class="checkbox">
		<label>
		<input type="checkbox" value="<?php echo $type->id;?>" name="ProjectType[typeID][]" <?php echo (in_array($type->id, $checked))?"checked":"";?>><?php echo $type->name;?></label>
	</div>
	<?php } ?>
</div>


	<?php echo $form->dropDownListGroup($model,'status', array('widgetOptions'=>array('data'=>array("ACTIVE"=>"ACTIVE","DISABLED"=>"DISABLED",), 'htmlOptions'=>array('class'=>'input-large')))); ?>

	<?php /* echo $form->dropDownListGroup(
		$typeModel,
		'typeID', 
		array('widgetOptions'=>array(
			'data'=>CHtml::listData(($projectType), 'id', 'name'),
			'htmlOptions'=>array(
			'class'=>'input-large js-example-basic-multiple',
			'multiple'=>"multiple",
			
			)
			))); */ ?>
<div class="form-group">
	<label class="control-label required" for="wwwProjects_status">Project Images <span class="required">*</span></label>
<?php
  $this->widget('CMultiFileUpload', array(
     'model'=>$ImagesModel,
     'attribute'=>'imagePath',
     'accept'=>'jpg|jpeg|png',
     'options'=>array(
        // 'onFileSelect'=>'function(e, v, m){ alert("onFileSelect - "+v) }',
        // 'afterFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
        // 'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
        // 'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
        // 'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
        // 'afterFileRemove'=>'function(e, v, m){ alert("afterFileRemove - "+v) }',
     ),
     'denied'=>'File is not allowed',
     'max'=>10, // max 10 files


  ));
?>
</div>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
<script>
$(function(){
	$(document).ready(function() {
		$('.js-example-basic-multiple').select2();
	});
});
</script>

