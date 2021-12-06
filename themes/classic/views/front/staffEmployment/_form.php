<?php 


$criteria = new CDbCriteria;
$criteria->addCondition("type = :type");
$criteria->params = array(
	':type'=>'BASIS',
);
		
$Basis = ContentTable::model()->findAll($criteria);

$criteria1 = new CDbCriteria;
$criteria1->addCondition("type = :type");
$criteria1->params = array(
	':type'=>'POSITION',
);
		
$position = ContentTable::model()->findAll($criteria1);

$criteria2 = new CDbCriteria;
$criteria2->addCondition("staffCode = :staffCode");
$criteria2->params = array(
	':staffCode'=>$model->staffCode,
);
		
$isUsers = Users::model()->findAll($criteria2);
unset($criteria1);
$criteria1 = new CDbCriteria;
$criteria1->addCondition("type = :type");
$criteria1->params = array(
	':type'=>'LEAVEGROUP',
);
		
$LEAVEGROUP = ContentTable::model()->findAll($criteria1);

unset($criteria1);
$criteria1 = new CDbCriteria;
$criteria1->order = "id ASC";
		
$TimeSlotGroup = TimeSlotGroup::model()->findAll($criteria1);

$criteria3=new CDbCriteria;
$criteria3->addCondition("type = 'DEPARTMENT'");
$criteria3->order = "content ASC";

$criteria4=new CDbCriteria;
$criteria4->addCondition("type = 'DIVISION'");
$criteria4->order = "content ASC";

$criteria5=new CDbCriteria;
$criteria5->addCondition("type = 'COMPANY'");
$criteria5->order = "content ASC";

$companyData = ContentTable::model()->findAll($criteria5);
$departmentData = ContentTable::model()->findAll($criteria3);
$divisionData = ContentTable::model()->findAll($criteria4);




$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'staff-employment-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary(array($model, $StaffModel)); ?>

	<?php echo $form->textFieldGroup(
		$StaffModel,
		'staffCode',
			array(
				'widgetOptions'=>array(
					'htmlOptions'=>array(
						'class'=>'span5',
						'maxlength'=>100,
						'disabled'=>(Yii::app()->controller->action->id=="update")?true:false,
					)
		))); ?>
		
	
	
		
<?php if(!$isUsers){ ?>		
	<?php echo $form->checkboxGroup(
			$model,
			'createPortalAccount',
			array(
				'widgetOptions' => array(
					'htmlOptions' => array(
						//'disabled' => true
					)
				)
			)
		); ?>		
		
	<?php echo $form->textFieldGroup($model,'password',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
<?php }?>

	
	<?php echo $form->textFieldGroup($StaffModel,'surName',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>

	<?php echo $form->textFieldGroup($StaffModel,'givenName',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	
	<?php echo $form->textFieldGroup(
		$StaffModel,
		'nickName',
			array(
				'widgetOptions'=>array(
					'htmlOptions'=>array(
						'class'=>'span5',
						'maxlength'=>100,
						
					)
		))); ?>
		
	<?php echo $form->textFieldGroup($StaffModel,'chineseName',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	<?php echo $form->textFieldGroup($StaffModel,'email',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	<?php echo $form->textFieldGroup($StaffModel,'HKID',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>	
	
	<?php echo $form->textFieldGroup($CWRModel,'cwr',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	
	<?php //echo $form->textFieldGroup($CWRModel,'cwrDate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	
	<?php echo $form->datePickerGroup(
		$CWRModel,
		'cwrDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'span5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); 
?>
	
	
	<?php echo $form->textFieldGroup($CWRModel,'whiteCard',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	
	<?php echo $form->datePickerGroup(
		$CWRModel,
		'whiteCardDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'span5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); 
?>


<?php echo $form->textFieldGroup($CWRModel,'greenCard',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>
	
	<?php echo $form->datePickerGroup(
		$CWRModel,
		'greenCardDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'span5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); 
?>
	
	<?php //echo $form->textFieldGroup($StaffModel,'whiteCardDate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>	
<?php echo $form->textFieldGroup($StaffModel,'mobilePhone',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); ?>	
	
	<?php echo $form->dropDownListGroup(
			$StaffModel,
			'gender',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => array("M"=>"Male","F"=>"Female"),
					'htmlOptions' => array(
						'prompt'=>'Please Chooses',
						
					),
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
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'span5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); 
?>
<?php echo $form->datePickerGroup(
		$model,
		'probationEndDate',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'span5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); 
?>
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
					'class'=>'span5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); ?>
				
	
<?php echo $form->datePickerGroup(
		$StaffModel,
		'dob',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'span5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year to select a different Month/Year.')); ?>	
	
<?php 

if($model->isNewRecord){
echo $form->textFieldGroup($model,'balance',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>100)))); 
}
?>
	<?php echo $form->dropDownListGroup(
			$DepartmentModel,
			'companyID',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($companyData), 'id', 'content'),
					'htmlOptions' => array(
						'prompt'=>'Please Chooses',
						
					),
				)
			)
	); ?>
	<?php echo $form->dropDownListGroup(
			$DepartmentModel,
			'departmentID',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($departmentData), 'id', 'content'),
					'htmlOptions' => array(
						'prompt'=>'Please Chooses',
						
					),
				)
			)
	); ?>
	
	<?php echo $form->dropDownListGroup(
			$DepartmentModel,
			'divisionID',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($divisionData), 'id', 'content'),
					'htmlOptions' => array(
						'prompt'=>'Please Chooses',
						
					),
				)
			)
	); ?>
	<?php echo $form->textAreaGroup($model,'projectCode', array('widgetOptions'=>array(
		'htmlOptions'=>array('rows'=>6, 'cols'=>30, 'class'=>'col-sm-5'
	)))); ?>
	<?php echo $form->textAreaGroup($model,'registeredTrade', array('widgetOptions'=>array(
		'htmlOptions'=>array('rows'=>6, 'cols'=>30, 'class'=>'col-sm-5'
	)))); ?>
	<?php echo $form->dropDownListGroup(
			$model,
			'Basis',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($Basis), 'id', 'content'),
					'htmlOptions' => array(
						'prompt'=>'Please Chooses',
						
					),
				)
			)
	); ?>
	<?php 
	
	echo $form->select2Group(
			$model,
			'positionID',
			array(
				//'data'=>CHtml::listData(($staffs), 'id', 'staffCode'),
				/* 'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				), */
				'widgetOptions' => array(
					//'asDropDownList' => false,
					
					'data' => CHtml::listData(($position), 'id', 'content'),
					'options'=>array(
						'placeholder'=>'Please Chooses',
					),
					
				)
			)
		);
