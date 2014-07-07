<?php
//////////////////////////////////////////////////////////////////////////////////////////
// Author: 孔繁兴
// Copyright 2005-, Funshion Online Technologies Ltd. All Rights Reserved
// 版权 2005-，北京风行在线技术有限公司 所有版权保护
// This is UNPUBLISHED PROPRIETARY SOURCE CODE of Funshion Online Technologies Ltd.;
// the contents of this file may not be disclosed to third parties, copied or
// duplicated in any form, in whole or in part, without the prior written
// permission of Funshion Online Technologies Ltd.
// 这是北京风行在线技术有限公司未公开的私有源代码。本文件及相关内容未经风行在线技术有
// 限公司事先书面同意，不允许向任何第三方透露，泄密部分或全部; 也不允许任何形式的私自备份.
//////////////////////////////////////////////////////////////////////////////////////////
class UserIdentity extends CUserIdentity
{
	private $user;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$this->user = User::model()->findByAttributes(array('user_name'=>$this->username));
		
		if (!$this->user) 
		{
			Root::error("can't get user : {$this->username}");
			return false;
		}
		
		if ($this->authBySys())
		{
			$this->user->token = $this->genToken();
			$this->user->last_login_time = new CDbExpression('NOW()');
			$this->user->password = $this->encrypt($this->password);
			$this->user->save();
			Root::setCookie(RootConsts::TOKEN, $this->user->token);
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	private function authBySys()
	{
		return $this->user->password == $this->encrypt($this->password);
	}
	
	private function encrypt($pass)
	{
		return sha1($pass);
	}
	
	private function authByLdap()
	{
		$ldapHost = "ldap://" . RunTime::LDAP_HOST;
        $ldapPort = RunTime::LDAP_PORT;
	    $ldapUser ="cn=name,dc=domain";
	    $ldapPswd = $this->password;
	
		$ldapLink = ldap_connect($ldapHost, $ldapPort);
		if (!$ldapLink) Root::error("link to ldap error {$this->username}");

		if($ldapLink)
		{
			try
			{
				ldap_set_option($ldapLink, LDAP_OPT_PROTOCOL_VERSION, 3);
				ldap_set_option ($ldapLink, LDAP_OPT_REFERRALS, 0 );
				@$bind = ldap_bind($ldapLink, "{$this->username}@funshion.com", $ldapPswd);
			}
			catch (Exception $e)
			{
				echo $e->getMessage();
			}
			
			if(!$bind) 
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			else 
				$this->errorCode = self::ERROR_NONE;
		}
		else
		{
			return $this->authBySys();
		}
		return !$this->errorCode ? true : false;
	}
	
	private function genToken()
	{
		return md5(uniqid(rand()));
	}
	
}