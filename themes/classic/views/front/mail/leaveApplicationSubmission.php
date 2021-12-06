<head><style>.eng{font-family: Verdana;} .chi{font-family: "新細明體";}</style></head>
<body class="eng">
<p class="eng">Dear Colleague,</p>

<p>The following leave application has been submitted successfully. Thank you.</p>

<table width="100%" cellspacing="0" cellpadding="5" border="1" style="border: 1px solid;">
	<tr class="eng">
		<td width="30%">Ref No.:</td>
		<td width="70%"><a href="<?php echo Yii::app()->createAbsoluteUrl('LeaveApplication/viewApproval',array('id'=>$model->id));?>" target="_blank"><?php echo $model->refNo;?></a></td>
	</tr>
	<tr class="eng">
		<td width="30%">Staff Code & Name:</td>
		<td width="70%"><?php echo $model->staffCode0->FullnamewithStaffCode;?></td>
	</tr>
	<tr class="eng">
		<td width="30%">Leave Duration:</td>
		<td width="70%"><?php echo date("Y-m-d", strtotime($model->startDate));?> [<?php echo $model->startDateType;?>] to <?php echo date("Y-m-d", strtotime($model->endDate));?> [<?php echo $model->endDateType;?>]<br><?php
			
			
			echo $this->clacDuration($model->id);
			?> Day(s)</td>
	</tr>
	<tr class="eng">
		<td width="30%">Reason:</td>
		<td width="70%"><?php echo strtoupper(nl2br($model->ReasonwithRemarks));?></td>
	</tr>
	
</table>

<p class="eng">Ray On Portal</p>
</body>