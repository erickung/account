<?php
class MultiImgGenerator 
{
	private $src_img;
	private $src_size;
	
	public function __construct($src_img, array $src_size)
	{
		$this->src_img = $src_img;	
		if (empty($src_size) || count($src_size) !== 2)
			throw new CException("u show input there width and height of the original image!"); 
		$this->src_size = $src_size;
	}
	
	public function run(array $sizes)
	{
		$imgs = array();
		foreach ($sizes as $i => $size)
		{
			$sizes[$i]['img'] = PictureServ::dealImgFromRrcTODest($this->src_img, $this->src_size, $size['size']);
		}
		return $sizes;
	}
	
	
}