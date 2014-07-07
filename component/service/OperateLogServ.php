<?php
class OperateLogServ implements RootLog
{	
	private static $ins;
	private $adapter;
	private static $imported = false;
	private static $types = array(
			'ar' => 'ARLogServAdapter'	,
	);
	
	public static function Instance($type = 'ar')
	{
		self::import();
		if (self::$ins === null)
			self::$ins = new self();

 		if (!isset(self::$types[$type]))
			$type = 'ar';
		self::$ins->setAdapter(new self::$types[$type]);
		
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
	
	public function showLog($log)
	{
		$log = json_decode($log, true);
		$text = '<html><body>';
		$text_modify = isset($log['modify']) ? $log['modify'] : array();
		$text_insert = isset($log['insert']) ? $log['insert'] : array();
		$text_del = isset($log['del']) ? $log['del'] : array();		
			
		$text .= $this->getLogTable($text_modify, 'modify');
		$text .= $this->getLogTable($text_insert, 'add');
		$text .= $this->getLogTable($text_del, 'del');
		$text .= "</body></html>";
		return $text;
	}
	
	private function getLogTable(array $log, $type)
	{
		if (empty($log)) return '';
		$table = '';
		foreach ($log as $i => $ll)
		{
			$text = '<table border="1" cellpadding="3" cellspacing="1" width="1200" align="center" style="text-align: center;background-color: #b9d8f3;font-size:14px;line-height:20px;table-layout:fixed; ">';
			if($type == 'modify') $text .= '<col style="width: 12%" /><col style="width: 44%" /><col style="width: 44%" /><thead style="font-weight:bold;"><tr><td>字段</td><td>修改前</td><td>修改后</td>';
			if($type == 'add') $text .= '<col style="width: 20%" /><col style="width: 80%" /><thead style="font-weight:bold;"><tr><td>字段</td><td>添加值</td>';
			if($type == 'del') $text .= '<col style="width: 20%" /><col style="width: 80%" /><thead style="font-weight:bold;"><tr><td>字段</td><td>删除值</td>';
			$text .= '</tr></thead>';
			$text .= " <tbody>";
			foreach ($ll as $l)
			{
				if($type == 'modify')
					$t =  "<td width='12%'>" . $l[0] . "</td><td width='40%' style='word-wrap:break-word;white-space:pre-wrap;'>" . $l[1] . "</td><td style='word-wrap:break-word;white-space:pre-wrap;' width='40%'>" . $l[2] . "</td>";
				else 
					$t = "<td>" . $l[0] . "</td><td style='word-wrap:break-word;white-space:pre-wrap;'>" . $l[1] . "</td>";
				$text .= '<tr cellspacing="1" style="text-align: center; COLOR: #0076C8; BACKGROUND-COLOR: #F4FAFF;font-size:14px;line-height:20px ">' . $t . '</tr>';
			}
			$text .= " </tbody></table>";
			$table .= $text;
		}
		return $table;
	}
	
	private static function import()
	{
		if (!self::$imported)
		{
			Yii::import('application.components.service.log.*');
			self::$imported = true;
		}
	}
	
	public function addLogBeforeCommit($log)
	{
		return $this->getAdapter()->addLogBeforeCommit($log);
	}
	
	public function addLogAfterCommit($log)
	{		
		return $this->getAdapter()->addLogAfterCommit($log);
	}
	
	public function setModuleId($module_id)
	{
		$this->getAdapter()->module_id = $module_id;
		return $this;
	}
	
	public function setIsAdd()
	{
		$this->getAdapter()->setAdd();
		return $this;
	}
	
	public function setIsDel()
	{
		$this->getAdapter()->setDel();
		return $this;
	}
	
	public function setModify()
	{
		$this->getAdapter()->setModify();
		return $this;
	}
	
	public function saveLog()
	{
		return $this->getAdapter()->saveLog();
	}
	
	private function setAdapter(LogServAdapter $adpt)
	{
		$this->adapter = $adpt;
	}
	
	private function getAdapter()
	{
		return $this->adapter;
	}
}