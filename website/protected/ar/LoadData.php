<?php
require Yii::getPathOfAlias('application.components') . DS . 'FExcel.php';
class LoadData
{
	static function getExslData()
	{
		$upload = new UploadServ();
		if ($upload->upload()) 
		{
			$file = UPLOAD_PATH . DS . $upload->getFilePath();
			$data = FExcel::buildReader($file)->getExcelData();
			array_shift($data);
			return $data;
		}
		else 
		{
			return false;
		}
	}
	
	static function processUploadData()
	{
		$data = self::getExslData();
		if (!$data) return false;

		foreach ($data as $row)
		{
			if (count($row) != 7) continue;
			$row = self::assembleData($row);
			$WFJGatewayAR = new WFJGatewayAR();
			$WFJGatewayAR->withdrawals($row);
		}
	}
	
	static function assembleData($row)
	{
		static $conf = array(
			'account_name',
			'account_no',
			'bank_name',
			'account_province',
			'account_city',
			'bank_all_name',
			'amount'
		);
		$rnt = array();
		foreach ($row as $i => $r)
		{
			$rnt[$conf[$i]] = $r;
		}
		
		return $rnt;
		
		

	}
}