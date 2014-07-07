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

class ActiveRecordServ
{
	private static $ins;
	private $adapter;
	private $active_record;
	
	private static $imported = false;
	
	private static $displays = array();
	
	public static function Instance($active_record)
	{
		self::import();
		if (self::$ins === null)
			self::$ins = new self();
		
		self::$ins->setActiveRecordHandle($active_record);
		return self::$ins;
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
	
	public function getDataByLike($field, $value, $order=array(), $count=true)
	{
		return $this->getDataByField($field, $value, 'like', $order, $count);
	}
	
	public function getDataByIn($field, array $value, $order=array(), $count=true)
	{
		$value = implode(',', $value);
		return $this->getDataByField($field, $value, 'in', $order, $count);
	}
	
	public function getDataByField($field, $value, $type, $order=array(), $count=true)
	{
		$conds = array($field=>$value);
		$custom = array($field=>$type);
		
		return $this->getData($conds , $custom, $order, $count);
	}
	
	public function getData($conds , $custom = array(), $order=array(), $count=true)
	{
		$data = array('rnt'=>array(),'total'=>0);
	
		$criteria = $this->getConditionByParams($conds, $custom);
		

		if (!empty($order))
			$this->setSort($criteria, $order);
	
		$data['rnt'] = $this->active_record->findAll($criteria);
		
		if($count) $data['total'] = $this->getAdapter()->count($criteria);
	
		return $data;
	}
	
	public function setSort($criteria, array $sort)
	{
		if (empty($sort))
			throw new CException("sort should be an array!");
		if (count($sort) != 2 || !in_array(strtolower($sort[1]), array('desc','asc')) )
			throw new CException("sort should be an array with 2 params and sort[1] should be desc or asc");
		
		if ($this->active_record instanceof CMSActiveRecord)
		{
			$criteria->order = $sort[0] . ' ' . $sort[1];
		}
		elseif ($this->active_record instanceof CMSMongoActiveRecord)
		{
			$sort[1] = ($sort[1] == 'desc'|| $sort[1] == 'DESC') ? -1 : 1;
			//$criteria->sort($sort[0], $sort[1]);
			//$criteria->setSort($sort);
			$order = array($sort[0]=>$sort[1]);
			$criteria->setSort($order);
		}
		else 
		{
			throw new CException("active_record is not the instance of CActiveRecord or EMongoEmbeddedDocument");
		}
	}
	
	/**
	 * 
	 * @param array $custom_cond :
	 * 		自定义查询条件，用于一些非 = 查询的条件，列如：$custom_cond = array('name'=>'like');
	 * 		或者可以这样定义：$custom_cond = array('name'=>array('like', 'or')); 表示是用or来查询的
	 * @param array $reset ：
	 * 		重置查询属性，对于一些前端传过来的查询属性在ar里面并不存在，或者是联表查询的时候需要区别于其他的属性，例如：
	 * 		$reset = array('module_id'=>'module.module_id', 'time_begin'=>array('create_time', '>='), 'time_end'=>array('create_time', '<='))
	 * 		$condition = $OperateLogAR->getCondition(array('opt_username'=>'like'), $reset);
	 * 		$datas = OperateLogAR :: model() ->with('module') -> findAll($condition);
	 * 		第一个module_id的重置属性是用来对module做联表查询用于区分的。
	 * 
	 * @return multitype:
	 */
	public function getCondition(array $custom_cond = array(), array $reset = array())
	{
		$searchs = Request::getFilter();
		$this->adapter = $this->getAdapter(array('searchs'=>$searchs, 'custom_cond'=>$custom_cond, 'reset'=>$reset));
		
		return $this->adapter->getCondition();
	}
	
	public function getConditionByParams(array $params, array $custom_cond = array(), array $reset = array())
	{
		$this->adapter = $this->getAdapter(array('searchs'=>$params, 'custom_cond'=>$custom_cond, 'reset'=>$reset));
		return $this->adapter->getCondition();
	}
	
	public function copyAttributesFromAR(ActiveRecordInterface $ar_from, ActiveRecordInterface $ar_to)
	{
		foreach ($ar_from->getAttributes() as $attr => $value)
		{
			if ($this->active_record->primaryKey() == $attr && (is_null($value) || empty($value)))
				continue;

			if ($ar_from->isTableFiled($attr) && !is_null($ar_from->{$attr})) $ar_to->setAttribute($attr, $value);
		}
	}
	
	public function copyAttributesFromArray(array $arr_from, ActiveRecordInterface $ar_to)
	{
		$attributes = $ar_to->getAttributes();
		$save_rules = $ar_to->saveRule();
		foreach ($attributes as $attr => $v) 
		{
			$value = isset($arr_from[$attr]) ? $arr_from[$attr] : null;
			if ($this->active_record->primaryKey() == $attr && (is_null($value) || empty($value)))
				continue;
			
			if (isset($save_rules[$attr]))
			{
				$rule = $save_rules[$attr];
				if (is_array($rule) && count($rule) == 2)
				{
					if (is_array($rule) && isset($rule[1]) && $rule[1] === 1 && function_exists($rule[0]))
						$value = call_user_func($rule[0], $value);
					elseif (method_exists($rule[0], $rule[1]))
						$value = call_user_func($rule, $value);
				}
				else 
				{
					if (method_exists($ar_to, $rule))
						$value = call_user_func(array($ar_to, $rule), $value);
				}
			}
			$ar_to->setAttribute($attr, $value);
		}
	}
	
	public function setActiveRecordHandle(ActiveRecordInterface $active_record)
	{
		$this->active_record = $active_record;
	}
	
	public function getActiveRecordHandle()
	{
		return $this->active_record;
	}
	
	public function resetDisplays()
	{
		$ar_class = get_class($this->active_record);
		if (!isset(self::$displays[$ar_class]))
			self::$displays[$ar_class] = $this->active_record->displays();
		if (empty(self::$displays[$ar_class])) return;
		
		foreach (self::$displays[$ar_class] as $k => $r)
		{
			if (isset($this->active_record->{$k}))
			{
				if (is_array($r) && count($r) == 2)
				{
					if (method_exists($r[0], $r[1]))
						$this->active_record->{$k} = call_user_func($r, $this->active_record->{$k});
				}
				else
				{
					if (method_exists($this->active_record, $r))
						$this->active_record->{$k} = call_user_func(array($this->active_record, $r), $this->active_record->{$k});
					else
						$this->active_record->{$k} = call_user_func(array('ActiveRecordDisplays', $r), $this->active_record->{$k});
				}
			}
		}
	}
	
	private function getAdapter(array $params = array())
	{	
		if ($this->active_record instanceof CMSActiveRecord)
		{
			return new CActiveRecordAdapter($this->active_record, $params);
		}
		elseif ($this->active_record instanceof CMSMongoActiveRecord)
		{
			return new MongoActiveRecordAdapter($this->active_record, $params);
		}
		else 
		{
			throw new CException("active_record is not the instance of CActiveRecord or EMongoEmbeddedDocument");
		}
	}
	
	private static function import()
	{
		if (!self::$imported)
		{
			Yii::import('application.components.service.active_record.*');
			self::$imported = true;
		}
	}
}