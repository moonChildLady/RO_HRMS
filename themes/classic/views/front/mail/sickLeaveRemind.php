<head><style>.eng{font-family: Verdana;} .chi{font-family: "新細明體";}</style></head>

<p class="eng">Dear Admin,</p>

<p class="eng">Please be aware that <?php echo $model->staffCode0->FullnamewithStaffCode;?> only has <?php echo $remaining;?> day(s)' sick leave left in this year.</p>

<table class="eng" width="100%" cellspacing="0" cellpadding="5" border="1" style="border: 1px solid;">
	
	<tr class="eng">
		<td width="30%">Staff Code & Name:</td>
		<td width="70%"><?php echo $model->staffCode0->FullnamewithStaffCode;?></td>
	</tr>
	
	<tr class="eng">
		<td width="30%">Sick Leave Balance:</td>
		<td width="70%"><?php echo $remaining;?> Day(s)</td>
	</tr>
	
	
</table>
<p class="eng">Ray On Portal</p>
