<?php
return array(
		
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'application.components.base.FWebUser',
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			//'showScriptName' => false,
			//'urlSuffix' => '',
			'rules'=>array(
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				//'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				//'<controller:\w+>/<action:\w+\.js>'=>'<controller>/<action>',
			),
		),
		'db'=> RunTime::getDBConf('pocket'),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>RunTime::getLogConf(),
	);