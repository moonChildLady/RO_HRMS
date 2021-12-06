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
$type = Yii::app()->getRequest()->getParam("type", "notapproved");
?>

<h3>Leave Approval <small><?php echo ($type=="notapproved")?"Not Approved":"Approved";?></small></h3>

<div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <a class="btn btn-warning <?php echo ($type=="notapproved")?"active":"";?>" href="<?php echo Yii::app()->createUrl('LeaveApplication/ManageApproval', array("type"=>"notapproved"));?>">Not Approved</a>
  </div>
  <div class="btn-group" role="group">
    <a class="btn btn-success <?php echo ($type=="notapproved")?"":"active";?>" href="<?php echo Yii::app()->createUrl('LeaveApplication/ManageApproval', array("type"=>"approved"));?>">Approved</a>
  </div>
</div>

<?php 


$this->widget('booster.widgets.TbGridView',array(
'id'=>'leave-application-grid',
'dataProvider'=>$model->manageApproval($type),
'filter'=>$model,
'afterAjaxUpdate' => 'reinstallDatePicker',
'columns'=>array(
		//'id',
		//'refNo',
		array(
		'name'=>'refNo',
		'type'=>'raw',
		'value'=>'CHtml::link("$data->refNo",array("viewApproval", "id"=>$data->id))',
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
			'class'=>'col-md-2',
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
			'value'=>'nl2br($data->ReasonwithRemarks)',
			'filter' => CHtml::dropDownList( 'LeaveApplication[reasonID]', $model->reasonID,
					CHtml::listData( $reasonIDs, 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
			
			
		),
		/*
array(
			'name'=>'commentID',
			'type'=>'raw',
			'value'=>'($data->commentID!=null):nl2br($data->CommentwithRemarks)?""',
			'filter' => CHtml::dropDownList( 'LeaveApplication[commentID]', $model->commentID,
			CHtml::listData( $commentIDs, 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
			
			
		),
*/
		//'reasonID',
		array(
			'type'=>'raw',
			'name'=>'ApprovalStatus',
			'value'=>'$data->ApprovalStatus',
			//'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			'filter' => ""	
		),
		'createDate',
		
		//'createdBy',
		
		/*
		'reasonRemarks',
		'commentID',
		'commentRemarks',
		'attachmentID',
		
		*/
array(
'class'=>'booster.widgets.TbButtonColumn',
'template'=>'{view}',
'buttons'=>array(
	'view'=>array(
	//'label'=>'...',     //Text label of the button.
    'url'=>'Yii::app()->createURL("LeaveApplication/ViewApproval", array("id"=>$data->id))',       //A PHP expression for generating the URL of the button.
    //'imageUrl'=>'...',  //Image URL of the button.
    //'options'=>array(), //HTML options for the button tag.
    //'click'=>'...',     //A JS function to be invoked when the button is clicked.
    //'visible'=>'leaveApplicationController::checkApprovalLogExist($data->id)!=true',   //A PHP expression for determining whether the button is visible.
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