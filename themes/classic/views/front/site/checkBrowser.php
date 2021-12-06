<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<div class="panel panel-primary" >
	<div class="panel-heading">
		<h3 class="panel-title">Reminder<br><span class="chi">提示</span></h3>
	</div>
	<div class="panel-body">
	<p>You are using <?php echo $browser?> <?php echo $version?><br><span class="chi">你正在使用</span> <?php echo $browser?> <?php echo $version?></p>
	<p>Parents and students are required to visit this website with a supported web browser on the PC. The School can support the following browsers:<br><span class="chi">若要完成網上申請，家長和學生必須使用電腦上支援的網頁瀏覽器瀏覽本網站。本校僅支援下列瀏覽器：</span>
			<ul>
				<li>Google Chrome</li>
				<li>Internet Explorer 9 or later <span class="chi">最新版本</span></li>
				<li>Mozilla Firefox 10 or later <span class="chi">最新版本</span></li>
				<li>Safari 5, 6 or later <span class="chi">最新版本</span></li>
			</ul>
	</p>
	</div>
</div>
