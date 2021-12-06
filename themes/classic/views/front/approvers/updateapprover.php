<?php 

$criteria2 = new CDbCriteria;
//$criteria2->addCondition("staffCode != :staffCode");
$criteria2->params = array(
	//':staffCode'=>Yii::app()->user->getState('staffCode'),
);
$criteria2->order = "staffCode ASC";	
$staffs = Staff::model()->findAll($criteria2);


$criteria1 = new CDbCriteria;
$criteria1->addCondition("type = :type");
$criteria1->params = array(
	':type'=>'ELEAVE',
);
		
$commentIDs = ContentTable::model()->findAll($criteria1);

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'approvers-form',
	'enableAjaxValidation'=>false,
));	
?>

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Update <?php echo $staff->staffCode0->Fullname;?>'s Approver</h3>
  </div>
  <div class="panel-body">
  	<div class="table-responsive">
  			<table class="table table-bordered">
  				<tr>
  					<th>-</th>
  					<th>Approver Postion</th>
  					<th>Approver</th>
  				</tr>
  				<?php foreach($model as  $i=>$staff){ ?>
  				<input type="hidden" name="ApproverPostionOld[<?php echo $i;?>]" value="<?php echo $staff->position0->id;?>">
  				<input type="hidden" name="ApproverOld[<?php echo $i;?>]" value="<?php echo $staff->approver;?>">
  				<input type="hidden" name="model[<?php echo $i;?>]" value="<?php echo $staff->id;?>">
  				<tr>
  					<th>Approver <?php echo ($i+1);?> </th>
  					<td><?php echo $staff->position0->content;?></td>
  					<td>
	  					<?php
	  						$this->widget(
	  						'booster.widgets.TbSelect2',
    array(
        'name' => 'Approver['.$i.']',
        'data'=>CHtml::listData(($staffs), 'staffCode', 'FullnamewithStaffCode'),
        'val'=>$staff->approver,
        'options' => array(
            'placeholder' => 'Please choose',
            'width' => '100%',
        )
    )
);
	  					?>
  					</td>
  				</tr>
  				<?php } ?>
  				<?php
  					$total = count($model);
  					for($i=$total;$i<3;$i++){ 
  				?>
  				<tr>
  					<th>Approver <?php echo ($i+1);?> </th>
  					<td><?php
	  						$this->widget(
	  						'booster.widgets.TbSelect2',
    array(
        'name' => 'ApproverPostion['.$i.']',
        'data'=>CHtml::listData(($commentIDs), 'id', 'content'),
        //'val'=>$staff->position0->id,
        'options' => array(
            'placeholder' => 'Please choose',
            'width' => '100%',
        )
    )
);
	  					?></td>
  					<td>
	  					<?php
	  						$this->widget(
	  						'booster.widgets.TbSelect2',
    array(
        'name' => 'Approver['.$i.']',
        'data'=>CHtml::listData(($staffs), 'staffCode', 'FullnamewithStaffCode'),
        //'val'=>$staff->approver,
        'options' => array(
            'placeholder' => 'Please choose',
            'width' => '100%',
        )
    )
);
	  					?>
  					</td>
  				</tr>
  				<?php } ?>

  		</table>
  		<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Save',
		)); ?>
</div>
  	</div>
  </div>
</div>
<?php $this->endWidget(); ?>