?>
<?php /* echo $form->dropDownListGroup(
			$model,
			'positionID',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($position), 'id', 'content'),
					'htmlOptions' => array(
						'prompt'=>'Please Chooses',
						
					),
				)
			)
	); */ ?>
	
	<?php echo $form->dropDownListGroup(
			$groupModel,
			'groupID',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($LEAVEGROUP), 'id', 'content'),
					'htmlOptions' => array(
						'prompt'=>'Please Chooses',
						
					),
				)
			)
	); ?>
	
	<?php echo $form->dropDownListGroup(
			$groupModel,
			'alternateGroupID',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => array(
						'0'=>'Every Saturday', 
						'1'=>'Group 1', 
						'2'=>'Group 2', 
						'3'=>'Group 3',
						'4'=>'Group 4',
						'99'=>'No Alternate'
						),
					'htmlOptions' => array(
						'prompt'=>'Please Chooses',
						
					),
				)
			)
	); ?>
	
<div class="row">
	<div class="col-md-5">
	<?php echo $form->dropDownListGroup(
			$timeSlotModel,
			'timeSlotGroup',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($TimeSlotGroup), 'id', 'groupName'),
					'htmlOptions' => array(
						'prompt'=>'Please Chooses',
						
					),
				)
			)
	); ?>
	</div>
	<div class="col-md-5">
		<table class="table table-bordered">
		<tr>
			<td>Time Slot Group</td>
			<td>Session I</td>
			<td>Session II</td>
		</tr>
		</tr>
		<?php foreach($TimeSlotGroup as $i=>$val){ ?>
			<tr>
				<td><?php echo $val->groupName;?></td>
				<?php foreach($val->timeSlotAissigments as $j=>$timeSlotAissigment){ ?>
				<td>
					<p><?php echo $timeSlotAissigment->timeSlot0->timeslotName;?></p>
					<p><?php echo $timeSlotAissigment->timeSlot0->startTime;?></p>
					<p><?php echo $timeSlotAissigment->timeSlot0->endTime;?></p>
				</td>
				<?php } ?>
			</tr>
		<?php } ?>
		</table>
	</div>
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
	$("#StaffEmployment_password").parent().hide();
	$("#StaffEmployment_createPortalAccount").click(function(){
		if($(this).is(':checked')){
		//console.log("1");
			$("#StaffEmployment_password").parent().show();
		}else{
			$("#StaffEmployment_password").parent().hide();
		}
	});
});
</script>