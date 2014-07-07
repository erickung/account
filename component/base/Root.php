<?php
class Root
{
	public static function addSession($k, $v)
	{
		return Yii::app()->session->add($k, $v);
		return Yii::app()->session->setTimeout(86400);
	}
	
	public static function getSession($k)
	{
		return Yii::app()->session->get($k);
	}
	
	public static function removeSession($k)
	{
		return Yii::app()->session->remove($k);
	}
	
	public static function setCookie($k, $v)
	{
		setcookie($k, $v, time()+86400*30, '/', $_SERVER['HTTP_HOST']);
		$_COOKIE[$k] = $v;
	}
	
	public static function getCookie($k)
	{
		return isset($_COOKIE[$k]) ? $_COOKIE[$k] : null;
	}
	
	public static function removeCookie($k)
	{
		setcookie($k, null, 0, '/', $_SERVER['HTTP_HOST']);
	}
	
	public static function loadFileConf($conf)
	{
		return self::loadConf($conf, true);
	}
	
	public static function loadConf($conf, $not_conf = false)
	{	
		static $config = null;
		$file = '';
		
		if ($not_conf)
			$file = $conf;
		else
			$file = self::getConfFile($conf);
		$key = self::getConfKey($file);
		
		if (isset($config[$key]))
			return $config[$key];
		
		return $config[$key] = require $file;
	}
	
	public static function getConfFile($conf)
	{
		return rtrim(APP_CONFIG, "/") . '/' . $conf . '.php';
	}
	
	public static function getConfKey($file)
	{
		return md5($file);
	}
	
	public static function convetARToList($ar_arr, array $tmpl)
	{
		$rnt = array();
		
		if (is_array($ar_arr))
		{
			foreach ($ar_arr as $i => $ar)
			{
				foreach ($tmpl as $k)
					$rnt[$i][$k] = isset($ar->{$k}) ? $ar->{$k} : '';
			}
		}
		elseif ($ar_arr instanceof CActiveRecord)
		{
			return self::convetARToArray($ar, $tmpl);
		}
		
		return $rnt;
	}
	
 	public static function convetARToArray(CActiveRecord $ar, array $tmpl = null)
	{
		$rnt = array();
	
		if (!$tmpl)
			return $ar->getAttributes();
		
		foreach ($tmpl as $k)
			$rnt[$k] = isset($ar->{$k}) ? $ar->{$k} : '';
	
		return $rnt;
	}
	
	public static function convertARToOptions(array $ar_arr, $key_id, $value_id)
	{
		if (empty($ar_arr)) return array();

		foreach ($ar_arr as $ar)
		{
			if (isset($ar->{$key_id}) && isset($ar->{$value_id}))
				$rnt[] = array($ar->{$key_id}, $ar->{$value_id});
		}
		
		return $rnt;
	}
	
	public static function log($msg)
	{
		Yii::log($msg, CLogger::LEVEL_INFO);
	}
	
	public static function warn($msg)
	{
		Yii::log($msg, CLogger::LEVEL_WARNING);
	}
	
	public static function error($msg)
	{
		if (self::isDev()) echo $msg; 

		Yii::log($msg, CLogger::LEVEL_ERROR);
	}
	
	public static function isDev()
	{
		return defined('DEV_MODE');
	}
	
}