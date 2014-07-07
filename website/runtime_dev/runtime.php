<?php
define('RESOURCE', 'http://res.eric.com');
define('FRAMEWORK_VERSION', '1.1.14');
define('YII_DEBUG',true);
define('YII_ENABLE_EXCEPTION_HANDLER',true);
define('YII_ENABLE_ERROR_HANDLER',true);
define('UPLOAD_PATH', APP_ROOT . 'tmp');
define('IMG_URL', '');
define('CMS_LOG_PATH', RUNTIME_PATH . 'logs');
define('COMPILE_PATH', RUNTIME_PATH . DS . 'tpl_c');
define('CACHE_PATH', RUNTIME_PATH . 'cache');
error_reporting(7);

class RunTime
{
	public static function getDBConf($db = NULL)
	{	
		$dbs = array(
				'pocket' =>	array(
					'connectionString' => 'mysql:host=127.0.0.1;dbname=yunyin',
					'emulatePrepare' => true,	
					'enableParamLogging' => true,
					'username' => 'root',
					'charset' => 'utf8',
					'password' => '',
					'tablePrefix' => '',
					'enableProfiling' => true,		//这个是用来记录日志的，会记录每一条语句执行的时间
				),
		
		);
		
		if (!$db) 
			return $dbs;
		else
			return isset($dbs[$db]) ? $dbs[$db] : null;
	}
	
	public static function getRabbitMqConf()
	{
		return array(
				'host' => '192.168.16.21', 
				'port' => '5672', 
				'login' => 'guest',
				'password' => 'guest',
				'vhost'=>'/');
	}
	
	public static function getLogConf()
	{
		return array(
			'class'=>'CLogRouter',
			'routes'=>array(
					array(
							'class'=>'CFileLogRoute',
							'maxFileSize' => 102400,
							'levels' => 'trace,info,error, warning',
							'categories'=> array('system.base.*', 'system.CModule.*','application.*'),
							'logPath'=> CMS_LOG_PATH, //日志文件路径
							'maxLogFiles'=>20,
							'logFile' => 'applcation_' . date('Ymd') . '.log',
					),
					array(
							'class' => 'CFileLogRoute',
							'maxFileSize' => 102400,
							'levels' => 'trace, info,profile',
							'categories'=> 'system.db.*',
							'logFile' => 'db_' . date('Ymd') . '.log',
							'logPath'=> CMS_LOG_PATH, //日志文件路径
							'maxLogFiles'=>20,
					),
					array(
							'class' => 'CFileLogRoute',
							'levels' => 'error, warning',
							'categories'=> 'system.db.*',
							'logFile' => 'db_' . date('Ymd') . '.err',
							'logPath'=> CMS_LOG_PATH, //日志文件路径
							'maxLogFiles'=>20,
					),
					array(
							'class' => 'CFileLogRoute',
							'levels' => 'trace, info',
							'categories'=> 'application.extensions.yiimongodbsuite.*',
							'logFile' => 'mongo_' . date('Ymd') . '.log',
							'logPath'=> CMS_LOG_PATH, //日志文件路径
							'maxLogFiles'=>20,
					),
					array(
							'class' => 'CFileLogRoute',
							'levels' => 'error, warning',
							'categories'=> 'application.extensions.yiimongodbsuite.*',
							'logFile' => 'mongo_' . date('Ymd') . '.err',
							'logPath'=> CMS_LOG_PATH, //日志文件路径
							'maxLogFiles'=>20,
					),
			),
		);
	}

}