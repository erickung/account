<?php
class WFJSftp
{
	//"商户号,终端号,银联参考号,交易日期,交易时间,账户号,交易金额,手续费,交易类型,王府井交易流水,中怡交易流水,提现状态";
	public static $rechargeTmpl = array(
		'account',
		'terminal_number',
		'account_no',
		'date',
		'time',
		'account1',
		'amount',
		'fee',
		'type',
		'wfj_ls',
		'zy_ls',
		'status',
	);
	
	static function getRecharge()
	{
		$recharges = array();
		return $recharges;
	}
	
	static function getWithdrawals()
	{
		$Withdrawals = array();
		
		return $Withdrawals;
	}
}