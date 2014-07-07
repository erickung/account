<?php
abstract class LogServAdapter implements RootLog
{
	const BEFORE_COMMIT = 'before';
	const AFTER_COMMIT = 'after';
	const ADD_COMMIT = 'add';
	const DEL_COMMIT = 'del';
	const FIELD = 'field';
	
	const PRIMARY_KEY = 'pk';
	const PRIMARY_VALUE = 'pv';
	const LOG_IMPLODE_TAG = ' ';

	public $module_id;
	public static $status = 0;		// 0=>修改；1=>添加；-1=>删除
	protected static $logs = array();
	protected static $log_num = 0;
	protected static $ar_labels = array();
	protected static $original_data = array();
	private static $name;
	
	abstract protected function getName($log);
	abstract protected function getLog($log);
	
	public function addLogBeforeCommit($log)
	{
		self::$log_num++;
		self::$name = $this->getName($log);
		$this->init();
	
		self::$logs[self::$name][self::BEFORE_COMMIT][self::$log_num] = $this->getLog($log);
		self::$ar_labels[self::$name] = $this->getLabels($log);
	}
	
	public function addLogAfterCommit($log)
	{
		if (self::isAdd() )	//新增
		{
			self::$name = $this->getName($log);
			$this->init();
			self::$logs[self::$name][self::ADD_COMMIT][++self::$log_num] = $this->getLog($log);
			self::$ar_labels[self::$name] = $this->getLabels($log);
		}
		elseif (self::isDel())	//	删除
		{
			self::$name = $this->getName($log);
			$this->init();
			self::$logs[self::$name][self::DEL_COMMIT][++self::$log_num] = $this->getLog($log);
			self::$ar_labels[self::$name] = $this->getLabels($log);
		}
		else		//修改
		{
			self::$logs[self::$name][self::AFTER_COMMIT][self::$log_num] = $this->getLog($log);
		}
		
		self::$status = 0;
	}

	public function saveLog()
	{
		if (!$this->module_id) return;
		
		$log = new OperateLogAR();
		$log->operation_record = $this->getLogData();
		if (!$log->operation_record) return ;
		$log->opt_username = WebUser::Instance()->user->user_name;
		$log->module_id = $this->module_id;
		$log->create_time = new CDbExpression('NOW()');
		$log->add();
		
		self::$status = 0;
	}
	
	protected function getLabels($log)
	{
		return $log;
	}
	
	public function setAdd()
	{
		self::$status = 1;
	}
	
	public function setDel()
	{
		self::$status = -1;
	}
	
	public function setModify()
	{
		self::$status = 0;
	}
	
	public function isDel()
	{
		return self::$status == -1;
	}
	
	public function isAdd()
	{
		return self::$status == 1;
	}
	
	public function isModify()
	{
		return self::$status == 0;
	}
	
	protected function getLogtext($logs)
	{
		$text_insert = array();
		$text_del = array();
		$text_modify = array();
		
		foreach ($logs as $ar_name => $log)
		{
			if (isset($log[self::BEFORE_COMMIT]))
			{
				foreach ($log[self::BEFORE_COMMIT] as $i => $ll)
				{
					foreach ($ll as $k => $v) 
						$text_modify[$i][] = array(self::$ar_labels[$ar_name][$k], $v, $log[self::AFTER_COMMIT][$i][$k]);		
				}	
			}
	
			if (isset($log[self::ADD_COMMIT]))
			{
				foreach ($log[self::ADD_COMMIT] as $i => $ll)
				{
					foreach ($ll as $k => $v)
						$text_insert[$i][$k] = array(self::$ar_labels[$ar_name][$k], $v);
				}
			}
			
			if (isset($log[self::DEL_COMMIT]))
			{
				foreach ($log[self::DEL_COMMIT] as $i => $ll)
				{
					foreach ($ll as $k => $v)
						$text_del[$i][$k] = array(self::$ar_labels[$ar_name][$k], $v);
				}
			}
		}
		$text = array();
		if (!empty($text_modify)) $text['modify'] = $text_modify;
		if (!empty($text_insert)) $text['insert'] = $text_insert;
		if (!empty($text_del)) $text['del'] = $text_del;
		return !empty($text) ? json_encode($text) : '';
	}
	
	protected function getLogItemData($log_data)
	{
		$logs = array();
		if (!empty($log_data[self::BEFORE_COMMIT]) && empty($log_data[self::AFTER_COMMIT])) return $logs;
	
		if (!empty($log_data[self::BEFORE_COMMIT])) 
		{
			foreach ($log_data[self::BEFORE_COMMIT] as $i => $log)
			{
				if (!isset($log_data[self::AFTER_COMMIT][$i]))
					continue;
			
				$diff = array_diff_assoc($log_data[self::AFTER_COMMIT][$i], $log);
			
				foreach ($diff as $field => $v)
				{
					$logs[self::BEFORE_COMMIT][$i][$field] = $log[$field];
					$logs[self::AFTER_COMMIT][$i][$field] = $v;
				}
				if (!empty($logs[self::BEFORE_COMMIT][$i]))
				{
					$logs[self::BEFORE_COMMIT][$i][$log[self::PRIMARY_KEY]] = $log[self::PRIMARY_VALUE];
					$logs[self::AFTER_COMMIT][$i][$log[self::PRIMARY_KEY]] = $log[self::PRIMARY_VALUE];
				}
			}
			
		}
		
		if (!empty($log_data[self::ADD_COMMIT])) 
			$logs[self::ADD_COMMIT] = $log_data[self::ADD_COMMIT];
		
		if (!empty($log_data[self::DEL_COMMIT])) 
			$logs[self::DEL_COMMIT] = $log_data[self::DEL_COMMIT];

		return $logs;
	}

	private function init()
	{
		if (!isset(self::$logs[self::$name]))
			self::$logs[self::$name] = array(
					self::BEFORE_COMMIT => array(),
					self::AFTER_COMMIT => array(),
					self::ADD_COMMIT => array(),
					self::DEL_COMMIT => array(),
			);
	}
	
	private function getLogData()
	{
		if (empty(self::$logs)) return '';
		$logs = array();
		foreach (self::$logs as $ar_name => $log_data)
		{
			$logs[$ar_name] = $this->getLogItemData($log_data);
		}

		return self::getLogtext($logs);
	}
	
}