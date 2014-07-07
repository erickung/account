<?php
function smarty_block_form($params, $content, $template, &$repeat) 
{
	//<form action="/admin/user/userEdit" method="POST" class="form-horizontal">
	//<form name="__form" id="__form" target="__hidden_call" onSubmit="return JKB.submit.post(this,'task/task_create_dispose','{$action}');">
	if ($repeat) { //tag opened
		if (!isset($params['name']) || !isset($params['action'])  ) 
			throw new CException("Name parameter should be specified.");
	 	
		$action = $params['action'];
		unset($params['action']);
		$params['onSubmit'] = "return eric.request.post(this,'$action');";
		$params['target'] = "__hidden_call";
		
		$form = "<form ";
		foreach ($params as $k => $v)
			$form .= ' ' . $k . '="' . $v . '"';
		$form .= ">";
		echo $form;
	}
	else  //tag closed
	{
		echo $content;
	       echo "</form>";
	    
	}
}
