<?php

?><div class="row">
	
	<div class="col-sm-12">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'appl-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableClientValidation'=>true,
	//'enableAjaxValidation'=>true,
	'clientOptions'=>array(
        'validateOnSubmit'=>true,
        //'afterValidate'=>'js:yiiFix.ajaxSubmit.afterValidate'
    ),
	'action'=>($first)?Yii::app()->createUrl('appl/enroll'):Yii::app()->createUrl('appl/edit'),
	'htmlOptions'=>array(
	'class'=>'form-horizontal',
	'enctype'=>'multipart/form-data',
	//'onsubmit'=>"return false;",/* Disable normal form submit */
	)
)); ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Subject Selection Program</h3>
	</div>
	<div class="panel-body">
		<table class="table table-bordered">
			<tr class="info">
				<td rowspan="2" class="text-center vcenter"><b>Class</b></td>
				<th rowspan="2" class="col-sm-2 col-md-2 col-lg-2">Class Choice (please mark 1-3 for 1st-3rd Choices)</th>
				<th colspan="3" class="text-center">Elective subject preference</th>
			</tr>
			<tr class="info">
				<th class="text-center">X1</th>
				<th class="col-sm-4 col-md-4 text-center">X2</th>
				<th class="col-sm-4 col-md-4 text-center">X3</th>
			</tr>
			
			<!--F,G,H,J-->
			<tr>
				<td class="text-center vcenter info"><b>Faith<br>Grace<br>Hope<br>Joy</b></td>
				<td class="text-center vcenter">
				
					<?php 
					
					echo $form->dropDownList(
					$applModel,
					"[0]pre", 
					array(
						"1"=>"1st Choice",
						"2"=>"2nd Choice",
						"3"=>"3rd Choice",
						
					),
					array(
					'empty'=>'Please Choose', 
					'class'=>'form-control',
					'ref'=>'choice',
					//'id'=>"Appl_pre_1"
					));?>
					<?php echo $form->error($applModel,"[0]pre"); ?>
				</td>
				<td class="text-center vcenter active"><b>E/C/M/L</b></td>
				<td><?php 
				for($i=0;$i<=2;$i++){
					echo $form->dropDownList(
					$applsubModel,
					"[".$i."]choice", 
					CHtml::listData(Sub::model()->findAllByAttributes(array(
						'subevtid'=>'2',
						//'acayear'=>'2014'
					),array('condition'=>'quota > :quota','params'=>array('quota'=>'0'),'order'=>'sub_name')), 'sub_id','sub_name'),
					array(
					'empty'=>'Please Choose', 
					'class'=>'form-control',
					//'id'=>'ApplSub_choice_X2_'.$i,
					'ref'=>'g1_x2',
					));
				echo $form->error($applsubModel,"[".$i."]choice");
					}?>
					</td>
				<td ><?php 
				for($i=3;$i<=5;$i++){
					echo $form->dropDownList(
					$applsubModel,
					"[".$i."]choice", 
					CHtml::listData(Sub::model()->findAllByAttributes(array(
						'subevtid'=>'3',
						//'acayear'=>'2014'
					),array('condition'=>'sub_name != :name and sub_name != :name2 and quota > :quota','params'=>array('name'=>'Mathematices Extension Modules 1','name2'=>'Mathematices Extension Modules 2','quota'=>'0'),'order'=>'sub_name')), 'sub_id','sub_name'),
					array(
					'empty'=>'Please Choose', 
					'class'=>'form-control',
					//'id'=>'ApplSub_choice_X3_'.$i,
					'ref'=>'g1_x3',
					));
					echo $form->error($applsubModel,"[".$i."]choice");
					}?></td>
			</tr>
			
			<!--L-->
			<tr>
				<td class="text-center vcenter info"><b>Love</b></td>
				<td class="text-center vcenter">
					<?php 
					
					echo $form->dropDownList(
					$applModel_1,
					"[1]pre", 
					array(
						"1"=>"1st Choice",
						"2"=>"2nd Choice",
						"3"=>"3rd Choice",
						
					),
					array(
					'empty'=>'Please Choose', 
					'class'=>'form-control',
					'ref'=>'choice'
					));?>
					<?php echo $form->error($applModel_1,"[1]pre"); ?>
				</td>
				<td class="text-center vcenter active"><b>Economics</b></td>
				<td><?php 
				for($i=6;$i<=8;$i++){
					echo $form->dropDownList(
					$applsubModel,
					"[".$i."]choice", 
					CHtml::listData(Sub::model()->findAllByAttributes(array(
						'subevtid'=>'2',
						//'acayear'=>'2014'
					),array('condition'=>'sub_name != :name and quota > :quota','params'=>array('name'=>'Economics','quota'=>'0'),'order'=>'sub_name')), 'sub_id','sub_name'),
					array(
					'empty'=>'Please Choose', 
					'class'=>'form-control',
					//'id'=>'ApplSub_choice_X2_'.$i,
					'ref'=>'g2_x2',
					));
					echo $form->error($applsubModel,"[".$i."]choice");
					}?></td>
				<td><?php 
				for($i=9;$i<=11;$i++){
					echo $form->dropDownList(
					$applsubModel,
					"[".$i."]choice",
					CHtml::listData(Sub::model()->findAllByAttributes(array(
						'subevtid'=>'3',
						//'acayear'=>'2014'
					),array('condition'=>'sub_name != :name and quota > :quota','params'=>array('name'=>'Economics','quota'=>'0'),'order'=>'sub_name')), 'sub_id','sub_name'),
					array(
					'empty'=>'Please Choose', 
					'class'=>'form-control',
					//'id'=>'ApplSub_choice_X3_'.$i,
					'ref'=>'g2_x3',
					));
					echo $form->error($applsubModel,"[".$i."]choice");
					}?></td>
			</tr>
			
			
			<!--p-->
			<tr>
				<td class="text-center vcenter info"><b>Peace</b></td>
				<td class="text-center vcenter">
					<?php 
					
					echo $form->dropDownList(
					$applModel_2,
					"[2]pre", 
					array(
						"1"=>"1st Choice",
						"2"=>"2nd Choice",
						"3"=>"3rd Choice",
						
					),
					array(
					'empty'=>'Please Choose', 
					'class'=>'form-control',
					'ref'=>'choice'
					));?>
					<?php echo $form->error($applModel_2,"[2]pre"); ?>
				</td>
				<td class="text-center vcenter active"><b>Physics</b></td>
				<td class="text-center vcenter active"><b>Chemistry</b></td>
				<td><?php 
				for($i=12;$i<=14;$i++){
					echo $form->dropDownList(
					$applsubModel,
					"[".$i."]choice",
					CHtml::listData(Sub::model()->findAllByAttributes(array(
						'subevtid'=>'3',
						//'acayear'=>'2014',
						
					),array('condition'=>'sub_name != :name and sub_name != :name2 and quota > :quota','params'=>array('name'=>'Chemistry','name2'=>'Physics','quota'=>'0'),'order'=>'sub_name')), 'sub_id','sub_name'),
					array(
					'empty'=>'Please Choose', 
					'class'=>'form-control',
					//'id'=>'ApplSub_choice_X3_'.$i,
					'ref'=>'g3_x3',
					));
					echo $form->error($applsubModel,"[".$i."]choice");
					}?></td>
			</tr>
			
		</table>
		
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Information of Parent</h3>
	</div>
	<div class="panel-body">
		<div class="form-group">
			<?php echo $form->labelEx($applModel,'[0]parentName', array('class'=>'col-xs-4 col-sm-4 col-md-3 control-label')); ?>
			<div class="col-sm-8 col-md-6 col-xs-8">
			<?php echo $form->textField($applModel,'[0]parentName',array('class'=>'form-control ','placeholder'=>'Chan Tai Man')); ?>
			<?php echo $form->error($applModel,'[0]parentName'); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($applModel,'[0]phoneNo', array('class'=>'col-xs-4 col-sm-4 col-md-3 control-label')); ?>
			<div class="col-sm-8 col-md-6 col-xs-8">
			<div class="input-group">
				<div class="input-group-addon"><b>852-</b></div>
					
					<?php echo $form->TelField($applModel,'[0]phoneNo',array('class'=>'form-control ','placeholder'=>'67891234')); ?>
			
			</div>
			
			<?php echo $form->error($applModel,'[0]phoneNo'); ?>
			</div>
		</div>
	</div>
