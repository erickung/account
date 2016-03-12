<?php
class SftpAR
{

	
	public function __construct()
	{
		$this->_lastWithdrawBill = Bills::model()->find(array(
				'condition'=>"type=1",
				'order'=>'date desc',
		));
		$this->_lastRechargeBill = Bills::model()->find(array(
				'condition'=>"type=2",
				'order'=>'date desc',
		));
	}
	
	public function updateFiles()
	{ 
		if ((time()-strtotime($this->_lastWithdrawBill->modify_time)) > 60
			&& (time()-strtotime($this->_lastRechargeBill->modify_time)) > 60) // 同时满足更新10分钟以后
		{
			list($withFiles,$rechargeFiles) = $this->_getFiles();
			$this->_updateWithdrawBills($withFiles);
			$this->_updateRechargeBills($rechargeFiles);
		}
	}
	
	private $_lastWithdrawBill;
	private $_lastRechargeBill;

	private function _updateWithdrawBills($withFiles)
	{
		$this->_updateBills($withFiles, 1);
	}
	
	private function _updateRechargeBills($rechargeFiles)
	{
		$this->_updateBills($rechargeFiles, 2);
	}
	
	private function _updateBills($files, $type=1)
	{
		if(empty($files)) return;
		 
		if ($type == 1) 
			$bill = $this->_lastWithdrawBill;
		else
			$bill = $this->_lastRechargeBill;
			
		//$bill = ($type == 1) ?　$this->_lastWithdrawBill : $this->_lastRechargeBill;
		ksort($files);
		Bills::model()->beginTransaction();
		try {
			foreach ($files as $date => $content)
			{
				if($bill && $bill->date > $date) continue;
				if($bill && $bill->date == $date)
				{
					$Bills = Bills::model()->findByAttributes(array('date'=>$date,'type'=>$type));
					$Bills->content = $content;
					$Bills->save();
				}
				else 
				{
					$Bills = new Bills();
					$Bills->date = $date;
					$Bills->content = $content;
					$Bills->type = $type;
					$Bills->save();
				}
			}
			Bills::model()->commit();
		}
		catch (CDbException $e)
		{
			echo $e->getMessage();
			Bills::model()->rollback();
		}
	}
	
	private function _getFiles()
	{
		static $files = array();
		if(empty($files))
		{
			$sftp=new SFTPServ();
			$files = $sftp->getFiles();
		}

		$withFiles = $rechargeFiles = array();
		foreach ($files as $file)
		{
			if($file == '.' || $file == '..') continue;
			if(preg_match("/WD_LS_[\d]{8}\.txt/", $file))
			{
				$data = $sftp->getSftpClient()->get($file);
				$date = str_replace(array('.txt','WD_LS_'), '', $file);
				$withFiles[$date] = trim($data);
			}
			if(preg_match("/CON_LS_[\d]{8}\.txt/", $file))
			{
				{
					$data = $sftp->getSftpClient()->get($file);
					$date = str_replace(array('.txt','CON_LS_'), '', $file);
					$rechargeFiles[$date] = trim($data);
				}
			}		
		}
		
		return array($withFiles,$rechargeFiles);
	}
}