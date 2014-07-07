<?php
class SalesConf
{
	static function getCustomerSource()
	{
		return array(
			1=>'促销活动',
			2=>'客户推荐',
		);
	}
	
	static function getCustomerGrade()
	{
		return array(
				1=>'A级',
				2=>'B级',
				3=>'C级',
				4=>'D级',
		);
	}
	
	static function getCustomAppointStatus()
	{
		return array(
				'show'=>array(
					0=>'被驳回',
					1=>'待确认',
					2=>'已确认',
					3=>'签约中',
					4=>'签约驳回',
					99=>'已签约',
				),
				'opt'=>array(
					0=>'驳回',
					2=>'确认',
					4=>'签约驳回',
					99=>'确认签约',
				),
		);
	}
}