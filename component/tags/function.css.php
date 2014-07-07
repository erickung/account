<?php
/**
 *
 * Syntax:
 * {c v="text value"}
 *
 * @see CHtml::encode().
 *
 * @param array $params
 * @param Smarty $smarty
 */
function smarty_function_css($params, &$smarty) {
    if (empty($params['file'])) {
        throw new CException(Yii::t('yiiext', "You should specify file parameters."));
    }

    $file = $params['file'];
    CMSSmartyController::addCssFile($file);
    
    return '';
}