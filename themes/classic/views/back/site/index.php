<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>


<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Online Enrollment</h3>
  </div>
  <div class="panel-body">
	<h4>Current Event(s) / Programme(s):</h4>
   
  <!--a href="<?php echo Yii::app()->createUrl('lwwSelection/enroll')?>" class="list-group-item">
    Learning Without Walls
  </a-->
  <div class="btn-group-vertical">
  <?php 
  if(count($model)> 0 ){
  foreach($model as $i=>$v){ ?>
  
  <div class="btn-group" role="group" >
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu<?php echo $i?>" data-toggle="dropdown" aria-expanded="false">
    <?php echo $v->event->eventName;?> (Application period: <?php echo $v->event->startDate;?> ~ <?php echo $v->event->endDate;?>)
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dropdownMenu<?php echo $i?>">
    <li role="presentation"><a role="menuitem" target="_blank" href="/<?php echo $v->event->url;?>">View</a></li>
    <li role="presentation"><a role="menuitem" href="<?php echo Yii::app()->createUrl('/'.$v->event->controller.'/admin');?>">Manage</a></li>
  </ul>
</div>

 
  <?php } }else{ ?>
	<p>
    None
  </p>
  <?php } ?>
</div>

<h4>Past Event(s) / Programme(s):</h4>
 <div class="list-group">
   <?php 
  if(count($model_past)> 0 ){
  foreach($model_past as $i=>$v){ ?>
  <a href="<?php echo Yii::app()->createUrl($v->event->url);?>" class="list-group-item disabled"><?php echo $v->event->eventName;?> (Application period: <?php echo $v->event->startDate;?> ~ <?php echo $v->event->endDate;?>)</a>
  <?php } }else{ ?>
	<a href="#" class="list-group-item disabled">
    None
  </a>
  <?php } ?>
  </div>
  </div>
</div>