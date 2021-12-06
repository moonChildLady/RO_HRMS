
<!-- Latest compiled and minified CSS -->


<p>Dear colleagues,</p>

<p>Please find the following table for your information. Thank you for your attention. </p>

<p><?php echo $today;?> <?php echo Controller::getWeekDay($today, "WD");?></p>


<table class="common_table_list" style="border: 1px solid #CCCCCC;border-collapse: separate;border-spacing: 0;margin: 0 auto;width: 100%;">
<thead>
<tr>
<th style="background-color: #A6A6A6;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;color: #FFFFFF;font-weight: normal;margin: 0;padding: 5px 3px;text-align: left;">Period</th>
<th style="background-color: #A6A6A6;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;color: #FFFFFF;font-weight: normal;margin: 0;padding: 5px 3px;text-align: left;">From</th>
<th style="background-color: #A6A6A6;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;color: #FFFFFF;font-weight: normal;margin: 0;padding: 5px 3px;text-align: left;">To</th>
<th style="background-color: #A6A6A6;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;color: #FFFFFF;font-weight: normal;margin: 0;padding: 5px 3px;text-align: left;">Location</th>
<th style="background-color: #A6A6A6;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;color: #FFFFFF;font-weight: normal;margin: 0;padding: 5px 3px;text-align: left;">Item/Qty</th>
<th style="background-color: #A6A6A6;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;color: #FFFFFF;font-weight: normal;margin: 0;padding: 5px 3px;text-align: left;">Remarks</th>
<th style="background-color: #A6A6A6;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #CCCCCC;color: #FFFFFF;font-weight: normal;margin: 0;padding: 5px 3px;text-align: left;">Booked/Used by</th>

</tr>
</thead>
<tbody>
<?php if(count($model) > 0) { ?>

<?php foreach($model as $i=>$detail) { 
$start = new DateTime($detail->Date.$detail->sessionTimeStart);

$end = new DateTime($detail->Date.$detail->sessionTimeEnd);

//if($start <= $begin && $begin <= $end){

?>
<tr>
	<td nowrap="" rowspan="1" style="background-color: #FFFFFF;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #F1F1F1;margin: 0;padding: 5px 3px;vertical-align: top;"><?php echo $detail->sessionName;?></td>
	<td nowrap="" rowspan="1" style="background-color: #FFFFFF;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #F1F1F1;margin: 0;padding: 5px 3px;vertical-align: top;"><?php echo $start->format('H:i')?></td>
	<td nowrap="" rowspan="1" style="background-color: #FFFFFF;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #F1F1F1;margin: 0;padding: 5px 3px;vertical-align: top;"><?php echo $end->format('H:i'); ?></td>
	<td nowrap="" rowspan="1" style="background-color: #FFFFFF;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #F1F1F1;margin: 0;padding: 5px 3px;vertical-align: top;"><?php echo $detail->bkLocation->location; ?></td>
	<td nowrap="" rowspan="1" style="background-color: #FFFFFF;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #F1F1F1;margin: 0;padding: 5px 3px;vertical-align: top;"><?php echo $detail->bkItem->Item.", ".$detail->quantity; ?></td>
	<td nowrap="" rowspan="1" style="background-color: #FFFFFF;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #F1F1F1;margin: 0;padding: 5px 3px;vertical-align: top;"><?php echo ($detail->remark=="")?"-":$detail->remark;?></td>
	<td nowrap="" rowspan="1" style="background-color: #FFFFFF;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #F1F1F1;margin: 0;padding: 5px 3px;vertical-align: top;"><?php echo $detail->usedby0->nickName; ?></td>
</tr>

<?php } ?>

<?php }else{ ?>
<tr>
	<td nowrap="" colspan="7" style="background-color: #FFFFFF;border-bottom: 1px solid #CCCCCC;border-right: 1px solid #F1F1F1;margin: 0;padding: 5px 3px;vertical-align: top;text-align:center">There is no booking record at this moment.</td>
</tr>
<?php } ?>
</tbody>
 </table>
<p>For more details, please click <a href="http://portal.spkc.edu.hk:8080/bKDetails/Mode/kiosk" target="blank">here</a>.</p>
<p>Best regards,<br>
Booking Administrator</p>

<p><a href="http://www.spkc.edu.hk/disclaimer/">SPKC Disclaimer</a></p>
