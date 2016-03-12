<?php
require Yii::getPathOfAlias('application.components') . DS . 'WFJGateway.php';
require Yii::getPathOfAlias('application.extensions.vendor') . DS . 'autoload.php';
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
		//sif (!$balance) $balance = '000000996980'; 

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
		else
			Response::respThisPage(false, '', '', $WFJGatewayAR->error);

	}
	
	function actionWithdrawalsList()
	{
		$data =  WithdrawalsLog::model()->with('customer')->findAll(
			array('order'=>'modify_time desc')
		);
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
	
	function actionGetWithdrawBills()
	{
		$type = (Request::$get['type']) ? intval(Request::$get['type']) : 1;
		$data = Bills::model()->findAll(
			array(
				'condition'=>"type=$type",
				'order'=>'date desc',
			)
		);
		
		$bills = array();
		$j = 0;
		foreach ($data as $i => $bill)
		{
			if($i % 4 == 0 || $i == 0)
			{
				$j++;
				$bills[$j] = array();
				
			}
			array_push($bills[$j], $bill);
		}
		$content = Request::$get['type'] == 1 ? '交易状态：1代表成功；0代表正在处理；2代表失败。' : '交易状态：1：已充值；0未处理。';
		$this->renderPartial('load_bills', array('bills'=>$bills,'content'=>$content));
	}
	 
	
	function actionUpdateBill()
	{
		$sftp = new SftpAR();
		$sftp->updateFiles();
		exit;
	}
	
	function actionDownBill()
	{
		$bill =  Bills::model()->findByPk(Request::$get['id']);
		if(!$bill) exit('error!');
		$file_name = $bill->type == 1 ? "提现_.{$bill->date}.csv" : "消费_.{$bill->date}.csv";
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=$file_name");
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		$content = explode("\n", $bill->content);
		if ($bill->type == 1)
		{
			$title = "商户号,终端号,交易日期,交易时间,账户号,交易金额,手续费,交易类型,王府井交易流水,中怡交易流水,交易状态\n";
		} 
		else 
		{
			$title = "商户号,终端号,银联参考号,交易日期,交易时间,账户号,交易金额,手续费,交易类型,王府井交易流水,中怡交易流水,交易状态\n";
		}
		array_unshift($content, $title);
		foreach ($content as $c)
		{
			$c = mb_convert_encoding($c, 'gbk', 'utf-8');
			echo "$c\n";
		}
		exit;
	}
}