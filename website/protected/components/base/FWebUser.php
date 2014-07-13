<?php
class FWebUser extends WebUser
{
	function logout($destroySession = true)
	{
		Root::removeCookie(RootConsts::TOKEN);
		header("Location: /site/login");
	}
}