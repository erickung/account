<?php 
class RootTools
{
	public static function diffArraySets(array $old, array $new) {
		$arr_del = array_diff($old, $new);
		$arr_add = array_diff($new, $old);
		return array($arr_del, $arr_add);
	}
	
	public static function get_variable_name(&$var, $scope = NULL) 
	{
       if (NULL == $scope) $scope = $GLOBALS;
 
       $tmp  = $var;
       $var   = "tmp_exists_" . mt_rand();
       $name = array_search($var, $scope, TRUE);
       $var   = $tmp;
 
       return $name;
	}
	
	public static function converToComma($str){
		return explode(',', preg_replace('/(，|,| |　)+/', ',', $str));
	}
	
	public static function date($v, $format=null)
	{
		$format = is_null($format) ? 'Y-m-d' : $format;
		return empty($v) ? '' : date($format, $v);
	}
	
	public static function dump()
	{
		$v = func_get_args();
		if (empty($v)) return ''; 

		$html = 
<<<HTML
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		</head>
		<body>
HTML;
		echo $html;
		foreach ($v as $vv)
			var_dump($vv);
		echo "</body></html>";
		
	}
	
	/**
	 * @Purpose: 循环创建目录，直到最底层
	 * @Param: string $dir 要创建目录的绝对路径。如：/root/temp/cache
	 * @Return: 成功返回true，异常返回false
	 */
	public static function make_dir($dir)
	{
		return is_dir($dir) || (self::make_dir(dirname($dir)) && mkdir($dir, 0777));
	}
}