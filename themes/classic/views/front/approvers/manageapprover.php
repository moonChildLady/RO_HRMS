<?php foreach(Yii::app()->user->getFlashes() as $key => $message) {
?>




<div class="alert alert-<?php echo $key;?> alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
 <?php echo $message;?>
</div>
<?php } ?>


<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Manage Approver</h3>
    
  </div>
  <div class="panel-body">
  <div class="btn-group pull-left">
  <button type="button" class="btn btn-success dropdown-toggle " data-toggle="dropdown" aria-expanded="false">
    New <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="<?php echo Yii::app()->createUrl('Approvers/create');?>">Approvers</a></li>
   
   
  </ul>
  
  
</div>
  	<div class="table-responsive">
  	
  			<table class="table table-bordered">
				<tr>
					<th>Staff</th>
					<th>Approver 1</th>
					<th>Approver 2</th>
					<th>Approver 3</th>
					
				</tr>
				<?php foreach($model as $i=>$staff) { ?>
				<tr>
					
					<td><p><?php echo $staff->staffCode;?></p>
					<p><?php echo $staff->staffCode0->Fullname;?></p>
					</td>
					<?php 
					
					
					foreach($this->getApprover($staff->staffCode) as $j=>$approver){ 
					?>
					<td>
					<?php	
					if($approver){
					?>
					<div class="row">
					<div class="col-md-6">
						<p><?php echo $approver->approver0->staffCode;?></p>
						<p><?php echo $approver->approver0->Fullname;?></p>
						<p>Start from <?php echo $approver->startDate;?></p>
					</div>
					<div class="col-md-2">
						<a class="btn btn-primary" href="<?php echo Yii::app()->createURL('Approvers/update', array('id'=>$approver->id));?>"><span class=" glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					</div>
					</div>
					<?php }else{ ?>
						-
					<?php } ?>
					</td>	
					<?php  
						
						} 
					?>
				</tr>
				<?php } ?>
  			</table>
  	</div>
  </div>
</div>