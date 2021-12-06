<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h3>Hello, <?php echo Yii::app()->user->getState('fullname');?> (<?php echo Yii::app()->user->getState('staffCode');?>)</h3>

<div class="row">
	<div class="col-md-6 col-xs-12">
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Today Leave Record(s)</h3>
  </div>
  <div class="panel-body">
    <p><?php echo date("Y-m-d");?></p>
	<div class="table-responsive">
  <table class="table table-bordered table-hover">
	
	<tr>
		<th>Staff Code</th>
		<th>Name</th>
		<th>Time Slot</th>
		
	</tr>

	<?php foreach($leaveModel as $i=>$model){ 
	if(!$this->isRejected($model->id, $model->staffCode)){
	?>
	<tr>
		
		<td>
		<?php if(Yii::app()->user->checkAccess('eLeave Admin')) {?>
		<a href="<?php echo Yii::app()->createURL("LeaveApplication/ViewApproval", array("id"=>$model->id));?>" target="_blank"><?php echo $model->staffCode0->staffCode;?></a>
		<?php }else{ ?>
		<?php echo $model->staffCode0->staffCode;?>
		<?php } ?>
		</td>
		<td><?php echo $model->staffCode0->Fullname;?> (<?php echo $model->staffCode0->chineseName;?>)</td>
		<?php 
		
		$timeslot = "ALL";
		if(date('Y-m-d', strtotime($model->startDate)) == date('Y-m-d')) { 
			$timeslot = $model->startDateType;
			//
		}
		/* if( $model->endDate == date('Y-m-d') || $model->startDateType==$model->endDateType){
			$timeslot = $model->endDateType;
		}else{
			$timeslot = "ALL";
		} */
		if( date('Y-m-d', strtotime($model->endDate)) == date('Y-m-d')){
			$timeslot = $model->endDateType;
		}
		// || $model->endDate == date('Y-m-d')
		
		?>
		<td><?php echo $timeslot;?></td>
	</tr>
	<?php 
	} 
	} ?>
	
	  </table>
</div>
  </div>
</div>
</div>
<div class="col-md-6 xol-xs-12">


</div>
</div>
<div class="row">
	<div class="col-md-12 col-xs-12">
<div id='calendar'></div>
</div>
</div>
<script>

  $(document).ready(function() {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'listDay,basicWeek,month'
      },

      // customize the button names,
      // otherwise they'd all just say "list"
      views: {
        listDay: { buttonText: 'List Today' },
<?php if(Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('eLeave Admin')) { ?>
        basicWeek: { buttonText: 'Week' },
        month: { buttonText: 'Month' },
<?php } ?>
      },

      defaultView: 'listDay',
      //defaultDate: '2018-03-12',
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: false, // allow "more" link when too many events
	  displayEventTime: false,
	  //contentHeight: 600,
	  
      events: <?php echo $this->CalendarEvents();?>,
	  eventClick: function(event) {
    if (event.url) {
        window.open(event.url, "_blank");
        return false;
    }
}
	 /*  eventAfterRender: function(event, element, view) {
		  $(element).css('width','200px');
		} */
    });

  });
</script>
<style>

  

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>