
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Consolidate with STARS</h3>
  </div>
  <div class="panel-body">
    <form action="<?php echo Yii::app()->createUrl('LeaveApplication/ExportData');?>" method="post" enctype="multipart/form-data">
 
  <div class="form-group">
    <label for="exampleInputFile">Upload Excel File</label>
    <input type="file" id="exampleInputFile" name="xlsfile" required>
    <p class="help-block">Please use the Excel file(.xls).</p>
	<p class="help-block">Please put the content in the first worksheet.</p>
	<p class="help-block">Go to <a href="http://rayon.hk:65000/Login.aspx" target="_blank">http://rayon.hk:65000/Login.aspx</a>, export the excel from Report --> Time and Attendance Report --> Monthly Working Report.</p>
  </div>

  <button type="submit" class="btn btn-primary">Consolidate</button>
</form>
  </div>
</div>
