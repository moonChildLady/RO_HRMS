<?php
unset($criteria);
$criteria=new CDbCriteria;
$criteria->order = "contractID ASC";
$StarSystem = StarSystem::model()->findAll($criteria);

foreach($StarSystem as $i=>$locationName){
	//$locationArray[$locationName->contractID] = $locationName->shortCode;
	$show[] = $locationName->shortCode." = ".$locationName->displayName;
}

?>


    <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Date</h3>
  </div>
  <div class="panel-body">
    
    <?php 
    $this->widget(
    'booster.widgets.TbDatePicker',
    array(
        'name' => 'viewdate',
		'options'=>array(
			'format' => 'yyyy-mm',
			'startView'=>'2',
			'minViewMode'=>'1',
			
		),
        'htmlOptions' => array(
			'class'=>'col-md-4',
			'viewformat' => 'yyyy-mm',
			'id'=>'attendanceDate',
			
			
		),
    )
);
    ?>
    <a href="" id="attendanceDateLink" class="btn btn-primary">View</a>
  </div>
</div>

<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Personal Attendance Records</h3>
  </div>
  <div class="panel-body">

    <p><?php echo implode(", ",$show);?></p>
    

<?php 
$countAttendance = true;
$date = Yii::app()->request->getParam('date', date('Y-m'));
$datetime2 = new DateTime($date);
$period = new DatePeriod(new DateTime($date),new DateInterval('P1D'),$datetime2->modify('+1 month'));
?>  
  
  <div class="row">
  	<div class="col-md-12">
  		<div class="table-responsive">
  			<table class="table table-bordered">
				<tr>
					<th width="15%">Date</th>
					<th width="5%">In/Out</th>
					<th width="15%">Record Time</th>
					<th>Remarks</th>
					<th width="20%">Leave Application</th>
					<th width="40%">Reasons</th>
					<th>-</th>
				</tr>
  				<?php foreach($period as $i=>$date){ 
				unset($criteria);
				$criteria = new CDbCriteria;
				$criteria->addCondition("staffCode = :staffCode");
				$criteria->addCondition("DATE_FORMAT(timeRecord, '%Y-%m-%d') = :timeRecord");
				$criteria->params = array(
					':staffCode'=>$staffCode,
					':timeRecord'=>date('Y-m-d', strtotime($date->format('Y-m-d')))
				);
				$AttendanceRemarks = AttendanceRemarks::model()->find($criteria);
				
				
				?>
  				<tr>
  					<td rowspan="2">
  						<?php echo $date->format('Y-m-d (D)');?>
  						<?php 
	  						$criteria4 = new CDbCriteria;
		$criteria4->addCondition("staffCode = :staffCode");
		$criteria4->params = array(
			':staffCode'=>$staffCode
		);
		$alternateGroup = AlternateGroup::model()->find($criteria4);
		unset($criteria4);
		
		
		$criteria4 = new CDbCriteria;
		$criteria4->addCondition("groupID = :groupID");
		$criteria4->params = array(
			':groupID'=>$alternateGroup->groupID
		);
		$StaffGroup = StaffGroup::model()->find($criteria4);
		
		$criteria1 = new CDbCriteria;
		$criteria1->with = array('holidays');
		$criteria1->addCondition("holidays.eventDate = :eventDate");
		$criteria1->addCondition("groupName = :groupName");
		$criteria1->params = array(
			':eventDate'=>$date->format('Y-m-d'),
			//':groupID'=>$StaffEmployment->Basis,
			':groupName'=>$StaffGroup->groupName,
			//':staffCode'=>Yii::app()->user->getState('staffCode')
			
		);
		//$criteria1->group = 'eventDate';
		$isholiday = HolidaysGroup::model()->find($criteria1);
	  	if($isholiday){					
  						?>
  				<p class="text-danger"><b>Public Holiday</b></p>
  				<?php } ?>
  					</td>
  					<td>In</td>
  					<td>
  					<?php
  					//$startTime =  $this->findStaffTimeslot($staffCode, $date->format('Y-m-d'));
  					$clockintime = $this->isFirstClockIn($staffCode, $date->format('Y-m-d'));
  					
  					
  					
  					
  					
  					if($clockintime){
						Yii::log($clockintime->timeRecord);
  					$startTime =  $this->findStaffTimeslot($staffCode, $clockintime->timeRecord);
					if(isset($startTime[0])){
					
  			$datetime1 = new DateTime($startTime[0]);
			$datetime2 = new DateTime(date("H:i:s", strtotime($clockintime->timeRecord)));
			$interval = $datetime1->diff($datetime2);
			$clockin = date("H:i:s", strtotime($clockintime->timeRecord));
			$clockin .= "(";
			$clockin .= (empty($startTime[0]))?"":$startTime[0];
			$clockin .= ")";
			$clockin .=  "<br>[";
			$clockin .= $this->findLocation($clockintime->deviceID);
			$clockin .= "]";
	  					echo $clockin;
			}
  					}else{
  					
  						if(date('Y-m-d')==$date->format('Y-m-d')){
	  						//echo "<span class='missingRecord'></span>";
  						}
  					
						echo "-";
					}
  					//->timeRecord;
  					?>
  					</td>
  					<td>
	  					<?php 
	  					if($clockintime && isset($startTime[0])){
						$mins = $interval->format('%h')*60+$interval->format('%i');
	  					if($startTime[0] < date("H:i:s", strtotime($clockintime->timeRecord)) && $mins > 0){ ?>
	  					<span class="missingRecord"></span>
	  					Late<br><?php 
						
						
						echo $mins.' Min(s)';
						?>
	  					<?php }else{ ?>
	  					-
	  					<?php } }else{ ?>
	  					-
	  					<?php } ?>
  					</td>
  					<td rowspan="2">
	  					<?php 
		  					$criteria = new CDbCriteria;
		  					$criteria->addCondition("staffCode = :staffCode");
		  					$criteria->addCondition("status = :status");
		  					$criteria->addCondition(":date between startDate and endDate");
		  					$criteria->params = array(
		  						':staffCode'=>$staffCode,
		  						':status'=>'ACTIVE',
		  						':date'=>$date->format('Y-m-d')
		  					);
		  					$LeaveApplication = LeaveApplication::model()->find($criteria);
	  					?>
	  					<?php
	if($LeaveApplication){
	?>
	Ref.: <a href="<?php echo Yii::app()->createURL('leaveApplication/view/', array('id'=>$LeaveApplication->id));?>" target="_blank">
	<?php 
	echo $LeaveApplication->refNo;
	?></a>
	<br>
	Type: <?php echo $LeaveApplication->reason->content; ?>
	<br>From: <?php 
	echo $LeaveApplication->StartDateSlot;
	?><br>
	To:  <?php 
	echo $LeaveApplication->EndDateSlot;
	?><br>
	<?php echo $LeaveApplication->ApprovalStatus;?> 
	<?php }else{ ?>
	-
	<?php } ?>
  					</td>
					<td rowspan="2">
						<p id="remark_<?php echo $date->format('Y-m-d');?>"><?php
						 
						 if($AttendanceRemarks){
						 	if($AttendanceRemarks->reasonID!=""){
							 $reasonContent = ContentTable::model()->findByPK($AttendanceRemarks->reasonID);
							 echo $reasonContent->content."<br>".nl2br($AttendanceRemarks->remark);
							 }else{
								 echo nl2br($AttendanceRemarks->remark);
							 }
						}else{
							echo "-";
						}
						?></p>
					</td>
					
  					<td rowspan="2">
					<a id="a_<?php echo $date->format('Y-m-d');?>" class="btn btn-primary <?php echo ($AttendanceRemarks)?"disabled":"";?>" data-toggle="modal" data-target="#myModal" data-content="<?php echo ($AttendanceRemarks)?nl2br($AttendanceRemarks->remark):"";?>" data-staffcode="<?php echo $staffCode;?>" data-date="<?php echo $date->format('Y-m-d');?>">
				<span class=" glyphicon glyphicon-pencil" aria-hidden="true"></span>
			</a> 					
  					</td>
  				</tr>
  				<tr>
  					<td>Out</td>
  					<td>
  					<?php
  					$clockouttime = $this->fristClockOut($staffCode, $date->format('Y-m-d'));
  					
  					if($clockouttime){
  					
  					$clockout = date("H:i:s", strtotime($clockouttime->timeRecord));
			$clockout .= "(";
			$clockout .= (empty($startTime[1]))?"":$startTime[1];
			$clockout .= ")";
			$clockout .=  "<br>[";
			$clockout .= $this->findLocation($clockouttime->deviceID);
			//$clockout .= $clockintime->deviceID;
			$clockout .= "]";
  					
	  					echo $clockout;
  					}else{
  						if(date('Y-m-d') == $date->format('Y-m-d')){
	  						//echo "<span class='missingRecord'></span>";
  						}
						echo "-";
					}
  					//->timeRecord;
  					?>
  					</td>
  					<td>
	  					<?php
	  					
	  					if($clockouttime && isset($startTime[1])){
	  					
	  					if($startTime[1] > date("H:i:s", strtotime($clockouttime->timeRecord))){ 
						
		  					$datetime1 = new DateTime($startTime[1]);
			$datetime2 = new DateTime(date("H:i:s", strtotime($clockouttime->timeRecord)));
			$interval = $datetime1->diff($datetime2);
		  					
		  					
	  					?>
	  	<span class="missingRecord"></span>
		Early	<?php echo $interval->format('%h.%I Hr(s)'); ?>
	<?php
		}else{
		
		
		$datetime1 = new DateTime($startTime[1]);
		$datetime2 = new DateTime(date("H:i:s", strtotime($clockouttime->timeRecord)));
		$interval = $datetime1->diff($datetime2);
		$diff = $interval->format('%h');
		
		
		
		
		
		if($diff >= 1){ 
			echo $interval->format('OT<br>%h.%I Hr(s)');			
			
		}else{
			echo "-";
		}
		
	  	} }else{
		  	echo "-";
	  	}
	  			?>
	  					
  					</td>
  				</tr>
  				<?php } ?>
  				
  				
  			</table>
  		</div>
  	</div>
	
  	
  </div>
  
  
   </div> 
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Resasons</h4>
      </div>
      <div class="modal-body">
		        <form id="remarkFrom">
         
			<!--attendanceRemarkStaff-->
			<div class="form-group">
				<label for="inputEmail3" class="control-label">Please specify</label>
					<select class="form-control" id="reasonDropdwon" name="reason">
					<option value="0">Please Chooses</option>
				<?php foreach($ContentTable as $j=>$reason){ ?>
					<option value="<?php echo $reason->id;?>"><?php echo $reason->content;?></option>
				<?php } ?>
					</select>
			</div>
			<div class="form-group" id="remarkGroup">
				<label for="inputEmail3" class="control-label">Remark</label>
					
					 <textarea class="form-control" id="message-text" rows="5" name="remark"></textarea>
			</div>

		  <input type="hidden" value="" name="staffcode" id="staffcode">
		  <input type="hidden" value="" name="date" id="date">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--a class="btn btn-primary" id="saveRemarkBtn">Save</a-->
		<?php echo CHtml::ajaxLink('Save', 
			Yii::app()->createURL('AttendanceRemarks/CreateRemarkPersonal'),
			array(
				'dataType'=>'json',
                'type' => 'post',
				'beforeSend'=>'js:function(){
					var reasonVal = $("#reasonDropdwon").val();
					if(reasonVal==0){
						alert("Please choose the reason!");
						return false;
					}
					
					if(reasonVal=="112" || reasonVal=="118" || reasonVal=="119"){
						if($("#message-text").val() == ""){
							alert("Please input the remark!");
							$("#message-text").focus();
							return false;
						}
					}
				}',
				"data"=>'js:$("#remarkFrom").serialize()',
				//'data'=>'js:{staffcode:$("#staffcode").val(),date:$("#date").val()}',
				'success'=>'js:function(data,status){
					if(data.remark==""){
						//$("#remark_"+data.date).html("-");
						$("#remark_"+data.date).html(data.reason);
					}else{
                    	$("#remark_"+data.date).html(data.reason+"<br>"+data.remark.nl2br());
					}
                    //$("#a_"+data.date).attr("data-content", data.remark.nl2br());
                    $("#myModal").modal("hide");
					$("#myModal").on("hidden.bs.modal", function (e) {
						$("#remark_"+data.date).fadeOut().fadeIn();
						$("#a_"+data.date).addClass("disabled");
					});
					

                }'
			),
			array('class'=>'btn btn-primary')
			); ?>
		<?php /* echo CHtml::ajax(array(
            'url'=>array('classroom/update'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)"
			)); */?>
      </div>
    </div>
  </div>
