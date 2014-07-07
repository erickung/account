<?php
function smarty_function_text2($params, &$smarty)
{

	if (empty($params['name1']) || empty($params['name2'])) {
		throw new CException(Yii::t('yiiext', "You should specify name1 and name2 parameters."));
	}
	
	

	$name1 = $params['name1'];
	$value1 = ($params['value1']) ? CHtml::encode($params['value1']) : '';
	$label1 = $params['label1'];
	
	$name2 = $params['name2'];
	$value2 = ($params['value2']) ? CHtml::encode($params['value2']) : '';
	$label2 = $params['label2'];


	$text = 
<<<TEXT
	<div class="control-group formSep">
		<div class="span6">
			<label for="$name1" class="control-label">$label1</label>
			<div class="controls">
				<input type="text" name="$name1" id="$name1" class="input" value="$value1">
			</div>
		</div>
		<div class="span6">
			<label for="$name2" class="control-label">$label2</label>
			<div class="controls">
				<input type="text" name="$name2" id="$name2" class="input" value="$value2">
			</div>
		</div>
	</div>
TEXT;

	return $text;
}