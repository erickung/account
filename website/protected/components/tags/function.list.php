<?php
function smarty_function_list($params, &$smarty)
{
	if (empty($params['data'])) {
		throw new CException(Yii::t('yiiext', "You should specify data parameters."));
	}
	$data = $params['data'];
	if (empty($data)) return '';

	

	
}