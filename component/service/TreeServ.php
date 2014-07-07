<?php
class TreeServ
{
	private static $ins;
	private $adapter;

	private $adapters = array(
			
			
	);
	
	public static function Instance()
	{
		if (self::$ins !== null)
			return self::$ins;
	
		Yii::import('application.components.service.tree.*');
		self::$ins = new self();
		
		return self::$ins;
	}
	
	public function setAdapter($ad)
	{
		if (isset($this->adapters[$ad]))
			$this->adapter = new $this->adapters[$ad]();
		else
			throw new CException("there is no $ad adapter");
	}
	
	/**
	 * $config = array(
	 * 		'data' => 装载的数据
	 * 		'node'   => 节点名称 
	 * 		'pnode' => 父节点名称
	 * );
	 * @param unknown_type $config
	 */
	public function load(array $config)
	{
		$this->getAdapter()->load($config);
		return $this;
	}
	
	public function genTree()
	{
		return $this->getAdapter()->genTree();
	}
	
	public function getChildren($id)
	{
		return $this->getAdapter()->getChildren($id);
	}
	
	private function getAdapter()
	{
		if ($this->adapter !== NULL)  return $this->adapter;
		return $this->adapter = new TreeServAdapter();
	}
}