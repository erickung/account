<?php
function smarty_function_table($params,&$smarty)
{
	if (empty($params['fields'])) {
		throw new CException(Yii::t('yiiext', "You should specify fields parameters."));
	}
	
	if (!isset($params['list']) || empty($params['list']))
		throw new CException(Yii::t('yiiext', "You should specify list parameters."));
	
	$fields = $params['fields'];
	$list = $params['list'];
	$ar = $list[0];
	
	$names = array();
	foreach ($fields as $filed)
	{
		
	}
	
		 

	
	return 111;
	//return $smarty->fetch(Yii::getPathOfAlias($path).'/'.$file.'.htm');
}