<?php
class FWebUser extends WebUser
{
	function logout()
	{
		Root::removeCookie(RootConsts::TOKEN);
		header("Location: /site/login");
	}
}