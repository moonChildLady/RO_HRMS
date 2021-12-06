<?php
$this->breadcrumbs=array(
	'Leave Applications'=>array('index'),
	'Manage',
);

/* $this->menu=array(
array('label'=>'List LeaveApplication','url'=>array('index')),
array('label'=>'Create LeaveApplication','url'=>array('create')),
); */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('leave-application-grid', {
data: $(this).serialize()
});
return false;
});
");

$criteria = new CDbCriteria;
$criteria->addCondition("type = :type");
$criteria->params = array(
	':type'=>'LEAVEREASON',
);
		
$reasonIDs = ContentTable::model()->findAll($criteria);

$criteria1 = new CDbCriteria;
$criteria1->addCondition("type = :type");
$criteria1->params = array(
	':type'=>'LEAVECOMMENT',
);
		
$commentIDs = ContentTable::model()->findAll($criteria1);
$type = Yii::app()->getRequest()->getParam("type", "all");



$criteria2 = new CDbCriteria;
$criteria2->addCondition("type = :type");
$criteria2->params = array(
	':type'=>'HRLEAVE',
);
		
$HRStatus = ContentTable::model()->findAll($criteria2);

?>

<h3>Manage Leave Applications <small><?php echo ($type=="notapproved")?"Not Approved":"All Records";?></small></h3>

<div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/create');?>">Leave Application</a></li>
    
   
   
  </ul>
  
  
</div>
<?php if(Yii::app()->user->checkAccess('eLeave Admin')){ ?>
<div class="btn-group pull-left">
<button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    Export <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/exportLanding');?>">Leave Application Records by staff</a></li>
    <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/ALHistory');?>">Leave Application Records by staff with details</a></li>
    <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/ExportAll');?>">All Leave Records</a></li>
	<li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/ExportLandingBalanceYear', array("year"=>2021));?>">Leave Balance Records (Start from 2021-01-01)</a></li>
	<li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/ExportLandingBalance4');?>">Leave Balance Records (Start from 2020-01-01)</a></li>
	 <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/ExportLandingBalance3');?>">Leave Balance Records (Start from 2019-01-01)</a></li>
	 <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/ExportLandingBalance');?>">Leave Balance Records (until to 2018-Dec-31)</a></li>
	
  </ul>
</div>
<?php } ?>
  <?php if(Yii::app()->user->checkAccess('Account Admin') || Yii::app()->user->checkAccess('eLeave Admin')) {?>
 
  <div class="btn-group pull-left">
  <button type="button" class="btn btn-warning dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    Management <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createURL('Holidays/admin');?>">Holidays</a></li>
    <li><a href="<?php echo Yii::app()->createURL('LeaveBalance/admin');?>">AL Balance</a></li>
	<li><a href="<?php echo Yii::app()->createUrl('LeaveApplicationApply/admin');?>">Application Period</a></li>
  </ul>
  
</div>
  <?php } ?>
 <div class="btn-group pull-left" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <a class="btn btn-warning <?php echo ($type=="notapproved")?"active":"";?>" href="<?php echo Yii::app()->createUrl('LeaveApplication/admin', array("type"=>"notapproved"));?>">Not Approved</a>
  </div>
  <div class="btn-group" role="group">
    <a class="btn btn-success <?php echo ($type=="notapproved")?"":"active";?>" href="<?php echo Yii::app()->createUrl('LeaveApplication/admin', array("type"=>"all"));?>">All Records</a>
  </div>
