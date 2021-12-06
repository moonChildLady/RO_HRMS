<p>You have successfully enrolled the following:</p>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Subject Selection Program</h3>
	</div>
	<div class="panel-body">
<table class="table table-bordered">
<thead>
	<tr class="info">
		<th class="text-center">Class</th>
		<th class="text-center">Elective</th>
		<th class="col-xs-3 col-md-3 col-lg-3 text-center">1st Choice*</th>
		<th class="col-xs-3 col-md-3 col-lg-3 text-center">2nd Choice*</th>
		<th class="col-xs-3 col-md-3 col-lg-3 text-center">3rd Choice*</th>
	</tr>
</thead>
	<tr height="58px">
		<td rowspan="2" class="text-center vcenter"><b>Faith/Grace/Hope/Joy</b><br><?php echo $this->choicePosition($applModel[0]["pre"]);?></td>
		<td class="text-center vcenter"><b>X2</b></td>
		<?php for($i=0;$i<=2;$i++){ ?>
		<td class="vcenter"><?php echo $this->getSubSelection($applsubModel[$i]->choice)->sub_name; ?></td>
		<?php } ?>
	</tr>
	<tr height="58px">
		<td class="text-center vcenter"><b>X3</b></td>
		<?php for($i=3;$i<=5;$i++){ ?>
		<td class="vcenter"><?php echo $this->getSubSelection($applsubModel[$i]->choice)->sub_name; ?></td>
		<?php } ?>
	</tr>
	<tr height="58px">
		<td rowspan="2" class="text-center vcenter"><b>Love</b><br><?php echo $this->choicePosition($applModel[1]["pre"]);?></td>
		<td class="text-center  vcenter"><b>X2</b></td>
		<?php for($i=6;$i<=8;$i++){ ?>
		<td class="vcenter"><?php echo $this->getSubSelection($applsubModel[$i]->choice)->sub_name; ?></td>
		<?php } ?>
	</tr>
	<tr height="58px">
		<td class="text-center vcenter"><b>X3</b></td>
		<?php for($i=9;$i<=11;$i++){ ?>
		<td class="vcenter"><?php echo $this->getSubSelection($applsubModel[$i]->choice)->sub_name; ?></td>
		<?php } ?>
	</tr>
	<tr height="58px">
		<td class="text-center vcenter"><b>Peace</b><br><?php echo $this->choicePosition($applModel[2]["pre"]);?></td>
		<td class="text-center vcenter"><b>X3</b></td>
		<?php for($i=12;$i<=14;$i++){ ?>
		<td class="vcenter"><?php echo $this->getSubSelection($applsubModel[$i]->choice)->sub_name; ?></td>
		<?php } ?>
	</tr>
</table>
</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Information of Parent</h3>
	</div>
	<div class="panel-body">
		<p><b><?php echo Yii::t('ssp','parentname');?></b> <?php echo $applModel['0']['parentName']?></p>
		<p><b><?php echo Yii::t('ssp','phoneno');?></b> 852-<?php echo $applModel['0']['phoneNo']?></p>
		<p><b><?php echo Yii::t('ssp','date');?></b> <?php echo $applModel['0']['appdate']?></p>

	</div>
</div>
<p class="text-center"><a href="<?php echo  Yii::app()->createUrl("appl/enroll")?>" class="btn btn-primary" role="button">Edit</a></p>
