<?php
function smarty_function_static_text($params, &$smarty)
{

	if (empty($params['name'])) {
		throw new CException(Yii::t('yiiext', "You should specify name  parameters."));
	}

	$name = $params['name'];
	if (isset($params['obj']))
	{
		$ar = $params['obj'];
		$value = !is_null($ar->{$name}) ? CHtml::encode($ar->{$name}) : '';
		$label = $ar->labels[$name];
	} 
	else 
	{
		$value = ($params['value']) ? CHtml::encode($params['value']) : '';
		$label = $params['label'];
	}



	$text = 
<<<TEXT
	<li>
	<span class="item-key">$label</span>
	<div class="vcard-item">$value</div>
	</li>
TEXT;

	return $text;
}