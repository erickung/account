<?php
class WFJGatewayAR
{
	public $error;
	function withdrawals($info)
	{
		RootTools::dump($info);
		$customer = CustomerAR::model()->findByAttributes(array('account_no'=>$info['account_no']));
		if (!$customer)
		{
			$customer = new CustomerAR();
			$customer->setAttributesFromRequest($info);
			$customer->save();
		}

		$WFJGateway = new WFJGateway();
		$resp = $WFJGateway->withdrawals($info['amount'], $info['account_no'], $info['account_name'], 
				$info['bank_name'], $info['account_province'], $info['account_city'], $info['bank_all_name']);		
		
		$Log = new LogAR();
		$Log->status = $resp ? 1 : -1;	
		$Log->type = 1;
		$Log->error_msg = $resp ? '' : $WFJGateway->getErrorMsg();		
		$Log->save();
		
		if ($resp) 
		{
			$WithdrawalsLog = new WithdrawalsLog();
			$WithdrawalsLog->customer_id = $customer->id;
			$WithdrawalsLog->amount = $info['amount'];
			$WithdrawalsLog->save();
			return true;
		}
		
		$this->error = $WFJGateway->getErrorMsg();
		return false;

	}
	
	function getBalance()
	{
		$WFJGateway = new WFJGateway();
		$balance = $WFJGateway->getBalance();
	}
}