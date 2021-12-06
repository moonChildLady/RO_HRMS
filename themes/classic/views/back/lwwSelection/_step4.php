<div class="well">
	<?php if($status){ ?>
	<h3 class="text-center">你已完成登記</h3>
	<?php if($model->saveMode == "DRAFT") { ?>
	<p class="text-center">提示:你所提交的是草稿,若你要提交,請按<a href="<?php echo Yii::app()->createUrl('lwwSelection/enroll')?>">此</a></p>
	<?php } ?>
	<?php } ?>
</div>