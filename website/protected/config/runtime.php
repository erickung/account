<?php
/**
 * you should copy this file to '../../../runtime/' as your own runtime config
 */
define('FRAMEWORK_VERSION', '1.1.14');
define('YII_DEBUG',true);
define('YII_ENABLE_EXCEPTION_HANDLER',true);
define('YII_ENABLE_ERROR_HANDLER',true);
error_reporting(7);
define('UPLOAD_PATH', APP_ROOT . 'tmp');
define('IMG_URL', '');
define('COMPILE_PATH', RUNTIME_PATH . DS . 'tpl_c');
define('CACHE_PATH', RUNTIME_PATH . 'cache');

class RunTime
{	
	const LDAP_HOST = '192.168.1.14';
	const LDAP_PORT = null;
	
	public static function getDBConf($db = NULL)
	{
		$dbs = array(
				'pocket' =>	array(
					'connectionString' => 'mysql:host=192.168.16.108;dbname=pocket',
					'emulatePrepare' => true,		
					'username' => 'root',
					'password' => '123456',
					'enableParamLogging' => true,
					'tablePrefix' => 'cms_',
				),
					
				'corsair' => array(
					'connectionString' => 'mysql:host=192.168.16.161;dbname=corsair_0',
					'emulatePrepare' => true,	
					'username' => 'root',
					'password' => '123456',
					'enableParamLogging' => true,
					'class' => 'CDbConnection',
					'tablePrefix' => 'fs_',
				),
		);
		
		if (!$db) 
			return $dbs;
		else
			return isset($dbs[$db]) ? $dbs[$db] : null;
	}

	public static function getLogConf()
	{
		return array(
			'class'=>'CLogRouter',
			'routes'=>array(
					array(
							'class'=>'CFileLogRoute',
							'levels' => 'trace, info, error, warning',
					),
					array(
							'class' => 'CWebLogRoute',
							'levels' => 'trace',
							'categories' => 'system.db.*' 				),
			),
		);  
	}
	
}
