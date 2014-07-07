<?php
class ProductConf
{
	const STATUS_FINISH = 99;
	const STATUS_OVER = 100;
	
	static function getTrustType()
	{
		return array(
			1=>'集合',
			2=>'财产权',
				
		);
	}
	
	static function getInvestmentWay()
	{
		return array(
			1=>'贷款',
		);
	}
	
	static function getStatusLabel($status)
	{
		if ($status == 0)
			return '草稿';
		elseif ($status > 0 && $status < 99)
			return '审核中';
		elseif ($status == self::STATUS_FINISH)
			return '发布中';
		elseif ($status == self::STATUS_OVER)
			return '已结束';
		else
			return '已失效'; 
 

	}
}