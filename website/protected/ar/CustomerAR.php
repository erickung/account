<?php
class CustomerAR extends Customer
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	function addCustomer($info)
	{
		$this->setAttributesFromRequest($info);
		$this->save();
	}
	
	function updateCustomer($info)
	{
		$this->setAttributesFromRequest($info);
		$this->modifyByPk($this->id);
	}
	
	public static function getAllCustomers()
	{
		static $customers = array();
		if (empty($customers))
			$customers = self::model()->findAll();
		
		return $customers;
	}
	
	public static function getAllCustomerOptions()
	{
		$customers = self::getAllCustomers();
		$rnt = array();
		foreach ($customers as $c)
		{
			$rnt[$c->id] = $c->account_name . "({$c->account_no})";
		}
		return $rnt;
	}
}