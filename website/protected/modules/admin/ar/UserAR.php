<?php
/**
 * 
 * @author eric
 *
 */

class UserAR extends User
{
	public $roles;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function addUser($role = null, $product_roles)
	{
		$this->password = $this->hashPwd($this->password);
		$this->save();
		$this->saveUserRoles($role);
		$this->saveProductRoles($product_roles);
	}
	
	protected function updateUser($role = null, $product_roles)
	{
		$this->modifyByPk();
		$this->saveUserRoles($role);
		$this->saveProductRoles($product_roles, 'update');
	}
	
	function getAllUserRoles($column=3)
	{
		$roles = RoleAR::model()->findAll();
		$user_roles = $this->getUserRoles();
		$rnt = array();
		$j = 0;
		foreach ($roles as $i => $role)
		{
			if ($i%$column == 0) $j++;
			if (!isset($rnt[$j])) $rnt[$j] = array();
			
			$r = array(
				'role_id'=>$role->role_id, 
				'role_name'=>$role->role_name,
				'checked'=>false,
			);
			if (isset($user_roles[$role->role_id]))
				$r['checked'] = true;

			array_push($rnt[$j], $r);

		}

		return $rnt;
	}
	
	function getAllProductRoles($column=3)
	{ 
		$roles = ProductRoleAR::model()->findAll();
		$user_roles = $this->getUserProducts();
		$rnt = array();
		$j = 0;
		foreach ($roles as $i => $role)
		{
			if ($i%$column == 0) $j++;
			if (!isset($rnt[$j])) $rnt[$j] = array();
				
			$r = array(
					'pr_id'=>$role->pr_id,
					'pr_name'=>$role->pr_name,
					'checked'=>false,
			);
			if (isset($user_roles[$role->pr_id]))
				$r['checked'] = true;
		
			array_push($rnt[$j], $r);
		
		}
		
		return $rnt;
	}
	
	
	function getUserProducts()
	{
		$roles = array();
		try
		{
			$roles = ProductRoleAR::model()->with(
					array('users'=>array('condition'=>"users.user_id={$this->user_id}"))
			)->findAll();
		}
		catch(CDbException $e)
		{
			return array();
		}
	
		$rnt = array();
		foreach ($roles as $role)
		{
			$rnt[$role->pr_id] = $role->pr_name;
		}
	
		return $rnt;
	}
		
	function getUserRoles()
	{
		$roles = array();
		try 
		{
			$roles = RoleAR::model()->with(
					array('users'=>array('condition'=>"users.user_id={$this->user_id}"))
			)->findAll();
		}
		catch(CDbException $e)
		{
			return array();
		}
		
		$rnt = array();
		foreach ($roles as $role)
		{
			$rnt[$role->role_id] = $role->role_name;
		}
		
		return $rnt;
	}
	
	
	private function saveProductRoles($roles, $type = 'update')
	{
		if (!is_null($roles))
		{
			if ($type == 'update')
				UserProductRole::model()->deleteAllByAttributes(array('user_id'=>$this->user_id));
	
			if (is_array($roles))
			{
				foreach ($roles as $m)
				{
					$user_role = new UserProductRole();
					$user_role->pr_id = $m;
					$user_role->user_id = $this->user_id;
					$user_role->save();
				}
			}
			else
			{
				$user_role = new UserRoles();
				$user_role->pr_id = $roles;
				$user_role->user_id = $this->user_id;
	
				$user_role->save();
			}
		}
	}
	
	private function saveUserRoles($roles, $type = 'update')
	{
		if (!is_null($roles))
		{
			if ($type == 'update')
				UserRoles::model()->deleteAllByAttributes(array('user_id'=>$this->user_id));
				
			if (is_array($roles))
			{
				foreach ($roles as $m)
				{
					$user_role = new UserRoles();
					$user_role->role_id = $m;
					$user_role->user_id = $this->user_id;
					$user_role->save();
				}
			}
			else
			{
				$user_role = new UserRoles();
				$user_role->role_id = $roles;
				$user_role->user_id = $this->user_id;
				
				$user_role->save();				
			}
		}
	}
	
	function getUserModules()
	{
		try
		{
			return ModulesAR::model()->with(
					array(
							'roles',
							'roles.users'=>array('condition'=>"users.user_id={$this->user_id}")
					)		
			)->findAll(array('order'=>'ordering desc'));
		}
		catch(CDbException $e)
		{
			return array();
		}
	}
	
	public function hashPwd($pwd)
	{
		return sha1($pwd);
	}
	
	public static function getAllUsers()
	{
		static $users;
		if (!$users)
		{
			$us = self::model()->findAll();
			foreach ($us as $u)
				$users[$u->user_id] = $u->user_name;
		}
		
		return $users;
	}
	
	public static function getUserNameByUserid($user_id)
	{	
		$users = self::getAllUsers();
		return isset($users[$user_id]) ? $users[$user_id] : '';
	}
}
