<?php
if($model[1]==1){
	$sessionDateEng = "25 November 2017 (Saturday)";
	$sessionDateChi = "<span class='eng'>2017</span>年<span class='eng'>11</span>月<span class='eng'>25</span>日（星期六）";
}else{
	$sessionDateEng = "26 November 2017 (Sunday)";
	$sessionDateChi = "<span class='eng'>2017</span>年<span class='eng'>11</span>月<span class='eng'>26</span>日（星期日）";
	
}
?>
<head><style>.eng{font-family: Verdana;} .chi{font-family: "新細明體";}</style></head>

<div class="eng">
<p>Please do not reply to this email.</p>
<p class="chi">請勿回覆此電郵。</p>
<p style="text-align:right">Reference No.: <span class="chi">參考編號：</span><span class="eng" style="font-size:20px"><?php echo substr($model[0],0,4);?></span><span class="eng"><?php echo substr($model[0],4,6);?></span></p>

<p class="eng">Dear Parent,</p>
<p class="eng">We are pleased to inform you that your application for the <b>S1 Experiential Learning Programme</b> has been successful.</p>
<p class="eng">Below are the details of your allocation.</p>

<table width="100%" cellspacing="0" cellpadding="5" style="border: 1px solid;">
	<tr class="eng">
		<td width="30%">Date:</td>
		<td width="70%"><b><?php echo $sessionDateEng;?></b></td>
		</tr>
		<tr class="eng">
			<td>Reporting Time:</td>
				<td><b><u>1:45 - 2:00 p.m.</u></b></td>
		</tr>
		<tr class="eng">
			<td>Reporting Venue:</td>
			<td><b>Room 501, 5/F</b></td>
		</tr>
		<tr class="eng">
			<td>Activity Time:</td>
			<td>2:15 - 4:00 p.m.</td>
		</tr>
		</table>

<p class="eng">Your child must bring along his / her <b><u>student ID card or student handbook</u></b> and <u><b>a printout of this email</b></u> to the reporting venue during the reporting time.</p>
<p class="eng">Remarks:</p>
<p class="eng">1. The above offer is not transferrable.<br>
2. <b>Late registration will <u>NOT</u> be accepted and the concerned student's application shall be regarded as disqualified.</b><br>
3. Students attending the above program should <b><u>bring along his / her stationery</u></b>.</p>


<p class="eng">Should you have any enquiries, please contact the General Office at 2345 4567.</p>
<p class="eng">Thank you for your attention.</p>
<p class="eng">&nbsp;</p>
<p class="eng">Regards,<br>Stewards Pooi Kei College</p>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>

<div class="chi">
<p>親愛的家長：</p>
<p>貴子女已被抽中參加本校之<b>中一學習體驗活動</b>，詳情如下：</p>
<table width="100%" cellspacing="0" cellpadding="5" style="border: 1px solid;">
<tr class="chi">
	<td width="30%">日期：</td>
	<td width="70%"><b><?php echo $sessionDateChi;?></b></td>
</tr>
<tr class="chi">
	<td>報到時間：</td>
	<td><b>下午 <span class="eng">1:45 - 2:00</span></b></td>
</tr>
<tr class="chi">
	<td>報到地點：</td>
	<td><b><span class="eng">5</span>樓<span class="eng">501</span>室</b></td>
</tr>
<tr class="chi">
	<td>活動時間：</td>
	<td>下午 <span class="eng">2:15 – 4:00</span></td>
	</tr>
</table>

<p>報到時請&nbsp;&nbsp;&nbsp;&nbsp;貴子女出示<b><u>學生證／學生手冊</u></b>及<b><u>本函（請自行列印）</u></b>。</p>
<p>備註：</p>
<p>
<span class="eng">1.</span> 活動名額不可轉讓。<br>
<span class="eng">2.</span> <b>參加者須準時報到，未能準時報到者將視作<u>放棄</u>論。</b></br>
<span class="eng">3.</span> 參加者須<b><u>帶備文具</u></b>。</p>
<p>如有查詢，請致電<span class="eng">2345 4567</span>與校務處聯絡。</p>

<p>&nbsp;</p>
<p>香港神託會培基書院</p>
<p>&nbsp;</p>
<p><span class="eng">School Address: 56 Siu Lek Yuen Road, Shatin, New Territories</span><br>學校地址：新界沙田小瀝源路<span class="eng">56</span>號</p></div>

