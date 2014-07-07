<?php
function smarty_block_javascript($params, $content, $template, &$repeat) 
{
	if (Yii::app()->request->isAjaxRequest)
	{
		echo '<script type="text/javascript">' . $content . '</script>';
	} 
	else 
	{
		RootSmarty::addJavascript($content);
	}

	
}
