<?php
class ARLogServAdapter extends LogServAdapter
{
	protected function getName($ar)
	{
		return get_class($ar);
	}
	
	protected function getLog($ar)
	{
		$data = $ar->getAttributes();
		$noLogFields = $ar->noLogFields();
		foreach ($data as $k => $v)
		{
			if (in_array($k, $noLogFields))
				unset($data[$k]);
			if ($ar instanceof CMSMongoActiveRecord)
			{
				if (is_array($v)) $data[$k] = serialize($v);
			}
		}
		if (self::isModify())
		{
			$data[self::PRIMARY_KEY] = $ar->primaryKey();
			$data[self::PRIMARY_VALUE] = $ar->getPrimaryKey();
		}
		return $data;
	}
	
	protected function getLabels($ar)
	{
		return $ar->attributeLabels();
	}
}