<?php
ob_start('My_OB');
function My_OB($str, $flags)
{
    //remove UTF-8 BOM
    $str = preg_replace("/\xef\xbb\xbf/","",$str);
    
    return $str;
}
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    
	
    array(
    	
		'theme'=>'classic',
		//'onBeginRequest'=>array('BeginClass', 'BeginRequest'),
		
    	//'theme'=>'mobiletheme',
        // Put front-end settings there
        // (for example, url rules).
     'components'=>array(

        'urlManager'=>array(
    'urlFormat'=>'path',
    'showScriptName'=>false,
    'rules'=>array(
        //'member/changeforgotpassword/<temp_token:\w+>'=>'member/changeforgotpassword/',
		//'product/<product:\d>/qty/'
		
		
		//'staffEmployment/<StaffCode:\w+>'=>'staffEmployment/view',
		//'staffEmployment/update/<StaffCode:\w+>'=>'staffEmployment/update',
		//'ContentTable/createtype/<type:\w+>'=>'ContentTable/createtype/',
		'AttendanceRecords/report/<type:\w+>/<date:\w+>'=>'AttendanceRecords/report',
		'AttendanceRecords/ViewAttendance/<date:.*>/<viewType:\w+>/'=>'AttendanceRecords/ViewAttendance',
		'LeaveApplication/ManageApproval/<type:\w+>'=>'LeaveApplication/ManageApproval',
		//UpdateApprover
		'Approvers/updateApprover/<staffCode:.*>'=>'Approvers/updateApprover/',
		'LeaveApplication/admin/<type:\w+>'=>'LeaveApplication/admin',
        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
		//'<controller:\w+>/<id:\d+>'=>'<controller>/do',
		'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
    ),
	),
        
    ),
   )
);
