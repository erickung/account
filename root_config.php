<?php 
if (!defined('FRM_ROOT')) define('FRM_ROOT', dirname(__FILE__) . DS);
define('FRM_COM', FRM_ROOT . 'component');

Yii::import('root.*');
Yii::import('root.base.*');
Yii::import('root.service.*');
Yii::import('root.service.log.*');
Yii::import('root.service.active_record.*');

Yii::setPathOfAlias('frm.base', FRM_COM.DS.'base');