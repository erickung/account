<?php
/**
 * 王府井发送客户端
 * @author erickung
 * 2014-7-11
 */

date_default_timezone_set("PRC");

class WFJGateway
{
	const REQEST_ERR = '请求失败，请重试';
	const DEFAULT_ERR = '无法识别的错误';
	const DEFAULT_MEMO = 'yuhaotest';

	private static $config = array();

	private static $error_code = array(
			104=> '账户不存在',
			105=> '账户消费失败',
			106=> '账户消费冲正失败',
			107=> '提现失败',
			108=> '充值失败',
			109=> '充值冲正失败',
			110=> '查询交易不存在',
			111=> '预授权失败',
			112=> '预授权完成失败',
			113=> '预授权完成冲正失败',
			114=> '转账 -- 转出账户消费失败',
			115=> '转账 -- 转入账号充值失败',
			116=> '转账 -- 转出账号充值冲正失败',
			117=> '创建账户--账户已经存在',
			118=> '退货-- 转出账户消费失败',
			119=> '退货 -- 转入账号充值失败',
			120=> '退货 -- 转出账号充值冲正失败',
			201=> 'ip校验失败',
			202=> '请求信息解析失败',
			203=> '非法用户',
			204=> '业务流水号重复',
			205=> '请求报文解析失败',
			206=> '请求数据校验失败',
			207=> '请求类型不在支持范围内（不在公司支持的类型内）',
			208=> '请求类型不支持（不在全部类型里）',
			301=> '北京银行链接失败',
			121=> '提现金额不足1元',
			209=> '流水号为空',
	);


	public function __construct($mode='test')
	{		
		self::$config = RunTime::wfjConf();
		$this->url = self::$config['url'];
	}

	public function getBalance()
	{
		self::$config['transCode'] = 'INQ';
		$HttpClient = new HttpClient($this->url);
		$resp = $HttpClient->sendMessage(self::$config);
		if (!$this->parseResponse($resp))  return false;

		return $resp['balance'];
	}
	
	public function withdrawals($amount, $accountNo, $accountName, 
			$bankName, $accountProvince, $accountCity, $bankAllName)
	{
		self::$config['transCode'] = 'WDC';
		self::$config['amount'] = $amount;
		self::$config['accountNo'] = $accountNo;
		self::$config['accountName'] = $accountName;
		self::$config['bankName'] = $bankName;
		self::$config['accountProvince'] = $accountProvince;
		self::$config['accountCity'] = $accountCity;
		self::$config['bankAllName'] = $bankAllName;
		self::$config['memo'] = self::DEFAULT_MEMO;
		self::$config['recDepType'] = '00';
		//RootTools::dump(self::$config);exit;
		$HttpClient = new HttpClient($this->url);
		$resp = $HttpClient->sendMessage(self::$config);
		if (!$this->parseResponse($resp))  return false;
		
		return true;
	}


	public function getErrorMsg()
	{
		return $this->error_msg;
	}

	private $url;
	private $error_msg;

	private function parseResponse($resp)
	{
		if (!$resp)
		{
			$this->error_msg = self::REQEST_ERR;
			return false;
		}
		if ($resp['result'] !== "00")
		{
			if (!isset(self::$error_code[$resp['result']]))
				$this->error_msg = self::DEFAULT_ERR . "+code=" . $resp['result'];
			$this->error_msg = self::$error_code[$resp['result']];
			return false;
		}
		return true;
	}

}

class HttpClient
{
	public function __construct($url)
	{
		$this->url = $url;
	}
	
	public function sendMessage(array $config)
	{
		$this->config = $config;
		$msg = $this->genPostContent();
		$msg = AuthorityTools::encrypt($msg);

		if ($resp = $this->sendToServer($msg))
		{
			$resp = AuthorityTools::decrypt($resp);
			return $resp ? self::xml2array($resp) : false;
		} 
		return false;
	}
	
	private $config = array();
	private $url = '';
	private static $uuid = '';
	
	private function genPostContent()
	{
		$this->config['busiTransNO'] = self::getUUID();
		return self::array2Xml($this->config);
	}
	
	private static function getUUID()
	{
		$uuid = '';
		do
		{
			$uuid = rand(0, 100000) . date('Ymd H:i:s') . rand(0, 100000);
		}
		while (self::$uuid === $uuid);
		
		self::$uuid = $uuid;
		return sha1($uuid);
	}
	
	private function sendToServer($msg)
	{
		try {
			$ch = curl_init($this->url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'CHCF');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch,CURLOPT_HTTPHEADER, array(
			'Content-type: text/html; charset=utf-8',
			'Content-length: '.strlen($msg),
			)
			);
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 30);
			
