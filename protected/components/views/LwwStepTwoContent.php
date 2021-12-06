
<!--programme information-->
<div class="tab-pane fade" id="step2">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lww-selection-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableClientValidation'=>true,
	'enableAjaxValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'afterValidate'=>'js:yiiFix.ajaxSubmit.afterValidate'
    ),
	'htmlOptions'=>array(
	'class'=>'form-horizontal',
	'enctype'=>'multipart/form-data',
	//'onsubmit'=>"return false;",/* Disable normal form submit */
	)
)); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Learning Without Walls <?php echo $academicyear;?>/<?php echo $academicyear+1;?> Programme<br><span class="chi">學習無疆界</span>「<?php echo $academicyear;?>/<?php echo $academicyear+1;?>」<span class="chi">課程</span></h3>
		</div>
	<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th class="col-sm-2">Programme Code<br><span class="chi">課程編號</span></th>
				  <th class="col-sm-5">Programme Name<br><span class="chi">課程名稱</span></th>
				  <th class="col-sm-2">Learning Location<br><span class="chi">學習地點</span></th>
				  <th class="col-sm-1">Programme Fee (HKD)<br><span class="chi">課程費用</span></th>
				</tr>
			</thead>
			<?php foreach($programeList as $id=>$val) { ?>
            <tr>
				<td><?php echo $val->programeId;?></td>
				<td><?php echo $val->enName;?><br><?php echo $val->chName;?></td>
				<td><?php echo $val->location;?></td>
				<td><?php echo $val->cost;?></td>
			</tr>
			<?php } ?>
		</table>
		</div>
	</div>
</div>

<!--programme selection-->
	<div class="panel panel-primary" id="programeselect">
	<div class="panel-heading">
		<h3 class="panel-title">Programme Selection<br><span class="chi">課程選擇</span></h3>
	</div>
	<div class="panel-body">
	
<table class="table">
			<thead>
				<tr>
				  <th class="col-xs-2 col-sm-3 col-md-2">Priorities<br><span class="chi">選擇優先次序</span></th>
				  <th class="col-xs-10 col-sm-9 col-md-10">LEWOWA Programme<br><span class="chi">學習無疆界課程</span></th>
				</tr>
			</thead>
