<?php
function smarty_function_require($params,&$smarty)
{
	if (empty($params['file'])) {
		throw new CException(Yii::t('yiiext', "You should specify file parameters."));
	}
	$file = $params['file'];
	$path = '';
	$files = explode('.', $file);
	$file = array_pop($files);
	$dir = array_pop($files);
	$path = !empty($files) ? implode('.', $files) . '.views.' . $dir : "application.views.$dir";

	unset($params['file']);
	foreach ($params as $k=>$v)
		$smarty->assign($k,$v);

	return $smarty->fetch(Yii::getPathOfAlias($path).'/'.$file.'.htm');
}