			$resp = curl_exec($ch);
		}
		catch (Exception $e)
		{
			//echo $e->getMessage();
			return false;
		}
		
		return $resp;
	}
	
	private static function array2Xml(array $array)
	{
		$xml = "<?xml version='1.0' encoding='UTF-8'?><request>";
		foreach ($array as $k => $v)
		{
			$xml .= "<$k>$v</$k>";
		}
		return $xml . '</request>';
	}	
	
	private static function xml2array($xml, $recursive=FALSE) 
	{
		if (!$recursive)
		{
			$array = simplexml_load_string($xml) ;
		}
		else
		{
			$array = $xml ;
		}
	
		$newArray = array() ;
		$array = (array)$array ;
		foreach ($array as $key => $value)
		{
			$value = (array)$value ;
			if (isset($value[ 0 ]))
			{
				$newArray[$key] = trim($value[0]);
			}
			else
			{
				$newArray[$key] = self::xml2array($value, true) ;
			}
		}
		return $newArray ;
	}
}

class AuthorityTools 
{
	// 加密部分
	public static function encrypt($content)
	{
		// 动态秘钥
		$dynamicKey = date('ds') . rand(100, 999) . '0';
		
		// 加密后的秘钥
		$m_dynamicKey = Cbc3DesUtil::build()->setKey(self::$tokenKey)->encrypt($dynamicKey);
	
		// 设置秘钥为动态秘钥
		$m_content = Cbc3DesUtil::build()->setKey($dynamicKey)->encrypt($content);
	
		// 设置秘钥为固定秘钥
		return Cbc3DesUtil::build()->setKey(self::$fixKey)->encrypt($m_dynamicKey . $m_content);
	}
	
	// 解密部分
	public static function decrypt($content) 
	{
		// 固定秘钥解密
		$j_finalDes = Cbc3DesUtil::build()->setKey(self::$fixKey)->decrypt($content);

		// 获取秘钥以及消息内容
		if ($j_finalDes != null && strlen($j_finalDes) > 24)
		{
			// 获取秘钥以及消息内容
			$j_f_key = substr($j_finalDes, 0, 24);
			$j_f_content = substr($j_finalDes, 24);
		} 
		else 
			return '';

		// 解密密文秘钥获取原秘钥
		$j_key = Cbc3DesUtil::build()->setKey(self::$tokenKey)->decrypt($j_f_key);

		// 根据原秘钥获取原文
		return Cbc3DesUtil::build()->setKey($j_key)->decrypt($j_f_content);
	}
	
	// 固定秘钥
	private static $fixKey = "85246913";
	// 动态秘钥加密私钥
	private static $tokenKey = "65428791";
}

class Cbc3DesUtil
{
	public static function build()
	{
		return new self();
	}
	
	public function setKey($key)
	{
		$this->key = $key;
		return $this;
	}
	
	public function setIv($iv)
	{
		$this->iv = $iv;
		return $this;
	}
	
	public function encrypt($input)
	{
		$size = mcrypt_get_block_size($this->cipher, $this->modes);
		$input = $this->pkcs5_pad($input, $size);
		
		$this->init_mcrypt();
		$data = mcrypt_generic($this->td, $input);
		$data = base64_encode($data);
		
		$this->close_mcrypt();
		return $data;
	}
	
	public function decrypt($encrypted)
	{
		$encrypted = base64_decode($encrypted);
		$this->init_mcrypt();
		$decrypted = mdecrypt_generic($this->td, $encrypted);
		$decrypted = $this->pkcs5_unpad($decrypted);
		
		$this->close_mcrypt();
		return $decrypted;
	}
	
	private $key = "!@#$%^&*";
	private $iv = '66553214';
	private $modes = MCRYPT_MODE_CBC;
	private $cipher = MCRYPT_3DES;
	
	private $td;
	
	private function close_mcrypt()
	{
		mcrypt_generic_deinit($this->td);
		mcrypt_module_close($this->td);
	}
	
	private function init_mcrypt()
	{
		$this->td = mcrypt_module_open($this->cipher,'',$this->modes,'');
		mcrypt_generic_init($this->td, $this->key, $this->iv);
	}
	
	private function pkcs5_pad ($text, $blocksize)
	{
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}
	
	private function pkcs5_unpad($text)
	{
		$pad = ord($text{strlen($text)-1});
		if ($pad > strlen($text))
		{
			return false;
		}
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
		{
			return false;
		}
		return substr($text, 0, -1 * $pad);
	}
}