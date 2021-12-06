<?php
class EmailContent
{
public static function missingAttendace($staff, $date) {
				$mail = new YiiMailer();
                $mail->setView('missingAttendace');
                $mail->setData(array(
					'date' => $date,
				));
                $mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
                //$mail->AddReplyTo(Yii::app()->params['reply_to']);
				$mail->setBcc(array("leave@rayon.hk","kmchu@rayon.hk"));
                $mail->setTo($staff->staffCode0->email);
                //$mail->setTo("kmchu@rayon.hk");
                $mail->setSubject('Ray On Portal –Abnormal clock-in(s) / clock-out(s)');
                $mail->send();
}


public static function sendReminderEmail_GetAttendanceRecordError($model){

				$mail = new YiiMailer();
                $mail->setView('GetAttendanceRecord');
                $mail->setData(array(
					'model' => $model,
				));
                $mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
                //$mail->AddReplyTo(Yii::app()->params['reply_to']);
				//$mail->setBcc(array("kmchu@rayon.hk"));
                $mail->setTo("kmchu@rayon.hk");
                //$mail->setTo("kmchu@rayon.hk");
                $mail->setSubject('[ERROR] Ray On Portal getting attendance report');
                $mail->send();
	
}
public static function sendReminderEmail_GetAttendanceRecord($model){

				$mail = new YiiMailer();
                $mail->setView('GetAttendanceRecord');
                $mail->setData(array(
					'model' => $model,
				));
                $mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
                //$mail->AddReplyTo(Yii::app()->params['reply_to']);
				//$mail->setBcc(array("kmchu@rayon.hk"));
                $mail->setTo("kmchu@rayon.hk");
                //$mail->setTo("kmchu@rayon.hk");
                $mail->setSubject('Ray On Portal getting attendance report');
                $mail->send();
	
}
public static function sendReminderEmail_Approver($model) {
			// php /var/www/portal/cronEmailApprover.php cronEmailApprover
			
			
			foreach($model as $approver=>$leaves){
				$criteria = new CDbCriteria();
				$criteria->addCondition('staffCode = :staffCode');
				$criteria->params = array(
					":staffCode"=>$approver,
				);
				$staff = Staff::model()->find($criteria);
				if($staff && $staff->email != ""){
				$mail = new YiiMailer();
                $mail->setView('approverAlert');
                $mail->setData(array(
					'leaves' => $leaves,
				));
                $mail->setFrom('noreply@rayon.hk', 'Ray On Portal');
                //$mail->AddReplyTo(Yii::app()->params['reply_to']);
				$mail->setBcc(array("leave@rayon.hk","kmchu@rayon.hk"));
                $mail->setTo($staff->email);
                //$mail->setTo("kmchu@rayon.hk");
                $mail->setSubject('Ray On Portal – Leave(s) awaiting your approval on '.date('Y-m-d'));
                $mail->send();
					
				}
			}
			
				/* $today = new DateTime();
				
				$mail = new YiiMailer();
                $mail->setView('cronBooking');
                $mail->setData(array(
                               'model' => $model,
                               'today' => $today->format("Y-m-d"),
                               )
                               );
                $mail->setFrom(Yii::app()->params['booking']['adminEmail'], "itadmin");
                //$mail->AddReplyTo(Yii::app()->params['reply_to']);
                $mail->AddBcc(Yii::app()->params['booking']['adminEmail']);
                $mail->setTo(Yii::app()->params['booking']['To']);
                $mail->setSubject('SPKC Booking record(s) on '.$today->format("d M Y"));
                $mail->send(); */
				//var_dump($model);
	}
	
	
	
}