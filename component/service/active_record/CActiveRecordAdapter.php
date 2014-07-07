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
 */
class CActiveRecordAdapter extends ActiveRecordAdapter
{
	public function getCondition()
	{
		parent::getCondition();
		
		$criteria = new CDbCriteria();
		$criteria->order = $this->order();
		$criteria->limit = $this->limit();
		$criteria->offset = $this->offset();
		
		return $this->getConditionParams($criteria);
	}
	
	public function count($criteria)
	{
		$criteria1 = new CDbCriteria();
		$criteria1->condition = $criteria->condition;
		$criteria1->params = $criteria->params;
		return $this->active_record->count($criteria);
	}
	
	private function getConditionParams(CDbCriteria $criteria)
	{
		if (empty($this->searchs)) return $criteria;
			

		foreach ($this->searchs as $k => $cond)
		{
			$p_k = ':'. str_replace('.', '', $k);
			list($k, $cond) = $this->resetCond($k, $cond);

			$con = $this->cond;
			$opt = '=';
			$value = '';
			$relat = 'AND';
			
			if (is_array($cond) && count($cond) == 3)
			{
				$con = $cond;
				$value = $con[2];
				$relat = $con[0];
				$opt = strtolower($con[1]);
			}
			else
			{
				$value = $cond;
			}
			$this->processCond($criteria, $opt, $k, $relat, $value, $p_k);
		}


		return $criteria;
	}
	
	private function getParamKey($key)
	{
		return ':'. str_replace('.', '', $key);
	}
	
	private function processCond(CDbCriteria $criteria, $opt, $k, $relat, &$value, $p_k)
	{
		//$p_k = $this->getParamKey($k);
		switch ($opt)
		{
			case 'like':
				$value = "%{$value}%";
				$criteria->addCondition("$k $opt $p_k", $relat);
				$criteria->params[$p_k] = $value;
				break;
			case 'in':
				if ($value) $value = explode(',', $value);
				$criteria->addInCondition($k, $value, $relat);
				break;
			default :
				$criteria->addCondition("$k $opt $p_k", $relat);
				$criteria->params[$p_k] = $value;
				break;
		}
	}
	
	protected function order()
	{
		parent::order();
		if ($this->sort) return $this->sort . ' ' . $_GET['dir'];
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