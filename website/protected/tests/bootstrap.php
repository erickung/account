<?php
if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
if (!defined('FRM_ROOT')) define('FRM_ROOT', dirname(__FILE__) . DS . '../../../' . DS);

define('APP_ROOT', FRM_ROOT . 'website' . DS);
if (!defined('RUNTIME_PATH')) define('RUNTIME_PATH', APP_ROOT . 'runtime' . DS);
define('APP_PROTECT', APP_ROOT . 'protected' . DS);
define('APP_CONFIG', APP_PROTECT . 'config' . DS);

if (file_exists(RUNTIME_PATH . 'runtime.php'))
	require RUNTIME_PATH . 'runtime.php';
else
	require APP_CONFIG . 'runtime.php';

// change the following paths if necessary
$yii = FRM_ROOT . 'framework' . FRAMEWORK_VERSION . '/yiit.php';
$config = APP_CONFIG . 'main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',false);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

@date_default_timezone_set('PRC');
require_once($yiit);
include FRM_ROOT . 'root_config.php';
require_once(dirname(__FILE__).'/WebTestCase.php');

Yii::createWebApplication($config);
Yii::app()->setTimeZone('UTC');

function shutdown() {
	Yii::app()->end();
}

register_shutdown_function('shutdown');
