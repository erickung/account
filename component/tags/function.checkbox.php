<?php
function smarty_function_checkbox($params, &$smarty) 
{
	if (empty($params['data'])) {
		throw new CException(Yii::t('yiiext', "You should specify data parameters."));
	}
	$data = $params['data'];
	$select = CMSArray::getValue($params, 'checked');
	$id = CMSArray::getValue($params, 'id');
	$name = CMSArray::getValue($params, 'name');
	$select = explode(",", $select);
	
	$checks = array();
	foreach ($data as $i => $ar)
	{
		if (!$ar instanceof CActiveRecord)
			continue;
		
		$checks[$i]['id'] = $id . $ar->{$id};
		$checks[$i]['boxLabel'] = $ar->{$name};
		$checks[$i]['name'] = $id . '[]';
		$checks[$i]['inputValue'] = $ar->{$id};
		if (in_array($ar->{$id}, $select))
			$checks[$i]['checked'] = true;
	}
	echo json_encode($checks);
}