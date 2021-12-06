<?php if($showMenu){?>
<div class="row">
	<?php $this->widget('application.components.LwwMenu');?>
	<div class="col-sm-9">
	
	
	<p class="text-right"><small><a href="<?php echo Yii::app()->createUrl('lwwSelection/downloadPDFStudent');?>"><span class="glyphicon glyphicon-download"></span>Download PDF</a></small></p>
<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Learning Without Walls <?php echo $academicyear;?>/<?php echo $academicyear+1;?> Programme<br><span class="chi">學習無疆界</span>「<?php echo $academicyear;?>/<?php echo $academicyear+1;?>」<span class="chi">課程</span> 
	<?php } ?></h3>
	
		</div>
	<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-bordered table-striped">
			<thead>
				<th class="col-xs-1 col-sm-1 col-md-1">Priorities<br><span class="chi">選擇優先次序</span></th>
				  <th class="col-xs-1 col-sm-1 col-md-1">Programme Code<br><span class="chi">學習無疆界課程編號</span></th>
				  <th class="col-xs-4 col-sm-4 col-md-4">English Name of Selected Programme<br><span class="chi">已選擇課程英文名稱</span></th>
				  <th class="col-xs-4 col-sm-4 col-md-4">Chinese Name of Selected Programme<br><span class="chi">已選擇課程中文名稱</span></th>
				  <th class="col-xs-1 col-sm-1 col-md-1">Learning Location<br><span class="chi">學習地點</span></th>
				  <th class="col-xs-1 col-sm-1 col-md-1">Programme Fee<br>(HKD)<br><span class="chi">課程費用<br>(港幣)</span></th>
				</tr>
			</thead>
			<?php for($i=1;$i<=Yii::app()->params['maxSelect'];$i++){
				$attribute = 'ch'.sprintf("%02s",$i);
				if($model[$attribute]){
				$id = $model[$attribute];
				
			?>
            <tr>
				<td class="text-center"><?php echo $i;?></td>
				<td class="text-center"><?php echo $this->getprogrammeInfo($id)->programeId;?></td>
				<td><?php echo $this->getprogrammeInfo($id)->enName;?></td>
				<td><?php echo $this->getprogrammeInfo($id)->chName;?></td>
				<td><?php echo $this->getprogrammeInfo($id)->location;?></td>
				<td class="text-right"><?php echo $this->getprogrammeInfo($id)->formatedcost;?></td>
			</tr>
			<?php } } ?>
		</table>
		</div>
	</div>
</div>

<!--parent information-->
	<div class="panel panel-primary" >
	<div class="panel-heading">
		<h3 class="panel-title">Information of Parent<br><span class="chi">家長資料</span></h3>
	</div>
	<div class="panel-body">
	<table class="table table-bordered">
		<tr>
			<td class="col-xs-3 col-sm-3 col-md-3"><?php echo Yii::t('lwwenroll','parentName');?></td>
			<td><?php echo $model->parentName;?></td>
		</tr>
		<tr>
			<td class="col-xs-3 col-sm-3 col-md-3"><?php echo Yii::t('lwwenroll','SMS');?></td>
			<td><?php echo $model->SMS;?></td>
		</tr>
		<tr>
			<td class="col-xs-3 col-sm-3 col-md-3"><?php echo Yii::t('lwwenroll','email');?></td>
			<td><?php echo $model->email;?></td>
		</tr>
	</table>
	</div>
	</div>
	
	<!--parent information-->
	<div class="panel panel-primary" >
	<div class="panel-heading">
		<h3 class="panel-title">Declaration<br><span class="chi">聲明</span></h3>
	</div>
	<div class="panel-body">
		<p>I acknowledge the content of this form and I confirm that I will comply with the decisions made by the School regarding the enrollment result.</p>
		<p><?php if($model->TravelDoc == 'YES') { ?><?php echo str_replace('{$travldocDate}', $this->getGobleDate()['travldocDate'], Yii::t('lwwenroll','confirmation_travel_eng'));?><?php }else { ?> My child's travel documents (Hong Kong Identity Card, Passport and Re-entry Permit) are being renewed. <?php }?></p>
		<p><?php if($model->Born == 'HK') { ?>My child was born in Hong Kong.<?php }elseif($model->Born == 'OTHERS') { ?> My child was born overseas. <?php }else{ ?> My child was born in the Mainland China. <?php } ?></p>
		<p><?php if($model->Financial  == 'YES') { ?>I would like to apply for the School-based Financial Assistance Scheme. The attached is the complete form of Application for Financial Assistance in School Activities with all the required information.<?php } else { ?> I will not apply for the LEWOWA <?php echo $academicyear;?>/<?php echo $academicyear+1;?> Subsidy. I am able to afford the programme fee of my selected programmes.<?php } ?></p>
		
		<p>本人已知悉此表格內容，並承諾將依從學校的最終決定。 </p>
		<p><?php if($model->TravelDoc == 'YES') { ?><?php echo str_replace('{$travldocDate}', $this->getGobleDate()['travldocDate'], Yii::t('lwwenroll','confirmation_travel_chi'));?><?php }else { ?>本人現正更新敝子女之旅遊證件（香港身分證、護照及回鄉證）。 </p><?php } ?>
		<p><?php if($model->Born == 'HK') { ?>敝子女於香港出生。<?php }elseif($model->Born == 'OTHERS') { ?>敝子女於海外出生。 <?php }else{ ?>敝子女於中國內地出生。 <?php } ?></p>
		<p><?php if($model->Financial  == 'YES') { ?>本人欲申請「學習無疆界」課程資助計劃。附件為已填妥之學校活動資助計劃申請表及相關資料 / 文件。<?php } else { ?>本人無需申請任何資助，並本人有能力負擔所選課程之費用。<?php } ?></p>
	</div>
	</div>
<?php if($showMenu){?>	
		</div>
</div>
<?php } ?>