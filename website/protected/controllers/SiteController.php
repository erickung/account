<?php

class SiteController extends FController
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		//$first_module = WebUser::Instance()->getFirstModule();
		header("Location: /dashboard/index");
		
		//$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	function actionUpload()
	{
		Yii::import('product.ar.*');
		if (!isset($_GET['token']))  Response::failure('auth error');
		
		$_COOKIE['token'] = $_GET['token'];
		$user = WebUser::Instance()->getLoginUer();
		if (!$user) Response::failure('您没有权限');
		
		@set_time_limit(5 * 60);

		$UploadServ = new UploadServ();
		$UploadServ->setParams(array('product_id'=>$_GET['id'], 'name'=>$_GET['name']));
		if ($UploadServ->upload())
		{
			die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
		} 
		else 
		{
			die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$UserIdentity = new UserIdentity($_POST['username'], $_POST['password']);
			
			if ($UserIdentity->authenticate())
			{
				$this->redirect(Yii::app()->user->returnUrl);
			}
			else
			{
				Root::error("login failure : {$_POST['username']}");
			}
		}
		$this->renderPartial('login');
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}