<?php
class CategoryTreeServ 
{
	private $originalList;
	private $pk;
	private $parentKey;
	private $childrenKey;
	
	function __construct($pk = "cid", $parentKey = "pid", $childrenKey = "children") {
		if (!empty($pk) && !empty($parentKey) && !empty($childrenKey)) {
			$this -> pk = $pk;
			$this -> parentKey = $parentKey;
			$this -> childrenKey = $childrenKey;
		} else {
			return false;
		}
	}
	// 载入初始数组
	public function load($data) {
		if (is_array($data)) {
			$this -> originalList = $data;
		}
	}
	
	public function deepTree($root = 0) {
		if (!$this -> originalList) {
			return false;
		}
		$originalList = $this -> originalList;
		$tree = array();
		$refer = array();
	
		foreach($originalList as $k => $v) {
			if (!isset($v[$this -> pk]) || !isset($v[$this -> parentKey]) || isset($v[$this -> childrenKey])) {
				unset($originalList[$k]);
				continue;
			}
			$v[$this -> pk] = intval($v[$this -> pk]);
			$v[$this -> parentKey] = intval($v[$this -> parentKey]);
			$refer[$v[$this -> pk]] = &$originalList[$k];
		}
	
		foreach($originalList as $k => $v) {
			if ($v[$this -> parentKey] == $root) {
				$tree[] = &$originalList[$k];
			} else {
				if (isset($refer[$v[$this -> parentKey]])) {
					$parent = &$refer[$v[$this -> parentKey]];
					$parent[$this -> childrenKey][] = &$originalList[$k];
				}
			}
		}
		return $tree;
	}
	
	public function formatTree(&$cate){
		foreach($cate as &$val){
			if(empty($val[$this -> childrenKey])){
				$val['leaf'] = true;
			}else{
				$this->formatTree($val[$this -> childrenKey]);
			}
		}
	}
}

?>