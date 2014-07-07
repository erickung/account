<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=> APP_PROTECT,
	'name'=>'运营平台',
	'runtimePath'=>RUNTIME_PATH,

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.ar.*',
		'application.models.*',
		'application.components.*',
		'application.components.service.*',
		'application.components.base.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		//'admin','sales','product','custom',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('192.168*','127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=> require APP_CONFIG . 'components.php',

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'kongfx@funshion.com',
	),
);