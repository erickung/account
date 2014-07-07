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
 * @return string
 */
function smarty_function_c($params, &$smarty) 
{   
	$value = '';
    if ($params['v'])
    	$value = $params['v'];
    return CHtml::encode($value);
}