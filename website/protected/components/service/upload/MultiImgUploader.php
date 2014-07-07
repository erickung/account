<?php
class MultiImgUploader extends CorsairImgUploader
{
	private $multi_sizes = array();
	private $imgs = array();
	private $src_img;
	private $src_img_size = array();
	
	public function upload()
	{
		$this->initFile();
		if(is_object($this->file_obj) && get_class($this->file_obj)==='CUploadedFile')
		{	
			if (!$this->checkFile()) return false;
			$this->src_img = $this->file_obj->getTempName();
			$this->imgs = array($this->src_img);
			$this->src_img_size = array($this->params['width'], $this->params['height']);
		
			if (!$this->generateImgs()) return false;	
			if (!$this->saveImg()) return false;
			 
			return true;
		}
	
		return false;
	}

	/**
	 * 保存图片
	 * @return boolean
	 */
	public function saveImg()
	{
		if (!$this->saveOriginImg()) return false;

		foreach ($this->imgs as $img)
		{
			$this->saveSingleImg($img);
		}

		return true;
	}
	
	/**
	 * 生成图片
	 * @return boolean
	 */
	public function generateImgs()
	{
		$multiImgGenerator = new MultiImgGenerator($this->src_img, $this->src_img_size);
		$this->imgs = $multiImgGenerator->run($this->multi_sizes);
		return true;
	}
	
	public function setPicId($pic_id)
	{
		$this->pic_id = $pic_id;		
	}
	
	/**
	 * 传入多组图片 MultiImgUploader::setMultiSizes(
			array('size'=>array('200','110'), 'suffix'=>'200_110'),
			array('size'=>array('140','90'), 'suffix'=>'')
		);
	 * @param array $multi_sizes
	 */
	public function setMultiSizes(array $multi_sizes)
	{
		$args = func_get_args();
		foreach ($args as $size)
		{
			if (!isset($size['size']) || !isset($size['suffix']))
				throw new CException("the multi_sizes params is wrong"); 			
		}

		$this->multi_sizes = $args;
	}
	
	private function setMultiImgs()
	{
		foreach ($this->multi_sizes as &$size)
		{
			$size['name'] = $this->getUploadDir() . $this->pic_id . $size['suffix'] . '.' . $this->file_obj->extensionName;
		}
	}
	
	private function addImg($img)
	{
		array_push($this->imgs, $img);
	}
	
	private function saveOriginImg()
	{
		$this->saveFile($this->src_img, $this->getFullName(), false);
		$this->copyToUc($this->src_img, $this->file_name);
		return true;
	}
	
	private function saveSingleImg(array $size)
	{
		if (!isset($size['img']) || !$size['img'])
			return '';  

		if ($this->getOtherDir())
		{
			$file = $this->getOtherDir() . $this->pic_id . $size['suffix'] . '.' . $this->ext;
			$this->saveFile($size['img'], $file, false);
		}
	
		$file = $this->getFullUploadDir() . $this->pic_id . $size['suffix'] . '.' . $this->ext;
		$this->saveFile($size['img'], $file);
		$this->copyToUc($size['img'], $this->pic_id . $size['suffix'] . '.' . $this->ext);
		
		if ($size['suffix'] == '_200_110')
		{
			$this->copy_200_110($file, $this->params['videoid'] . $size['suffix'] . '.' . $this->ext);
		} 
		
	}
	
	private function copyToUc($origin, $file)
	{
		$path = $this->getFullUploadDir('video_ugc/' . $this->hash_path);
		$this->saveFile($origin, $path . $file, false);
	}
	
	private function copy_200_110($origin, $file)
	{
		$hash_path = Corsair::callAssist('hash_path', "{$this->params['videoid']}") . '/';
		$path = $this->getFullUploadDir('video/list/' . $hash_path);
		$this->saveFile($origin, $path . $file, false);
	}
}