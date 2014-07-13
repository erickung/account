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
		if ($customer)  $this->assign('customer',$customer);
		$this->renderPartial('load_customer');
	}
}