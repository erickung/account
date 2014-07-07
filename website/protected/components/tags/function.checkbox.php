<?php
function smarty_function_checkbox($params,&$smarty) 
{
	if (empty($params['data']) || empty($params['name']) || empty($params['id'])) {
		//throw new CException(Yii::t('yiiext', "You should specify data and name and id parameters."));
	}
	$data = $params['data'];
	foreach ($data as &$data_tmp)
	{
		foreach ($data_tmp as &$d)
		{
			if (!isset($d[$params['id']]) || !isset($d[$params['name']]))
				throw new CException(Yii::t('yiiext', "You should specify id and name in the data."));
			$d['value'] = $d[$params['id']];
			$d['name'] = $d[$params['name']];
		}
	}

	$smarty->assign('checkbox_data', $data);
	$smarty->assign('checkbox_name', $params['name']);
	
	return $smarty->fetch(Yii::getPathOfAlias('application.views.tags').DS.'checkbox.htm');
}