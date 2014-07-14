<?php
require Yii::getPathOfAlias('application.components') . DS . 'WFJGateway.php';
class DashboardController extends FController
{
	function actionIndex()
	{
		header("Location: /dashboard/in");
	}
	
	function actionIn()
	{

		
		$this->render('in');
	}
	
	function actionGetBalance()
	{
		$WFJGateway = new WFJGateway();
		$balance = $WFJGateway->getBalance();
		if (!$balance) $balance = '000000996980'; 

		if($balance)
			$this->assign('balance',$balance);
		else
			$this->assign('error',$WFJGateway->getErrorMsg());
		
		$this->renderPartial('balance');
	}
	
	function actionOut()
	{
		$customers = CustomerAR::getAllCustomerOptions();
		$this->assign('customers',$customers);
		$this->render('out');
	}	
	
	function actionCustomerList()
	{
		$customers = CustomerAR::model()->findAll();
		$this->assign('customers',$customers);
		
		$this->render('customer_list');
	}
	
	function actionCustomer()
	{
		if (!isset(Request::$get['action'])) 
		{
			$customers = CustomerAR::getAllCustomers();
			$this->assign('customers',$customers);
			
			$this->render('customer_list');
		}
		else 
		{
			if (isset(Request::$get['id']) && Request::$get['id']>0)
			{
				$customer = CustomerAR::model()->findByPk(Request::$get['id']);
			}
			else
			{
				$customer = new CustomerAR();
			}
			
			$this->assign('customer',$customer);
			if (isset(Request::$get['href'])) 
				$this->assign('href',Request::$get['href']);
			
			$this->render('customer');
		}
	}
	
	function actionCustomerEdit()
	{
		$customer = new CustomerAR();
		
		if (Request::$post['id'])
		{
			$flag = $customer->saveCommit('updateCustomer', Request::$post);
		}
		else
		{
			$flag = $customer->saveCommit('addCustomer', Request::$post);
		}
		
		if (isset(Request::$post['href'])) 
		{
			Response::resp($flag, '', Request::$post['href']);
		}
	}
	
	function actionLoadCustomer()
	{
		$customer = CustomerAR::model()->findByPk(Request::$get['id']);
		if (!$customer) $customer = new CustomerAR();

		$this->assign('customer',$customer);
		$this->renderPartial('load_customer');
	}
	
	function actionWithdrawals()
	{
		$WFJGatewayAR = new WFJGatewayAR();
		$resp = $WFJGatewayAR->withdrawals(Request::$post);
	
		if ($resp)
			Response::respThisPage(true, '', '/dashboard/out');

	}
	
	function actionWithdrawalsList()
	{
		if (isset(Request::$get['status']) && Request::$get['status']=1)
			$data =  WithdrawalsLog::model()->with('customer')->findAllByAttributes(array('status'=>1));
		else 
			$data =  WithdrawalsLog::model()->with('customer')->findAllByAttributes(array('status'=>0));
	
		$this->renderPartial('load_withdraws_list', array('data'=>$data));
	}
	
	function actionToAccount()
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'time desc';
		//$criteria->limit = $this->limit();
		//$criteria->offset = $this->offset();
		$data = ToAccountAR::model()->findAll($criteria);
		$this->renderPartial('load_to_account', array('data'=>$data));
	}
}