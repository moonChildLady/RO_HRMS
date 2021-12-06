<div class="row">
<div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('AttendanceRecords/create');?>">Manually Input</a></li>
    
   
  </ul>
</div>
</div>
<div class="row">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'attendance-records-form',
	//'method'=>'get',
	'action'=>Yii::app()->createURL('AttendanceRecords/report'),
	'enableAjaxValidation'=>false,
	 'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . '">' . $message . "</div>\n";
    }
?>
<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropDownListGroup(
			$model,
			'reportType',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => array('L'=>'Overall',
					//'X'=>'Leave'
					),
					'htmlOptions' => array(
						//'prompt'=>'Please Chooses',
						
					),
				)
			)
	); ?>	
<?php echo $form->dropDownListGroup(
			$model,
			'location',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				'widgetOptions' => array(
					'data' => CHtml::listData(($StarSystem), 'contractID', 'displayName'),
					'htmlOptions' => array(
						//'prompt'=>'Please Chooses',
						
					),
				)
			)
	); ?>	
<?php echo $form->datePickerGroup(
		$model,
		'month',
		array(
			'widgetOptions'=>array(
				'options'=>array(
					'format' => 'yyyy-mm-dd',
					//'startView'=> 2,
					//'minViewMode'=> 1,
					//'viewformat' => 'mm-dd/yyyy',
					//'startDate'=>(!$this->allowAdminAccess())?"new Date()":""
				),
				'htmlOptions'=>array(
					'class'=>'col-sm-5'
				)), 
				'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>', 'append'=>'Click on Month/Year')); 
?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Submit',
		)); ?>
</div>

<?php $this->endWidget(); ?>


<?php if(Yii::app()->user->hasState("models")){ ?>
<?php var_dump(Yii::app()->user->getState("models"));?>
<?php } ?>
</div>