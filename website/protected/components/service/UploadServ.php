<?php
class UploadServ
{
	private $adapter;
	private $adapters = array(
			FConsts::UPLOAD_FILE => array(
					FConsts::PRODUCT_FILE_MODE => 'ProductFileUploader',

			)
	);

	private $type;
	private $max_size = 10240000;//2048*2048
	private $mode;
	
	public function __construct($type=FConsts::UPLOAD_FILE, $mode=FConsts::PRODUCT_FILE_MODE , $path = UPLOAD_PATH)
	{
		Yii::import('application.components.service.upload.*');
		$this->type = $type;
		$this->mode = $mode;
		$adpater_name = $this->getAdapterName();
		$this->setAdapter(new $adpater_name());	
		$this->getAdapter()->setInsName('file')->setMaxSize($this->max_size)->setUploadPath($path);
	}
	
	public function __call($method_name, $param_arr)
	{
		if (method_exists($this->getAdapter(), $method_name))
		{
			return call_user_func_array(array($this->getAdapter(), $method_name), $param_arr);
		}
		else
		{
			throw new CException("there is no method: $method_name of " . get_class($this->getAdapter()));
		}
	}
	
	/**
	 * 设置图片类型， 分为video（小视频）、meidia（长视频）
	 * @param unknown $type
	 */
	public function setImgType($type)
	{
		$this->getAdapter()->setParams(array('type'=> $type));
	}
	
	public function getError()
	{
		return $this->getAdapter()->getError();
	}
	
	public function setParams(array $params)
	{
		$this->getAdapter()->setParams($params);
		return $this;
	}
	
	public function getFilePath()
	{
		return $this->getAdapter()->getFilePath();
	}
	
	public function getFileRef()
	{
		return $this->getAdapter()->getFileRef();
	}
	
	public function upload()
	{
		return $this->getAdapter()->upload();
	}
	
	private function getAdapterName()
	{
		if (isset($this->adapters[$this->type][$this->mode]))
			return $this->adapters[$this->type][$this->mode];
		elseif (class_exists($this->mode))
			return $this->mode;
		else
			throw new CException("can not get adapter!");
	}
	
	private function setAdapter(UploadAbstract $adapter)
	{
		return $this->adapter = $adapter; 
	}
	
	private function getAdapter()
	{
		return $this->adapter;
	}
}