</div>
<script>
String.prototype.nl2br = function()
{
    return this.replace(/\n/g, "<br />");
}
String.prototype.br2nl = function()
{
    return this.replace(/<br ?\/?>/g, "");
}	
$(function(){


$(".missingRecord").closest('td').addClass('danger');
//$(".missingRecord").closest('td').siblings('td').addClass('danger');

$('#attendanceDate').datepicker({
    startView: 1,
    minViewMode: 1,
	viewformat:'yyyy-mm',
	format:'yyyy-mm',
	
});

$("#remarkGroup").hide();

$("#reasonDropdwon").change(function(){
	var value = $(this).val();
	if(value=="112" || value=="118" || value=="119"){
		$("#remarkGroup").show();
	}else{
		$("#remarkGroup").hide();
	}
});


var date = "<?php echo Yii::app()->request->getParam('date', date('Y-m'));?>";
$("#attendanceDate"	).val(date);
var currentUrl = '<?php echo Yii::app()->createURL('AttendanceRecords/viewAttendance');?>'+'/?date='+date;

$("#attendanceDateLink").attr('href', currentUrl);
	
$("#attendanceDate").change(function(){
	
//console.log("1");
var currentUrl = '<?php echo Yii::app()->createURL('AttendanceRecords/viewAttendance');?>'+'/?date='+$(this).val();

$("#attendanceDateLink").attr('href', currentUrl);


});


$('#myModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  //var title = button.data('title') // Extract info from data-* attributes
  //var content = button.data('content') // Extract info from data-* attributes
  var date = button.data('date') // Extract info from data-* attributes
  var staffcode = button.data('staffcode') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  //modal.find('.modal-title').text('Remark for ' + title);
  //modal.find('.modal-body textarea').val(content.br2nl());
  modal.find('.modal-body input[name=staffcode]').val(staffcode);
  modal.find('.modal-body input[name=date]').val(date);
  $("#reasonDropdwon").val(0);
  $("#remarkGroup").hide();
  
  <?php /*
echo CHtml::ajax(array(
            'url'=>Yii::app()->createURL('AttendanceRemarks/getRemarkPersonal'),
            'data'=> "js:{staffcode:staffcode,date:date}",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"js:function(data,status){
				modal.find('.modal-body textarea').val(data.remark.br2nl());
			}"
	));
*/?>
  //console.log(content);
});
});
</script>
<style>
.red{
	
}
</style>	