</div>  
<div class="btn-group pull-right">
<a href="<?php echo Yii::app()->createUrl('LeaveApplication/admin');?>" class="btn btn-primary">Reset</a>
</div>
<p>&nbsp;</p>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'leave-application-grid',
'dataProvider'=>$model->search($type),
'filter'=>$model,
'ajaxUpdate'=>false,
'afterAjaxUpdate' => 'reinstallDatePicker',
'rowCssClassExpression'=>'($data->status!="ACTIVE" || ($data->reasonID=="66" && $data->attachmentID==""))?"danger":""',
'columns'=>array(
		//'id',
		//'refNo',
		array(
		'name'=>'refNo',
		'type'=>'raw',
		'value'=>'CHtml::link("$data->refNo",array("ViewApproval", "id"=>$data->id))',
		),
		'staffCode',
		array(
			'name'=>'Fullname',
			'value'=>'$data->staffCode0->Fullname',
			'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		array(
			'name'=>'startDate',
			//'value'=>'($data->endDate)?date("Y-m-d", strtotime($data->endDate)):""',
			'value'=>'$data->StartDateSlot',
			'filter' => $this->widget(
    'booster.widgets.TbDatePicker',
    array(
		'model'=>$model,
		'value'=>$model->startDate,
        'name' => 'LeaveApplication[startDate]',
		
        'htmlOptions' => array(
			'class'=>'form-control'
			//'class'=>'col-md-4',
			    //'id'=>'date',
		),
		'options'=>array(
			'format' => 'yyyy-mm-dd',
			'viewformat' => 'yyyy-mm-dd',
			'autoclose'=>true,
			'clearBtn'=>true
			)
    ),true,false
)
		),
		array(
			'name'=>'endDate',
			//'value'=>'($data->endDate)?date("Y-m-d", strtotime($data->endDate)):""',
			'value'=>'$data->EndDateSlot',
			'filter' => $this->widget(
    'booster.widgets.TbDatePicker',
    array(
		'model'=>$model,
		'value'=>$model->endDate,
        'name' => 'LeaveApplication[endDate]',
		
        'htmlOptions' => array(
			'class'=>'form-control'
			//'class'=>'col-md-4',
			    //'id'=>'date',
		),
		'options'=>array(
			'format' => 'yyyy-mm-dd',
			'viewformat' => 'yyyy-mm-dd',
			'autoclose'=>true,
			'clearBtn'=>true
			)
    ),true,false
)
		),
		//'startDate',
		//'endDate',
		
		//'duration',
		array(
			'name'=>'reasonID',
			'type'=>'raw',
			//'value'=>'nl2br($data->ReasonwithRemarks)',
			'value'=>'$data->reason->content',
			'filter' => CHtml::dropDownList( 'LeaveApplication[reasonID]', $model->reasonID,
					CHtml::listData( $reasonIDs, 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
			
			
		),
		array(
			'name'=>'commentID',
			'type'=>'raw',
			'value'=>'($data->commentID!=null)?nl2br($data->CommentwithRemarks):""',
			'filter' => CHtml::dropDownList( 'LeaveApplication[commentID]', $model->commentID,
			CHtml::listData( $commentIDs, 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
			
			
		),
		//'reasonID',
		'createDate',
		array(
			'type'=>'html',
			'name'=>'ApprovalStatus',
			'value'=>'$data->ApprovalStatus',
			//'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			'filter' => "",
			'htmlOptions'=>array('style'=>'word-wrap: break-word;width:20%'),
			//'headerHtmlOptions'=>array('width'=>'100')
		),
		array(
			'name'=>'status',
			'value'=>'$data->status',
			//'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			'filter' => CHtml::dropDownList( 'LeaveApplication[status]', $model->status,
			array('ACTIVE'=>'Active', 'CANCEL'=>'Cancel'),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
		),
		array(
			'name'=>'HRStatus',
			'value'=>'($data->HRStatus==0)?"TBC":$data->HRStatus0->content',
			//'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			'filter' => CHtml::dropDownList( 'LeaveApplication[HRStatus]', $model->HRStatus,
			CHtml::listData( $HRStatus, 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
		),
		array(
			'name'=>'createdBy',
			'value'=>'$data->createdBy0->Fullname',
			//'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		array(
			'type'=>'raw',
			'name'=>'DurationDayLabel',
			'value'=>'($data->DurationDay)?$data->DurationDay:""',
			'filter' => "",
		),
		/* array(
			'type'=>'raw',
			'name'=>'LeaveBalanceLabel',
			'value'=>'$data->LeaveBalance',
		), */
		/*
		'reasonRemarks',
		'commentID',
		'commentRemarks',
		'attachmentID',
		
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
'template'=>'{view}<br>{update}<br>{cancelButton}<br>{osdButton}',

'buttons'=>array(
	'view'=>array(
	//'label'=>'...',     //Text label of the button.
    'url'=>'Yii::app()->createURL("LeaveApplication/ViewApproval", array("id"=>$data->id))',       //A PHP expression for generating the URL of the button.
    //'imageUrl'=>'...',  //Image URL of the button.
    //'options'=>array(), //HTML options for the button tag.
    //'click'=>'...',     //A JS function to be invoked when the button is clicked.
    //'visible'=>'leaveApplicationController::checkApprovalLogExist($data->id)!=true',   //A PHP expression for determining whether the button is visible.
	'options'=>array(
			'class' => 'btn btn-success'
		),
	),
	'update'=>array(
		'visible'=>'Yii::app()->user->checkAccess("eLeave Admin")',   //A PHP expression for determining whether the button is visible.
		'options'=>array(
			'class' => 'btn btn-primary'
		),
	),
	'cancelButton'=>array(
		'label'=>'Cancel',
		'visible'=>'Yii::app()->user->checkAccess("eLeave Admin")',   //A PHP expression for determining whether the button is visible.
		'url'=>'Yii::app()->createURL("LeaveApplication/delete", array("id"=>$data->id))',
		'click'=>'function(){return confirm("Are you sure to Cancel?");}',
		'options'=>array(
			'class' => 'btn btn-danger'
		),
	),
	'osdButton'=>array(
		'label'=>'Update OSD',
		'visible'=>'Yii::app()->user->checkAccess("eLeave OSD")',   //A PHP expression for determining whether the button is visible.
		'url'=>'Yii::app()->createURL("LeaveApplication/updateOSD", array("id"=>$data->id))',
		//'click'=>'function(){return confirm("Are you sure to Cancel?");}',
		'options'=>array(
			'class' => 'btn btn-primary'
		),
	),
),

),
),
)); ?>
<?php
/* function to re install date picker after filter the result. if you don’t use it then after filter the result calendar will not shown in filter box */
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
jQuery('#LeaveApplication_startDate').datepicker({'format':'yyyy-mm-dd','viewformat':'yyyy-mm-dd','autoclose':true,'language':'en','clearBtn':true});

jQuery('#LeaveApplication_endDate').datepicker({'format':'yyyy-mm-dd','viewformat':'yyyy-mm-dd','autoclose':true,'language':'en','clearBtn':true});
}
");
?>