</div>
<p class="text-center">
<!--button class="btn" id="Demo">Demo</button-->
<?php echo CHtml::submitButton("Submit", array('class'=>'btn btn-primary')); ?>
<?php $this->endWidget(); ?>
</p>
</div>

<?php if(!$first){ ?>
<script>
$(function(){
	<?php for($i=0;$i<=2;$i++){?>
			$('#Appl_<?php echo $i;?>_pre').val('<?php echo $editApplModel[$i]['pre']?>');
			$('<input type="hidden" name="Appl_preid[]" value="<?php echo $editApplModel[$i]['id'];?>">').insertAfter('#Appl_<?php echo $i;?>_pre');
	<?php }?>
	<?php for($i=0;$i<=14;$i++){?>
			$('#ApplSub_<?php echo $i;?>_choice').val('<?php echo $editApplsubModel[$i]['choice']?>');
			$('<input type="hidden" name="ApplSub_choiceid[]" value="<?php echo $editApplsubModel[$i]['id'];?>">').insertAfter('#ApplSub_<?php echo $i;?>_choice');
	<?php }?>
	$("#Appl_0_parentName").val(<?php echo  CJavaScript::encode($editApplModel[0]->parentName);?>);
	$("#Appl_0_phoneNo").val(<?php echo  CJavaScript::encode($editApplModel[0]->phoneNo)?>);
	
	$('select').each(function(a,b){
	var group = $(b).attr('ref');
    init_select(group);
});
});
</script>
<?php }?>
