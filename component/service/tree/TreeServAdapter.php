<?php
class TreeServAdapter
{
	protected $data;
	protected $pk;
	protected $parentKey;
	protected $tree;
	
	const CHILDREN = 'children';
	const PARENT_ID = 0;
	
	public function __construct()
	{
		
	}
	
	public function load(array $config)
	{
		if (!isset($config['node']) || !isset($config['pnode']))
			throw new CException("you should give node and pnode");

		$this->pk = $config['node'];
		$this->parentKey = $config['pnode'];
		
		if (isset($config['data']))
			$this->data = $config['data'];
	}
	
	public function genTree()
	{
		if ($this->tree === null)
			$this->tree = $this->deepTree();

		$this->formatTree($this->tree);
		return $this->tree;
	}
	
	public function getChildren($id)
	{
		if ($this->tree === null)
			$this->tree = $this->deepTree();
		
		$this->getChild($this->tree);
		return $this->tree;
	}
	
	protected function deepTree($root = 0) {
		if (!$this->data) 
			throw new CException("where is no data load");
		
		$originalList = $this->data;
		$tree = array();
		$refer = array();
	
		foreach($originalList as $k => $v) 
		{
			if (!isset($v[$this->pk]) || !isset($v[$this->parentKey]) || isset($v[self::CHILDREN])) 
			{
				unset($originalList[$k]);
				continue;
			}
			$refer[$v[$this->pk]] = &$originalList[$k];
		}
	
		foreach($originalList as $k => $v) {
			if ($this->isRoot($v[$this->parentKey])) 
			{
				$tree[] = &$originalList[$k];
			} else
			{
				if (isset($refer[$v[$this->parentKey]])) 
				{
					$parent = &$refer[$v[$this->parentKey]];
					$parent[self::CHILDREN][] = &$originalList[$k];
				}
			}
		}
		return $tree;
	}
	
	private function getChild(&$data) 
	{
		foreach($data as $key => &$val) {
			$val['childrens'][] = $val['cid'];
			if (!empty($val['children'])) {
				$val['children'] = $this->formatCate($val['children']);
				foreach($val['children'] as &$vv) {
					$val['childrens'] = array_merge($data[$key]['childrens'], $vv['childrens']);
				}
			}
		}
		return $data;
	}
	
	protected function formatTree(&$v)
	{
		foreach($v as &$val)
		{
			if (isset($val['leaf']) && $val['leaf'] == false) continue;
			if(empty($val[self::CHILDREN]))
				$val['leaf'] = true;
			else
				$this->formatTree($val[self::CHILDREN]);
		}
	}
	
	
	protected function isRoot($v)
	{
		return $v == self::PARENT_ID;
	}
}