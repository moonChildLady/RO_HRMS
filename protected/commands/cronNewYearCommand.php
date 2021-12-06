<?php
class cronNewYearCommand extends CConsoleCommand {
	
	
	public function run($args) {
		
		$connection = Yii::app()->db;
		$sql = "TRUNCATE LeaveApplicationRef";
		$connection->createCommand($sql);
		
		//$connection = Yii::app()->db;
		$sql1 = "ALTER TABLE table_name AUTO_INCREMENT = 1";
		$connection->createCommand($sql1);
		
		
		
		
	}
	
}
?>