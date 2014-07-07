<?php
class RootArray
{
	public static function getValue(array $arr, $k)
	{
		return isset($arr[$k]) ? $arr[$k] : '';
	}
}