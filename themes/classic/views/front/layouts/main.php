<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
			
			->registerCssFile($themePath.'/css/main.css')
			->registerCssFile($themePath.'/css/fullcalendar.min.css')
			->registerCssFile($themePath.'/js/DataTables/datatables.min.css')
			->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css')
			->registerCssFile($themePath.'/css/fullcalendar.print.min.css', 'print');
			
		$cs
			//->registerScriptFile('http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js')
			//->registerScriptFile($themePath.'/js/css3.js')
			->registerScriptFile($themePath.'/js/jquery.scrollTo.min.js')
			->registerScriptFile($themePath.'/js/main.js')
			->registerScriptFile($themePath.'/js/moment.min.js')
			->registerScriptFile($themePath.'/js/fullcalendar.min.js')
			->registerScriptFile($themePath.'/js/select2.full.min.js')
			->registerScriptFile($themePath.'/js/DataTables/datatables.min.js');
			//->registerScriptFile($themePath.'/js/main.js')
		$cs->registerScriptFile($themePath.'/js/process.js',CClientScript::POS_END);
				
		/* if(Yii::app()->controller->id == "appl" || Yii::app()->controller->id == "Appl"){
			$cs
			->registerCssFile($themePath.'/css/Appl_main.css')
			->registerScriptFile($themePath.'/js/Appl.js');
		} */
		
	?>
<!-- Javascript -->


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container">

<?php $this->widget('application.components.MainMenu');?>

	<?php //$this->widget('application.components.UserInfo');?>

	

	<?php echo $content; ?>

	

	<!--footer class="footer">
      <div class="container">
        <p class="text-muted">Place sticky footer content here.</p>
      </div>
    </footer-->
<hr>
<div class="row">
	<div class="col-md-1 ">
	</div>
	
	<div class="col-md-1 ">
	</div>
</div>
<hr>
<!--p class="text-center">For further enqiury, please email to itadmin@spkc.edu.hk or dail 852-23454567.</p-->

</div><!-- page -->

</body>
</html>
<style>
.dl-horizontal dt { text-align: left; }
</style>
