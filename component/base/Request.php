<?php
class Request
{
	public static $get = array();
	public static $post = array();
	
	public static function processGet()
	{
		self::$get = $_GET;
		if (!isset($_GET['dir'])) self::$get['dir'] = 'desc';
		if (!isset($_GET['limit'])) self::$get['limit'] = '20';
		if (!isset($_GET['start'])) self::$get['start'] = '0';
	}
	
	public static function processPost()
	{
		$post = @file_get_contents("php://input");
		$post = json_decode($post, true);
		if ($post && !empty($post) && isset($post['data']))
			self::$post = array_merge($_POST, $post['data']);
		else 
			self::$post = $_POST;
	}
	
	public static function getNewConditionAfterAddSearch($condition, $Property, $value)
	{
		if (empty($condition['condition'])) {
			$condition['condition'] .= "{$Property} = :{$Property}";
		} else {
			$condition['condition'] .= " AND {$Property} = :{$Property}";
		}
		$condition['params'][":{$Property}"] = $value;
		
		return $condition;
	}
	
	public static function clearSearch()
	{
		self::$_filter_custom = array();
	}
	
	public static function getSearch($name = null)
	{
		if (!isset($_GET['filter']))
			return;
		
		$filters = json_decode(get_magic_quotes_gpc() ? $_GET['filter'] : stripslashes($_GET['filter']), true);
		
		$rnt = array();
		foreach ($filters as $filter)
		{
			if ($name)
			{
				if ($filter['property'] == $name)
					return $filter['value'];
			}
			else 
			{
				if ($filter['value'] !== '') $rnt[$filter['property']] = $filter['value'];
			}
		}
		return $rnt;
	}
}