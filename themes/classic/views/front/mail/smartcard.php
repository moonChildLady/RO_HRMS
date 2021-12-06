<?php 

$headertag = $model->Header;
$bodytag = str_replace("##URL##", Yii::app()->createAbsoluteUrl('DownloadFiles/file/'.md5($downloadModel->id)), $model->Body);
$bodytag = str_replace("##PASSWORD##", $downloadModel->password, $bodytag);
$bodytag = str_replace("##STARTDATE##", date("Y-m-d H:i", strtotime($downloadModel->start_date)), $bodytag);
$bodytag = str_replace("##ENDDATE##", date("Y-m-d H:i", strtotime($downloadModel->end_date)), $bodytag);
$footertag = str_replace("##USERNAME##", Yii::app()->user->enName, $model->Footer);
$footertag = str_replace("##EMAIL##", Yii::app()->user->email, $footertag);
echo $headertag.$bodytag.$footertag;
?>
<p><img src="<?php echo Yii::app()->createAbsoluteUrl('/images/image001.jpg');?>"></p>