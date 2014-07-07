<?php
class WebUser extends CWebUser
{
	public $user;
	public $roles;
	public $modules;
	private $all_action_modules;
	private $all_view_modules;
	private $all_module_tree;
	private $first_module;
	private static $module_ids;
	
	/**
	 * 
	 * @return WebUser
	 */
	public static function Instance()
	{
		Yii::import('application.modules.admin.ar.*');
		if (Yii::app()->user)
			return Yii::app()->user;
	
		return Yii::app()->user = new self();
	}
	
	public function auth()
	{
		$user = $this->getLoginUer();
		if (!$user) return false;	
		
		$this->load($user);
		//$this->getModuleActions();
		return true;
	}
	
	public function getLoginUer()
	{
		$token = Root::getCookie(RootConsts::TOKEN);
		if (is_null($token)) return false;
		
		$user = UserAR::model()->find("token='$token'");
		
		if ($user)
			$this->load($user);
		
		return $user;
	}
	
	public function checkPower(RootController $contr,$params=array())
	{
		$controller_id = ($contr->getModule()) ? $contr->getModule()->getId() . '.' . $contr->getId() : $contr->getId();
		$controller_id = strtolower($controller_id);
		$action_id = $contr->getAction()->getId();
		$action_id = strtolower($action_id);

		if (isset($contr::$defaultModules[$controller_id]) && in_array($action_id, $contr::$defaultModules[$controller_id]))
		{
			$module = new stdClass();
			$module->href = str_replace('.', '/', $controller_id) . '/' . $action_id;
			$contr->assignModules($this->all_view_modules, $this->all_module_tree, $module);
			return true;
		}
		//RootTools::dump($this->all_action_modules);exit;
		if (isset($this->all_action_modules[$controller_id][$action_id])) 
		{
			$module_id = $this->all_action_modules[$controller_id][$action_id];
			foreach ($this->modules as $m)
			{
				if ($m->module_id == $module_id)
				{
					$pid = $m->parent_module_id;
					break;
				}
			}

			$contr->assignModules($this->all_view_modules, $this->all_module_tree, $this->all_view_modules[$pid]);
			return true;
		}
		//exit;
		return false;
	}
	
	public function getModuleActions()
	{				
		//RootTools::dump($this->modules);
		foreach ($this->modules as $module)
		{
			if ($module->is_action)
			{
				$actions = explode(',', strtolower($module->action));
				if (!isset($this->all_action_modules[$module->controller]))
					$this->all_action_modules[$module->controller] = array();
				
				foreach ($actions as $action)
					$this->all_action_modules[$module->controller][$action] = $module->module_id;
				
				continue;
			} 

			if ($module->parent_module_id == 0)
			{
				if (!isset($this->all_module_tree[$module->module_id])) $this->all_module_tree[$module->module_id] = array();
			}
			else
			{
				if (!isset($this->all_module_tree[$module->parent_module_id]))
					$this->all_module_tree[$module->parent_module_id] = array();

				array_push($this->all_module_tree[$module->parent_module_id], $module->module_id);
			}	
			
			$module->href = str_replace('.', '/', $module->controller) . '/' . $module->action;
			$this->all_view_modules[$module->module_id] = $module;
		}
		//RootTools::dump($this->all_module_tree);
		//exit;
	}
	
	public function getFirstModule()
	{
		foreach ($this->all_module_tree as $modules)
		{
			foreach ($modules as $m)
			{
				return $this->all_view_modules[$m]->href;
			}
		}
	}
	
	private function load(UserAR $user)
	{
		$this->user = $user;
		//$this->roles = $user->getUserRoles();
		//$this->modules = $user->getUserModules();
	}
}