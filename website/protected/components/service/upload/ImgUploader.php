<?php
class ImgUploader extends UploadAbstract
{
	private static $filename;
	
	public function __construct(){}
	
	private $allowed_exts = array(
		'png','gif','jpg'		
	);
	
	public function getFileName()
	{
		if (self::$filename !== null) return self::$filename;
		
		return self::$filename = substr(md5(WebUser::Instance()->user->user_id . time()), 0, 11);
	}
	
	public function getFileRef()
	{
		return $this->getFilePath();
	}

	public function checkFile()
	{
		if (!$this->checkSize()) return false;
		
		$mime_types = CMS::loadFileConf(Yii::getPathOfAlias('system.utils.mimeTypes') . '.php') ;
		$imagesize = getimagesize($this->file_obj->getTempName());
		$ext = strtolower($this->ext);
		if (!in_array($ext, $this->allowed_exts) || !$imagesize || $imagesize['mime'] != $mime_types[$ext])
		{
			$this->error = '不合法的类型';
			return false;
		}
		
		if ((isset($this->params['width']) && abs($this->params['width'] - $imagesize[0]) > 1 && $this->params['width']>0)
				|| (isset($this->params['height']) && abs($this->params['height'] - $imagesize[1]) > 1 && $this->params['height']>0))
		{
			$this->error = '上传图片必须是长度为：' . $this->params['width'] . ' 高度为：' . $this->params['height'];
			return false;
		}
		
		return true;
	}
}