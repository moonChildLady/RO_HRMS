<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Login - Ray On Portal</h3>
  </div>
  <div class="panel-body">
    <p>Please fill out the following form with your login credentials:</p>
		<?php 

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'login-form',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>



<?php echo $form->errorSummary($model); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->textFieldGroup(
			$model,
			'username',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				//'hint' => 'In addition to freeform text, any HTML5 text-based input appears like so.'
			)
		); ?>
		<?php echo $form->passwordFieldGroup(
			$model,
			'password',
			array(
				'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
				),
				//'hint' => 'In addition to freeform text, any HTML5 text-based input appears like so.'
			)
		); ?>
	<?php echo $form->checkboxGroup(
			$model,
			'rememberMe',
			array(
				'widgetOptions' => array(
					'htmlOptions' => array(
						//'disabled' => true
					)
				)
			)
		); ?>

	<div class="btn-group" role="group">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Login',
		)); ?>
	</div>

	

<?php $this->endWidget(); ?>
  </div>
</div>

