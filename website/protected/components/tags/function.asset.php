<?php
function smarty_function_asset($params, &$smarty) {
    if (empty($params['css']) && empty($params['js'])) {
        throw new CException(Yii::t('yiiext', "You should specify css or js parameters."));
    }

   	if (isset($params['css']))
   		RootSmarty::addCssFile($params['css']);
   	else 
   		RootSmarty::addJsFile($params['js']);
    
    return '';
}