<?php for($i=1;$i<=Yii::app()->params['maxSelect'];$i++){ 
$attribute = 'ch'.sprintf("%02s",$i);
$id = $model[$attribute];
$programeModel = $this->getprogrammeInfo($id);
?>
<tr>
<td>
		<div class="form-group">
			<?php echo $form->labelEx($model,$attribute, array('class'=>'col-xs-2 col-sm-3 col-md-2 control-label')); ?>
			</td>
			<td>
			
				<?php echo $form->dropDownList(
					$model,
					$attribute, 
					CHtml::listData(ProgrameInfo::model()->findAll(), 'pid','fullname'),
					array(
					'empty'=>'Please Choose 請選擇', 
					'class'=>'form-control',
					'ajax' => array(
						'type'=>'POST', 
						'url'=>Yii::app()->createUrl('LwwSelection/loadinfo'), 
						//$this->createUrl('loadcities') if '$this' extends CController
						'update'=>'#'.$attribute.'_help', 
						//'success' => 'function(data){...handle the data in the way you want...}',
						'data'=>array('pid'=>'js:this.value'),
					)
					));
					?>
					<?php echo $form->error($model,$attribute); ?>
				
				<p class="help-block" id="ch<?php echo sprintf("%02s",$i);?>_help">
				<?php if(!$model->isNewRecord && count($programeModel) > 0) { ?>
				Learning Location <span class="chi">(學習地點)</span>:<?php echo (!$model->isNewRecord)?$programeModel['location']:"";?><br>Programme Fee <span class="chi">(課程費用)</span>:HK$ <?php echo (!$model->isNewRecord)?$programeModel['formatedcost']:"";?>
				<?php } ?>
				</p>
				
			</td>
		</div>
	</td>
</tr>
<?php } ?>
</table>
	</div>
	</div>
	
	<!--parent information-->
	<div class="panel panel-primary" >
	<div class="panel-heading">
		<h3 class="panel-title">Information of Parent<br><span class="chi">家長資料</span></h3>
	</div>
	<div class="panel-body">
	
		<div class="form-group">
			<?php echo $form->labelEx($model,'parentName', array('class'=>'col-xs-4 col-sm-4 col-md-3 control-label')); ?>
			<div class="col-sm-8 col-md-6 col-xs-8">
			<?php echo $form->textField($model,'parentName',array('class'=>'form-control ','placeholder'=>'Chan Tai Man')); ?>
			<?php echo $form->error($model,'parentName'); ?>
			</div>
		</div>
		
		<div class="form-group">
			<?php echo $form->labelEx($model,'SMS', array('class'=>'col-xs-4 col-sm-4 col-md-3 control-label')); ?>
			<div class="col-sm-8 col-md-6 col-xs-8">
			<div class="input-group">
				<div class="input-group-addon">852-</div>
					
					<?php echo $form->TelField($model,'SMS',array('class'=>'form-control ','placeholder'=>'67891234')); ?>
			
			</div>
			
			<?php echo $form->error($model,'SMS'); ?>
			</div>
		</div>
		
		<div class="form-group">
			<?php echo $form->labelEx($model,'email', array('class'=>'col-xs-4 col-sm-4 col-md-3 control-label')); ?>
			<div class="col-sm-8 col-md-6 col-xs-8">
			<?php echo $form->EmailField($model,'email',array('class'=>'form-control ','placeholder'=>'example@email.com')); ?>
			<?php echo $form->error($model,'email'); ?>
			</div>
		</div>
		
		
	</div>
	</div>
	
	<!--parent information-->
	<div class="panel panel-primary" >
	<div class="panel-heading">
		<h3 class="panel-title">Declaration<br><span class="chi">聲明</span></h3>
	</div>
	<div class="panel-body">
		<div class="checkbox">
		<label>
			<input type="checkbox" id="acknowledge"> <?php echo Yii::t('lwwenroll','acknowledge');?>
		</label>
		</div>
		
		<hr>
		<p><b><?php echo str_replace('{$travldocDate}', $getGobleDate['travldocDate'], Yii::t('lwwenroll','traveldoc'));?></b></p>
		
		<p><small>Remarks:
			<ul>
				<li><?php echo str_replace('{$travldocDate}', $getGobleDate['travldocDate'], Yii::t('lwwenroll','traveldocRemark_eng'));?></li>
			</ul>
		</small></p>
		
		<p class="chi"><small>備註：
			<ul>
				<li><?php echo str_replace('{$travldocDate}', $getGobleDate['travldocDate'], Yii::t('lwwenroll','traveldocRemark_chi'));?></li>
			</ul>
		</small></p>
		
		<div class="radio">
			<label>
				<?php
					$traveldoc = array(
					'YES'=>str_replace('{$travldocDate}', $getGobleDate['travldocDate'], Yii::t('lwwenroll','traveldocYes')), 
					'NO'=> Yii::t('lwwenroll','traveldocNo')
					);
					echo $form->radioButtonList($model,'TravelDoc',$traveldoc,
					array(
					'separator'=>'<br>',
					//'labelOptions'=>array('style'=>'display:inline'), // add this code
					));
				?>
			</label>
			<?php echo $form->error($model,'TravelDoc'); ?>
		</div>
		
		<p>&nbsp;</p>
		
		<p><b>Was your child born in Hong Kong? (Please check ONE of the following boxes.)<br>貴子女是否於香港出生？（請選取下列合適方格）</b></p>
		
		<div class="radio">
			<label>
				<?php
					$Born = array(
					'HK'=>'YES. My child was born in Hong Kong.<br><span class="chi">敝子女於香港出生。</span>', 
					'CH'=>'NO. My child was born in the Mainland China.<br><span class="chi">敝子女於中國內地出生。</span>',
					'OTHERS'=>'NO. My child was born overseas.<br>敝子女於海外出生。'
					);
					echo $form->radioButtonList($model,'Born',$Born,
					array(
					'separator'=>'<br>',
					//'labelOptions'=>array('style'=>'display:inline'), // add this code
					));
				?>
			</label>
			<?php echo $form->error($model,'Born'); ?>
		</div>
		
		<p>&nbsp;</p>
		
		<p><b>Would you like to apply for the School-based Financial Assistance Scheme (Financial Assistance in School Activities)? (Please check ONE of the following boxes.)<br>您需要申請學校活動資助計劃嗎？（請選取下列合適方格）</b></p>
		
		<p><small>Remarks:
			<ul>
				<li><?php echo Yii::t('lwwenroll','sfas1_eng');?></li>
				<li><?php echo str_replace('{$sfasDate}', $getGobleDate['sfasDate'], Yii::t('lwwenroll','sfas2_eng'));?></li>
			</ul>
		</small></p>
		
		<p class="chi"><small>備註：
			<ul>
				<li><?php echo Yii::t('lwwenroll','sfas1_chi');?></li>
				<li><?php echo str_replace('{$sfasDate}', $getGobleDate['sfasDate'], Yii::t('lwwenroll','sfas2_chi'));?></li>
			</ul>
		</small></p>
		
		<div class="radio">
			<label>
				<?php
					$Financial = array(
					'YES'=>'YES. I am not receiving any financial assistance provided by the government nor the School, and I would like to apply for the School-based Financial Assistance Scheme for LEWOWA. (Please click <a class="textsub_02" target="_blank" href="http://www.spkc.edu.hk/admissions/pdf/ApplicationforFinancialAssistance.pdf">\'Application for Financial Assistance in School Activities\')</a><br><span class="chi">本人家庭和子女現在並無接受任何政府或校方資助，本人欲申請「學習無疆界」課程資助計劃。(請按此超連結至： <a class="textsub_02" target="_blank" href="http://www.spkc.edu.hk/admissions/pdf/ApplicationforFinancialAssistance.pdf">「學校活動資助計劃申請表」)</a></span>',
					'NO'=>'NO. I am able to afford the programme fee of my selected programmes.<br><span class="chi">本人無需申請任何資助，並本人有能力負擔所選課程之費用。</span>'
					);
					echo $form->radioButtonList($model,'Financial',$Financial,
					array(
					'separator'=>'<br>',
					//'labelOptions'=>array('style'=>'display:inline'), // add this code
					));
				?>
			</label>
			<?php echo $form->error($model,'Financial'); ?>
		</div>
		
	</div>
	</div>
	<p class="text-right">
	<?php
	echo CHtml::ajaxSubmitButton('Next 下一步',
			Yii::app()->createUrl('lwwSelection/loadSelected'),
			array(
				'type'=>'POST',
				'data'=> 'js:$("#lww-selection-form").serialize()',
				'beforeSend'=>'js:yiiFix.ajaxSubmit.beforeSend("#lww-selection-form")',
				'success'=>'js:function(string){ 
					$("#loadPrograme").empty().append(string);
					 var nextId = $(".next_2").parents(".tab-pane").next().attr("id");
					$("[href=#"+nextId+"]").tab("show");
					$.scrollTo($(".navbar"), { duration: 0});
					//return false;
					}'           
				//'update'=>'#step3_programmetable', 
				),
				array(
				'class'=>'btn btn-primary next_2 disabled',
				));
?>
	<!--a class="btn btn-default next" href="#">Continue</a-->
	</p>
	<?php $this->endWidget();?>
	</div>

     



