<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <span class="hidden-sm-down"><a class="navbar-brand hidden-sm" href="<?php echo Yii::app()->createUrl('./');?>">Ray On</a></span>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
	  
	  
	  
        <li <?php if(Yii::app()->controller->id=="site") {?>class="active" <?php } ?>><a href="<?php echo Yii::app()->createUrl('./');?>">Home <span class="sr-only">(current)</span></a></li>
        <!--li><a href="#">Link</a></li-->

<?php //if(Yii::app()->user->checkAccess('Authenticated')) {?>		
		<?php if(Yii::app()->user->checkAccess('admin')) {?>
        <li class="dropdown <?php if(Yii::app()->controller->id=="staffEmployment") { ?>active<?php } ?>" >
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >Account <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo Yii::app()->createUrl('StaffEmployment/admin');?>">Staff</a></li>
		<li><a href="<?php echo Yii::app()->createUrl('users/admin');?>">Users password</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('/rights');?>">Staff Rights</a></li>
			
			

          </ul>
        </li>
<?php } ?>



		
        <li class="dropdown <?php if(Yii::app()->controller->id=="attendanceRecords") { ?>active<?php } ?>" >
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >Attendance <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
          <?php if(Yii::app()->user->checkAccess('Upload Attendance Record') || Yii::app()->user->checkAccess('Attendance Report')) {?>
			<li><a href="<?php echo Yii::app()->createUrl('AttendanceRecords/UploadRecords');?>">Upload Attendance</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('AttendanceRecords/ReportLanding');?>">Report</a></li>
			<?php } ?>
			<li><a href="<?php echo Yii::app()->createUrl('AttendanceRecords/viewAttendance');?>">Personal Records</a></li>
            <!--li class="divider"></li-->
			

          </ul>
        </li>



		
		<li class="dropdown <?php if(Yii::app()->controller->id=="leaveApplication" || Yii::app()->controller->id=="approvers") { ?>active<?php } ?>" >
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >eLeave <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
           
			
            <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/Listview');?>">Leave Application</a></li>
			
			<?php if(Yii::app()->user->checkAccess('eLeave Approver')) {?>
			<li class="divider"></li>
			<li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/ManageApproval', array("type"=>"notapproved"));?>">Leave Approval</a></li>
			<?php } ?>
			<?php if(Yii::app()->user->checkAccess('eLeave Admin') || Yii::app()->user->checkAccess('eLeave Admin 2')) {?>
			<li class="divider"></li>
            <li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/admin');?>">Manage Leave Application</a></li>
            
            <?php } ?>
			<?php if(Yii::app()->user->checkAccess('admin')) {?>
				<li><a href="<?php echo Yii::app()->createUrl('Approvers/manageApprover');?>">Manage Leave Approvers</a></li>
				
			<?php } ?>
			<?php if(Yii::app()->user->checkAccess('stars system')) {?>
			<li><a href="<?php echo Yii::app()->createUrl('LeaveApplication/ExportData');?>">Consolidate with STARS</a></li>
			<?php } ?>
			
			
			
			

          </ul>
        </li>
		
	<?php if(Yii::app()->user->checkAccess('admin')) {?>
        <li class="dropdown <?php if(Yii::app()->controller->id=="wwwProjects") { ?>active<?php } ?>" >
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >Rayon WebSite <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="<?php echo Yii::app()->createUrl('WwwProjects/admin');?>">Projects</a></li>
		
			
			

          </ul>
        </li>
<?php } ?>
		
      </ul>
      <!--form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form-->
      <ul class="nav navbar-nav navbar-right">
        <!--li><a href="#">Link</a></li-->
        <li class="dropdown <?php if(Yii::app()->controller->id=="users" && Yii::app()->controller->action->id=="viewdetail") {?>active<?php } ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <!--span class="hidden-sm"> </span--><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
			 <!--li><a href="<?php echo Yii::app()->createUrl('users/viewdetail');?>">View</a></li-->
            <li class="divider"></li>
            <li><a href="<?php echo Yii::app()->createUrl('site/logout');?>" class="close_button">Logout</a></li>
          </ul>
        </li>
      </ul>
<?php //} ?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>