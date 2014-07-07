<?php
function smarty_function_select($params, &$smarty) 
{
	if (empty($params['obj']) || empty($params['name'])) {
		throw new CException(Yii::t('yiiext', "You should specify obj and name parameters."));
	}
	$ar = $params['obj'];
	$name = $params['name'];
	$data = $params['data'];
	$label = $ar->labels[$name];
	$class = isset($params['class']) ? $params['class'] : '';

	$select = "<label for='$name' class='control-label'>$label</label><div class='controls'><select class='$class' id='$name' name='$name'>";
	foreach ($data as $k => $v)
	{
		$selected = $ar->{$name} == $k ? 'selected="selected"' : '';

		$select .= "<option value='$k' $selected>$v</option>";
	}
	$select .= '</select></div>';

	return $select;
}