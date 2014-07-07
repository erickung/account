<?php
function smarty_function_select($params, &$smarty) 
{
	if (empty($params['data'])) {
		throw new CException(Yii::t('yiiext', "You should specify data parameters."));
	}
	$data = $params['data'];
	$select = CMSArray::getValue($params, 'select');
	$key = CMSArray::getValue($params, 'key');
	$value= CMSArray::getValue($params, 'value');
	$arr = CMS::convertARToOptions($data, $key, $value);
	array_unshift($arr, array('all', CMSArray::getValue($params, 'text')));
	
	return json_encode($arr);
}