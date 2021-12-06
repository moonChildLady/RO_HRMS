
<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('for_email_view','themes/classic/views/front/mail');
Yii::setPathOfAlias('for_front_view','themes/classic/views/front/layouts');
Yii::setPathOfAlias('for_email_layout','themes/classic/views/front/layouts/');
Yii::setPathOfAlias('booster', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../extensions/yiibooster');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Ray On Portal',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),
	//'language' => 'zh_HK',
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.phpexcel.PHPExcel',
		'application.extensions.YiiMailer.YiiMailer',
		'application.modules.rights.*',
		'application.modules.rights.components.*',
		'ext.dropzone.EDropzone.*',
	),

	'modules'=>array(
	'rights'=>array( 
		//'install'=>true, // Enables the installer. 
		//'appLayout'=>'themes.classic.views.front.layouts.main',
		'enableBizRuleData'=>true,
        'debug'=>true,
		'userClass'=>'Users',
		'userIdColumn'=>'id',
		'userNameColumn'=>'staffCode',
		'superuserName'=>'admin',
	),
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'',
			'generatorPaths'=>array(
       			'booster.gii', // boostrap generator
       			'ext.mpgii'
    		),
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('*'),
		),
	),
/*
		'user'=>array(
                'tableUsers' => 'Staff',
    ),
*/
	// application components
	'components'=>array(
		/* 'clientScript'=>array(
			'packages'=>array(
				'jquery'=>array(
					'baseUrl'=>Yii::app()->theme->baseUrl . 'themes/classic/js',
					'js'=>array('jquery.min.js'),
				)
			)
		), */
		'bootstrap' => array(
            'class' => 'booster.components.Booster',
        ),
		'user'=>array(
			// enable cookie-based authentication
			//'class'=>'WebUser',  //Adding WebUser class
			'allowAutoLogin'=>true,
			'loginUrl' => array('site/login'),
			'class' => 'RWebUser',
			//'tableUsers' => 'Staff',
		),
		'authManager'=>array(
			'class'=>'RDbAuthManager',
			'defaultRoles'=>array('Authenticated'),
			//'defaultRoles'=>array('Guest'),
			/* 'connectionID'=>'db',
            'itemTable'=>'AuthItem',
            'itemChildTable'=>'AuthItemChild',
            'assignmentTable'=>'AuthAssignment',
            'rightsTable'=>'Rights', */
		),
		// uncomment the following to enable URLs in path-format
		
		/* 'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		), */
		

		// database settings are configured in database.php
		//'db'=>require(dirname(__FILE__).'/database.php'),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=Portal',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'db_www'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=MainWeb',
			'class'=>'CDbConnection',//!important
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'application.extensions.LogDb',
					'levels'=>'error, warning, info, test, sample, trace',
					'connectionID'=>'db',
					'autoCreateLogTable'=>true,
					'enabled'=>true,
					//'categories'=>'*',
					//'logTableName'=>'log_yii',
				),
				// uncomment the following to show log messages on web pages
				//array(
                    //'class'=>'LogDb',
                    //'autoCreateLogTable'=>true,
                    //'connectionID'=>'db',
                    //'enabled'=>true,
                    //'levels'=>'trace,info,warning,error',
					//You can replace trace,info,warning,error
                //),
				
array(
					'class'=>'CWebLogRoute',
				),

				
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'companyName'=>'RO',
	),
			'behaviors'=>array(
		//'ApplicationConfigBehavior',
    'runEnd'=>array(
        'class'=>'application.components.WebApplicationEndBehavior',
    ),
),
);
