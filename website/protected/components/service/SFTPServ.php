<?php
require Yii::getPathOfAlias('application.extensions.phpseclib.vendor') . DS . 'autoload.php';

class SFTPServ 
{
	public function __construct()
	{
		$this->getSftp();
	}	
	
	
	
	public function getFiles()
	{
		if(RunTime::$sftp['dir'])
		{
			$this->_sftp->chdir('/shared');
			
		}
		return $this->_sftp->nlist();
	}
	
	public function getSftpClient()
	{
		return $this->_sftp;
	}
	
	private $_sftp;
	private function getSftp()
	{
		include('Net/SFTP.php');
		$sftpconf = RunTime::$sftp;
		$strServer = $sftpconf['server'];
		$strServerPort = $sftpconf['port'];
		$strServerUsername = $sftpconf['username'];
		$strServerPassword = $sftpconf['password'];
		$this->_sftp = new Net_SFTP($strServer);  //初始化一个sftp实例
		for($i = 0;$i<10;$i++){
			if ($this->_sftp->login($strServerUsername, $strServerPassword)) {   //考虑到网络条件等因素，允许尝试至多10次登录操作
				break;
			}
			else{
				if($i==9){
					exit('Sftp Login Failed');   //如果10次都登录失败，则退出
				}
			}
		}
	}
}