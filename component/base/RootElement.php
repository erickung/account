<?php
class RootElement
{
	public static function getCheckBoxData(array $data, $id, $name, array $checked = array())
	{
		$checks = array();
		foreach ($data as $i => $ar)
		{
			if (!$ar instanceof CActiveRecord)
				continue;
		
			$checks[$i]['id'] = $id . $ar->{$id};
			$checks[$i]['boxLabel'] = $ar->{$name};
			$checks[$i]['name'] = $id . '[]';
			$checks[$i]['inputValue'] = $ar->{$id};
			if (in_array($ar->{$id}, $checked))
				$checks[$i]['checked'] = true;
		}
		
		return $checks;
	}
}