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
	
	public static function getAllCustomers($order='')
	{
		$criteria = new CDbCriteria();
		if ($order) $criteria->order = $order;
		static $customers = array();
		if (empty($customers))
			$customers = self::model()->findAll($criteria);
		
		return $customers;
	}
	
	public static function getAllCustomerOptions()
	{
		$customers = self::getAllCustomers('account_name asc');
		$rnt = array();
		foreach ($customers as $c)
		{
			$rnt[$c->id] = $c->account_name . "({$c->account_no})";
		}
		return $rnt;
	}
}