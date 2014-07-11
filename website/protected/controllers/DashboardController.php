<?php
require Yii::getPathOfAlias('application.components') . DS . 'WFJGateway.php';
class DashboardController extends FController
{
	function actionIndex()
	{
		$this->render('in');
	}
	
	function actionIn()
	{
		$this->render('in');
	}
	
	function actionOut()
	{
		$this->render('out');
	}	
}