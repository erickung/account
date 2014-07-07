<?php
function smarty_function_text($params, &$smarty)
{

	if (empty($params['name']) || empty($params['label'])) {
		throw new CException(Yii::t('yiiext', "You should specify name and label parameters."));
	}

	$name = $params['name'];
	$value = ($params['value']) ? CHtml::encode($params['value']) : '';
	$label = $params['label'];

	$text = 
<<<TEXT
	<div class="control-group formSep">
		<label class="control-label" for="$name">$label</label>
		<div class="controls">
			<input type="text" name="$name"  value="$value" class="input-xlarge" id="$name">
		</div>
	</div>
TEXT;

	return $text;
}