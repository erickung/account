<?php
/**
 * //////////////////////////////////////////////////////////////////////////////////////////
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
 * active record基础查询生成类，主要用于前端检索是各种查询条件的组装。
 */
abstract class ActiveRecordAdapter
{	
	protected $active_record;
	protected $cond = array('AND', '=', '');
	
	protected $searchs;
	protected $reset;
	protected $custom_cond;
	
	protected $sort;
	
	public function __construct($active_record, $params)
	{
		$this->active_record = $active_record;
		if (!empty($params))
		{
			foreach ($params as $k => $v)
				$this->{$k} = $v;
		}
	}
	
	protected function processCustom()
	{
		if (empty($this->custom_cond)) return;
		
		foreach ($this->custom_cond as $k => $v)
		{
			if (isset($this->searchs[$k]))
			{
				$vaule = $this->searchs[$k];
				if (is_array($v))
				{
					$this->searchs[$k] = array('AND', $v[0]);
					if (isset($v[1])) $this->searchs[$k][0] = $v[1];
					$this->searchs[$k][2] = $vaule;
				}
				else
				{
					$this->searchs[$k] = array('AND', $v, $vaule);
				}
			}
		}
	}
	
	protected function resetCond($k, $cond)
	{
		if (!isset($this->reset[$k]) || empty($this->reset)) return array($k, $cond);
		$reset = $this->reset[$k];

		if (is_array($reset))
		{
			if ($reset[0]) $k = $reset[0];
			if (isset($reset[1]))
			{
				$value = $cond;
				if (is_array($cond))
					$value = $cond[2];
	
				$cond = $this->cond;
				$cond[1] = $reset[1];
				$cond[2] = $value;
			}
		}
		else
			$k = $reset;

		return array($k, $cond);
	}
	
	protected function getCondition()
	{
		if(!empty($this->searchs))		
		{
			foreach($this->searchs as $k => $v)
			{
				if (!$this->active_record->isTableFiled($k) && !isset($this->reset[$k]))
					unset($this->searchs[$k]);
			}
		}
		
		$this->processCustom();
	}
	
	protected function order()
	{
		if (isset($_GET['sort']))
		{
			if ($this->active_record->isTableFiled($_GET['sort'])) $this->sort = $_GET['sort'];
		}
		else
		{
			$this->sort = $this->active_record->primaryKey();
		}
	}
	
	abstract protected function limit();
	
	abstract protected function offset();
	
	abstract protected function count($criteria);
	
}