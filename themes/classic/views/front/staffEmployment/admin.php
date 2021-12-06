<?php
$this->breadcrumbs=array(
	'Staff Employments'=>array('index'),
	'Manage',
);

/* $this->menu=array(
array('label'=>'List StaffEmployment','url'=>array('index')),
array('label'=>'Create StaffEmployment','url'=>array('create')),
); */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('staff-employment-grid', {
data: $(this).serialize()
});
return false;
});
");


$criteria=new CDbCriteria;
$criteria->addCondition("type = 'BASIS'");

$criteria1=new CDbCriteria;
$criteria1->addCondition("type = 'POSITION'");
$criteria1->order = "content ASC";


$criteria2=new CDbCriteria;
$criteria2->addCondition("type = 'LEAVEGROUP'");
$criteria2->order = "content ASC";


$criteria3=new CDbCriteria;
$criteria3->addCondition("type = 'DEPARTMENT'");
$criteria3->order = "content ASC";

$criteria4=new CDbCriteria;
$criteria4->addCondition("type = 'DIVISION'");
$criteria4->order = "content ASC";

$criteria5=new CDbCriteria;
$criteria5->addCondition("type = 'COMPANY'");
$criteria5->order = "content ASC";
?>

<h3>Manage Staff</h3>

<div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('StaffEmployment/create');?>">Create Staff</a></li>
    <li><a href="<?php echo Yii::app()->createUrl('ContentTable/createtype', array('type'=>'position'));?>">Create Position</a></li>
   
  </ul>
