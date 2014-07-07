<?php
abstract class RootMongoActiveRecord extends EMongoDocument implements ActiveRecordInterface, ActiveRecordAppInterface
{
	private static $_mongo_settings; 
	
	public function getMongoDBComponent()
	{		 
		if(self::$_emongoDb===null) 
		{
			if (!isset(self::$_mongo_settings[$this->getCollectionName()]))
				return ;
			
			$server = self::$_mongo_settings[$this->getCollectionName()]['servers'][0];
			self::$_emongoDb = new EMongoDB();
			self::$_emongoDb->connectionString = "mongodb://{$server['host']}:{$server['port']}";
			self::$_emongoDb->dbName = self::$_mongo_settings[$this->getCollectionName()]['dbname'];
			self::$_emongoDb->fsyncFlag = true;
			self::$_emongoDb->safeFlag = true;
		}
	
		return self::$_emongoDb;
	}
	
	public function init()
	{
		self::$_mongo_settings = Corsair::getMongoSetting();
		parent::init();
	}
	
	public function saveCommit($action)
	{
		if (!method_exists($this, $action))
			throw new CException("the " . get_class($this) . "has no method {$action}");
	
		$args = func_get_args();
		array_shift($args);
	
		$is_new = $this->getIsNewRecord();
		try
		{
			call_user_func_array(array($this, $action), $args);
		}
		catch (CDbException $e)
		{
			return false;
		}
	
		OperateLogServ::Instance()->addLogAfterCommit($this, $is_new);
		return true;
	}
	
	
	public function modifyByPk()
	{
		try
		{
			$ar = $this->findByPk($this->getPrimaryKey());
			if (is_null($ar) || !$ar instanceof EMongoEmbeddedDocument)
				return false;
				
			//OperateLogServ::addLogBeforeCommit($ar);
			$this->copyAttributesFromAR($this, $ar);
			$ar->save();
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	public function copyAttributesFromAR($ar_from, $ar_to)
	{
		ActiveRecordServ::Instance($this)->copyAttributesFromAR($ar_from, $ar_to);
	}
	
	public function copyAttributesFromArray($arr_from, $ar_to)
	{
		ActiveRecordServ::Instance($this)->copyAttributesFromArray($arr_from, $ar_to);
	}
	
	public function setAttributesFromRequest(array $res)
	{
		$this->copyAttributesFromArray($res, $this);
	}
	
	public function setAttribute($name,$value)
	{
		if(property_exists($this,$name))
			$this->$name=$value;
		elseif(isset($this->getMetaData()->columns[$name]))
			$this->_attributes[$name]=$value;
		else
			return false;
		return true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCondition(array $custom_cond = array(), array $reset_key = array())
	{
		return ActiveRecordServ::Instance($this)->getCondition($custom_cond, $reset_key);
	}
	
	public function isTableFiled($name)
	{
		$attribute_label = $this->attributeLabels();
		return isset($attribute_label[$name]);
	}
}