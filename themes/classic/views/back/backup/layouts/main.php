<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php
       // var_dump(Yii::app()->session['memberinfo']);
	   Yii::app()->clientScript->registerCoreScript('yii');
	   Yii::app()->clientScript->registerScript('Yii Fix',";yiiFix = {
    ajaxSubmit : {  
        beforeSend : function(form) {
            return function(xhr,opt) {
                form = $(form);
                $._data(form[0], 'events').submit[0].handler();
                var he = form.data('hasError');
                form.removeData('hasError');
                return he===false;
            }
        },
 
        afterValidate : function(form, data, hasError) {
            $(form).data('hasError', hasError);
            return true;
        }
    }
};",CclientScript::POS_HEAD);
        $cs = Yii::app()->clientScript;
		$themePath = Yii::app()->theme->baseUrl;
		$cs
			->registerCssFile($themePath.'/css/main.css');
			
		$cs
			->registerScriptFile($themePath.'/js/jquery.scrollTo.min.js');
		
		if(Yii::app()->controller->id == "lwwSelection"){
			$cs->registerScriptFile($themePath.'/js/process.js',CClientScript::POS_END);
		}
		if(Yii::app()->controller->id == "appl" || Yii::app()->controller->id == "Appl"){
			$cs
			->registerCssFile($themePath.'/css/Appl_main.css')
			->registerScriptFile($themePath.'/js/Appl.js');
		}
	?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container">

<?php $this->widget('application.components.MainMenu');?>

	<?php $this->widget('application.components.UserInfo');?>
<hr>
	

	<?php echo $content; ?>

	

	<!--footer class="footer">
      <div class="container">
        <p class="text-muted">Place sticky footer content here.</p>
      </div>
    </footer-->
<hr>
<p class="text-center">For further enqiury, please email to itadmin@spkc.edu.hk or dail 852-23454567.</p>
</div><!-- page -->

</body>
</html>