</div>
<?php if(Yii::app()->user->checkAccess('eLeave Admin')){ ?>
<div class="btn-group pull-left">
<button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    Export <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('StaffEmployment/export');?>">All staff</a></li>
    
  </ul>
</div>
<?php } ?>
<div class="btn-group pull-right">
<a href="<?php echo Yii::app()->createUrl('StaffEmployment/admin');?>" class="btn btn-primary">Reset</a>
</div>
<p>&nbsp;</p>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'staff-employment-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		//'id',
		//'staffCode',
		array(
			'name'=>'staffCode',
			'value'=>'$data->staffCode0->staffCode',
			'header'=> CHtml::encode($model->getAttributeLabel('staffCode')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		array(
			'name'=>'Fullname',
			'value'=>'$data->staffCode0->Fullname',
			'header'=> CHtml::encode($model->getAttributeLabel('Fullname')),
			'filterHtmlOptions'=>array('style'=>'width:20%'),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		array(
			'name'=>'chineseName',
			'value'=>'$data->staffCode0->chineseName',
			'header'=> CHtml::encode($model->getAttributeLabel('chineseName')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		//
		array(
			'name'=>'nickName',
			'value'=>'$data->staffCode0->nickName',
			//'header'=> CHtml::encode($model->getAttributeLabel('nickName')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		array(
			'name'=>'company',
			'value'=>'($data->department0&&$data->department0->companyID!="0")?$data->department0->company0->content:"N/A"',
			'header'=> CHtml::encode($model->getAttributeLabel('company')),
			'filter' => CHtml::dropDownList( 'StaffEmployment[company]', $model->department,
					CHtml::listData( ContentTable::model()->findAll( $criteria5 ), 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
		),
		array(
			'name'=>'department',
			'value'=>'($data->department0 && $data->department0->departmentID !=0)?$data->department0->department0->content:"N/A"',
			'header'=> CHtml::encode($model->getAttributeLabel('department')),
			'filter' => CHtml::dropDownList( 'StaffEmployment[department]', $model->department,
					CHtml::listData( ContentTable::model()->findAll( $criteria3 ), 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
		),
		array(
			'name'=>'division',
			'value'=>'($data->department0&&$data->department0->divisionID!="0")?$data->department0->division0->content:"N/A"',
			'header'=> CHtml::encode($model->getAttributeLabel('division')),
			'filter' => CHtml::dropDownList( 'StaffEmployment[division]', $model->division,
					CHtml::listData( ContentTable::model()->findAll( $criteria4 ), 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
		),
		array(
			'name'=>'mobile',
			'value'=>'$data->staffCode0->mobilePhone',
			'header'=> CHtml::encode($model->getAttributeLabel('mobile')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		array(
			'name'=>'HKID',
			'value'=>'$data->staffCode0->HKID',
			'header'=> CHtml::encode($model->getAttributeLabel('HKID')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		array(
			'name'=>'CWR',
			'value'=>'($data->staffCode0->CWRStaff0)?$data->staffCode0->CWRStaff0->cwr:""',
			'header'=> CHtml::encode($model->getAttributeLabel('CWR')),
			/* 'filter' => CHtml::dropDownList( 'HwMissingRecords[subjectId]', $model->subjectId,
					CHtml::listData( HwSubjects::model()->findAll( array( 'order' => 'id' ) ), 'id', 'displayName' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				), */
		),
		array(
			'name'=>'CWRExpiryDate',
			'value'=>'($data->staffCode0->CWRStaff0)?$data->staffCode0->CWRStaff0->cwrDate:""',
			'header'=> CHtml::encode($model->getAttributeLabel('CWRExpiryDate')),
			
		),
		array(
			'name'=>'WhiteCard',
			'value'=>'($data->staffCode0->CWRStaff0)?$data->staffCode0->CWRStaff0->whiteCard:""',
			'header'=> CHtml::encode($model->getAttributeLabel('WhiteCard')),
			
		),
		array(
			'name'=>'WhiteCardExpiryDate',
			'value'=>'($data->staffCode0->CWRStaff0)?$data->staffCode0->CWRStaff0->whiteCardDate:""',
			'header'=> CHtml::encode($model->getAttributeLabel('WhiteCardExpiryDate')),
			
		),
		array(
			'name'=>'greenCard',
			'value'=>'($data->staffCode0->CWRStaff0)?$data->staffCode0->CWRStaff0->greenCard:""',
			'header'=> CHtml::encode($model->getAttributeLabel('greenCard')),
			
		),
		array(
			'name'=>'greenCardExpiryDate',
			'value'=>'($data->staffCode0->CWRStaff0)?$data->staffCode0->CWRStaff0->greenCardDate:""',
			'header'=> CHtml::encode($model->getAttributeLabel('greenCardExpiryDate')),
			
		),
		array(
			//'name'=>'Email',
			'value'=>'$data->staffCode0->email',
			//'header'=> CHtml::encode($model->getAttributeLabel('staffCode')),
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
			'value'=>'date("Y-m-d",strtotime($data->startDate))',
			
		),
		array(
			'name'=>'probationEndDate',
			'value'=>'($data->probationEndDate=="")?"Not Set":date("Y-m-d",strtotime($data->probationEndDate))',
			
		),
		array(
			'name'=>'endDate',
			'value'=>'($data->endDate)?date("Y-m-d", strtotime($data->endDate)):""',
			
		),
		//'startDate',
		//'endDate',
		array(
			'name'=>'dob',
			'value'=>'$data->staffCode0->dob',
			
		),
		
		array(
			'name'=>'Basis',
			'value'=>'$data->basis->content',
			'filter' => CHtml::dropDownList( 'StaffEmployment[Basis]', $model->Basis,
					CHtml::listData( ContentTable::model()->findAll( $criteria ), 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
			//'header'=> CHtml::encode($model->getAttributeLabel('staffCode0.englishName')),
			
		),
		//'Basis',
		array(
			'name'=>'positionID',
			'value'=>'$data->position->content',
			'filter' => CHtml::dropDownList( 'StaffEmployment[positionID]', $model->positionID,
					CHtml::listData( ContentTable::model()->findAll( $criteria1 ), 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
			//'header'=> CHtml::encode($model->getAttributeLabel('staffCode0.englishName')),
			
		),
		array(
			'name'=>'Group',
			'value'=>'($data->AlternateGroup0->GroupName0)?$data->AlternateGroup0->GroupName0->content:""',
			'filter' => CHtml::dropDownList( 'StaffEmployment[Group]', $model->Group,
					CHtml::listData( ContentTable::model()->findAll( $criteria2 ), 'id', 'content' ),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
			//'header'=> CHtml::encode($model->getAttributeLabel('staffCode0.englishName')),
			
		),
		array(
			'name'=>'Alternate',
			'value'=>'($data->AlternateGroup1)?$data->AlternateGroup1->alternateGroupName:""',
			'filter' => CHtml::dropDownList( 'StaffEmployment[Alternate]', $model->Alternate,
					array(
						'0'=>'Every Saturday', 
						'1'=>'Group 1', 
						'2'=>'Group 2', 
						'3'=>'Group 3',
						'4'=>'Group 4',
						'99'=>'No Alternate'
					),
					array( 
						'empty' => 'Choose',
						'class'=>'form-control'
					)
				),
			//'header'=> CHtml::encode($model->getAttributeLabel('staffCode0.englishName')),
			
		),
		array(
			'name'=>'projectCode',
			'value'=>'$data->projectCode',
			
		),
		array(
			'name'=>'registeredTrade',
			'value'=>'$data->registeredTrade',
			
		),
		//'positionID',
array(

'class'=>'booster.widgets.TbButtonColumn',
'template'=>'{update}',
'buttons'=>array
          (
              'update' => array
              (
				//'label'=>'Waive Attendance',
                /*  'options'=>array(
					'title'=>'Waive Attendance',
					'onclick'=>'return confirm("Do you want to wave this record?");',
				), */
				 'url'=>'Yii::app()->createURL("StaffEmployment/update/", array("StaffCode"=>$data->staffCode))',
              ),
			 
             
          ),
),
),
)); ?>
