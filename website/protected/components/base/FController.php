<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FController extends RootController
{
	protected function beforeAction($action)
	{
		Yii::setPathOfAlias('service', Yii::getPathOfAlias('application.components.service'));
		if (!parent::beforeAction($action)) return false;
		
		$this->assign('self_user', WebUser::Instance()->user);
		return true;
	}
	
	protected function afterAction($action)
	{
		//OperateLogServ::log($this->module_id);
	}
	
	public function render($view, $data = NULL, $return = false)
	{
		return parent::render($view, $data, $return);
	} 
}