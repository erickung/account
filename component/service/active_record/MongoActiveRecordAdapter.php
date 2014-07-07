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
 * 
 * mongo基础查询生成类，主要用于前端检索是各种查询条件的组装。
 */

class MongoActiveRecordAdapter extends ActiveRecordAdapter 
{
	public function getCondition()
	{
		parent::getCondition();
		
		$criteria = new EMongoCriteria();
		$sort = $this->order();
		if (!empty($sort)) $criteria->sort($sort[0], $sort[1]);
		$criteria->limit($this->limit())->offset($this->offset());
		
		return $this->getConditionParams($criteria);
	}
	
	public function count($criteria)
	{
		$criteria1 = new EMongoCriteria();
		$criteria1->setConditions($criteria->getConditions());
		return $this->active_record->count($criteria1);
	}
	
	private function getConditionParams($criteria)
	{
		if (empty($this->searchs)) return $criteria;
		foreach ($this->searchs as $k => $cond)
		{
			$opt = '==';
			$value = '';
			$relat = 'AND';
			list($k, $cond) = $this->resetCond($k, $cond);
			
			if (is_array($cond) && count($cond) == 3)
			{
				$relat = $cond[0];
				$opt = strtolower($cond[1]);
				$value = $cond[2];
				$this->specialProcessCond($criteria, $opt, $k, $value);
			}
			else
			{
				$cond = $this->convertVal($k, $cond);
				$criteria->$k($opt, $cond);
			}			
		}

		return $criteria;
	}
	
	private function specialProcessCond($criteria, $opt, $k, &$value)
	{
		switch ($opt)
		{
			case 'like':
				$criteria->$k = new MongoRegex("/.*{$value}.*/i");
				break;
			case 'in':
				$v = explode(',', $value);
				foreach ($v as $i => $vv)
					$v[$i] = $this->convertVal($k, $vv);

				$criteria->$k('in', $v);
				break;
			default :
				$value = $this->convertVal($k, $value);
				$criteria->$k($opt, $value);
				break;
		}
	}
	
	private function convertVal($k, $v)
	{
		$rule = $this->active_record->rule();
		if (isset($rule[$k]) && function_exists($rule[$k]))
			return call_user_func($rule[$k], $v);
		
		return $v;
	}
	
	protected function order()
	{
		parent::order();
		if ($this->sort) 
		{
			$dir = (isset($_GET['dir']) && strtolower(trim($_GET['dir'])) == 'asc') ? EMongoCriteria::SORT_ASC : EMongoCriteria::SORT_DESC;
			return array($this->sort, $dir);
		}
		
		return array();
	}
	
	protected function limit()
	{
		return isset($_GET['limit']) ? $_GET['limit'] : 20;
	}
	
	protected function offset()
	{
		return isset($_GET['start']) ? $_GET['start'] : 0;
	}
}