<?php
$configs = CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db'=> RunTime::getDBConf('pocket'),
		),
		'import'=>array(
				'application.models.*',
				'application.components.*',
				'application.modules.admin.ar.*',
		),
	)
);


$configs['components']['log'] = array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
							'class' => 'CFileLogRoute',
							'levels' => 'trace, info',
							'categories'=> 'system.db.*',
							'logFile'=> 'db.log',
							'maxFileSize'=>5120,//日志大小
							'logPath'=>RUNTIME_PATH . 'logs', //日志文件路径
							'maxLogFiles'=>20,
					),
					array(
							'class' => 'CFileLogRoute',
							'levels' => 'error, warning',
							'categories'=> 'system.db.*',
							'logFile'=> 'db.error',
							'maxFileSize'=>5120,//日志大小
							'logPath'=>RUNTIME_PATH . 'logs', //日志文件路径
							'maxLogFiles'=>20,
					),
				)
);
						
return $configs;