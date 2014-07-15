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
	
	

	function actionDownload()
	{
		
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('PRC');
		
		/** Include PHPExcel */
		require Yii::getPathOfAlias('application.components.PHPExcel') . DS . 'PHPExcel.php';

		
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
		->setLastModifiedBy("Maarten Balliauw")
		->setTitle("Office 2007 XLSX Test Document")
		->setSubject("Office 2007 XLSX Test Document");

		
		
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValueExplicit('A1', '收款人名称')
		->setCellValueExplicit('B1', '收款账号')
		->setCellValueExplicit('C1', '开户支行')
		->setCellValueExplicit('D1', '收款行所在省')
		->setCellValueExplicit('E1', '收款行所在市')
		->setCellValueExplicit('F1', '开户银行')
		->setCellValueExplicit('G1', '转账金额（元）');
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('测试');
		
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="01simple.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
		
	}
	
	function actionUpload()
	{
				
		LoadData::processUploadData();
		exit;
		
		
		

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