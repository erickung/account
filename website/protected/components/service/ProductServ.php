<?php
class ProductServ
{
	private static $ins;
	
	public static function Instance($type = 'ar')
	{
		if (self::$ins === null)
			self::$ins = new self();
	
		
		self::$ins->setAdapter(new self::$types[$type]);
	
		return self::$ins;
	}
}