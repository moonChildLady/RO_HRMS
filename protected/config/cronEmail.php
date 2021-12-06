<?php
Yii::setPathOfAlias('for_email_view','/var/www/portal/themes/classic/views/front/mail');
Yii::setPathOfAlias('for_email_layout','/var/www/portal/themes/classic/views/front/layouts/');
date_default_timezone_set('Asia/Hong_Kong');
return array(
    // This path may be different. You can probably get it from `config/main.php`.
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'cronBooking',
 
    'preload'=>array('log'),
 
    'import'=>array(
        'application.helpers.*',
		'application.models.*',
		'application.components.*',
		//'application.extensions.redis.*',
		'application.extensions.YiiMailer.YiiMailer',
    ),
    // We'll log cron messages to the separate files
    'components'=>array(
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'categories' => 'system.db.CDbCommand',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace,log',
                ),
            ),
        ),
        'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=Portal',
			'emulatePrepare' => true,
			'username' => 'kaming',
			'password' => '224335',
			'charset' => 'utf8',
		),
		
    ),
	'params'=>array(
		
	)
    //'params'=>require('_common.php'),
	/* 'params'=>array(
    'EmailServer' => array(
    'host'      => '192.168.110.71',
    'rp_from_address' => "reallypicky@aster.com.hk",
    'rp_from_display_name' => "reallypicky",
    'rp_addbbc_address'=>"reallypickysp@gmail.com",
    'rp_addbbc_display_name'=>"reallypickysp@gmail.com"
    )
	
    ), */
);