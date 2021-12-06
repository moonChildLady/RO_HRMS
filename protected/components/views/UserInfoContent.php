<table class="table table-bordered">
	<tr height="60">
		<td class="col-sm-2 text-center vcenter">
			<b><?php echo Yii::t('userinfo','studentid');?></b>
		</td>
		<td class="col-sm-4 text-center vcenter">
		<?php echo Yii::app()->user->regno;?>
		</td>
		<td class="col-sm-2 text-center vcenter">
			<b><?php echo Yii::t('userinfo','name');?></b>
		</td>
		<td class="col-sm-4 text-center vcenter">
		<?php echo Yii::app()->user->enName;?><br><span class="chi"><?php echo Yii::app()->user->chName;?></span>
		</td>
	</tr>
	<tr height="60">
		<td class="col-sm-2 text-center vcenter">
			<b><?php echo Yii::t('userinfo','classinfo');?></b>
		</td>
		<td class="col-sm-4 text-center vcenter">
		<?php echo Yii::app()->user->classinfo;?>
		</td>
		<td class="col-sm-2 text-center vcenter">
			<b><?php echo Yii::t('userinfo','gender');?></b>
		</td>
		<td class="col-sm-4 text-center vcenter">
		<?php echo Yii::app()->user->gender;?><!--br><span class="chi"><?php echo Yii::app()->user->gender=="M"?"男":"女";?></span-->
		</td>
	</tr>
</table>