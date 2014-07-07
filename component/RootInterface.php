<?php
interface RootInterface
{
	
}

interface ActiveRecordInterface
{	
	/** 数据展现时转换 **/
	const ARRAY_TO_STR = 'arrayTostring';
	const TIME_TO_DATE = 'date';
	const STATUS = 'status';
	const INT = 'intval';
	
	public function isTableFiled($name);
	
	public function primaryKey();
	
	public function setAttribute($name, $value);
	
	public function getAttributes();
	
	public function getIsNewRecord();
	
	public function displays();
	
	/**
	 * 无需记录日志的字段
	 */
	public function noLogFields();
	
	public function saveRule();
}

interface ActiveRecordAppInterface
{	
	public function getCondition(array $custom_cond, array $resets);
	
	public function copyAttributesFromAR($from, $to);
	
	public function copyAttributesFromArray($from, $to);
}

interface RootLog
{
	public function addLogBeforeCommit($log);
	
	public function addLogAfterCommit($log);
	
	public	function saveLog();
}