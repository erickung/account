<?php
class FileUploader extends UploadAbstract 
{
	function getFileName()
	{
		static $file_name;
		if (!$file_name)  $file_name = rand(0, 1000) . time();
		return $file_name;
	}	
	
	function checkFile()
	{
		return true;
	}
}