<?php
class CorsairImgUploader extends ImgUploader
{
	protected $pic_id;
	protected $pic_dir =  array(
			'SPICHEAD_FOLDER' => 'staff/head/',
			'SPHOTO_FOLDER' => 'staff/photos/',
			'SBGND_FOLDER' => 'staff/background/',
			'SFOCUS_FOLDER' => 'staff/focus/',
			'LIVE_FOLDER' => 'live/',
			'LIVE_PRE_FOLDER' => 'live/pre/',
			'AD_FOLDER' => 'ad/',
			'MEDIA_FOLDER' => 'media/program/',
			'TAG_FOLDER' => 'tags/',
			'UBGND_FOLDER' => 'user/background/',
			'MSERIAL_FOLDER' => 'media/serials/',
			'VIDEO_FOLDER' => 'video/',
			'VIDEO_LIST_FOLDER' => 'video/list/',
			'MEDIA_TOP_PIC_FOLDER' => 'media/top/',
			'VIDEO_UGC_FOLDER' => 'video_ugc/',
			'EVENT_FOLDER' => 'event/',
			'POST_FOLDER' => 'post/',
			'ENT_FOLDER' => 'ent/',
			'SPECIAL_FOLDER' => 'special/',
			'FOCUS_FOLDER' => 'focus/',
			'LOGO_FOLDER' => 'logo/',
			'USERCARD' => 'usercard/',
			'SMGBB_FOLDER' => 'smgbb/',
			'VOTE_FOLDER' => 'voteimg/',
			'SOURCE_FOLDER' => 'source/',
			'NEWS_FOLDER' => 'news/',	
	);
	protected $videoMaps = array(
			'normal'=>'video',
			'news'=>'news',
			'ugc'=>'video_ugc',
	);
	protected $base_path;	//基本路径 如：'video/'
	protected $hash_path;		//hash生成的路径 如：'274/34/4'
	protected $other_path;		//video需要向两个目录上传图片
	private $type;
	private $custom_name = '';			//保存的file名称
	private $custom_suffix = '';			//保存的file的别名后缀

	
	public function __construct()
	{
		parent::__construct();
		$this->pic_id = Corsair::getRedisCounter(CMSConsts::COUNT_PIC);
	}
	
	public function initFile()
	{
		if ($this->params['type']) $this->type = $this->params['type'];
		parent::initFile();
	}
	
	public function getFileRef()
	{
		return PICTURE_URL . $this->getFilePath();
	}
	
	public function setUploadPath($upload_path)
	{
		$this->upload_path = PICTURES;
		return $this;
	}
	
	public function seCustomName($name)
	{
		$this->custom_name = $name;
	}
	
	public function setCustomSuffix($name)
	{
		$this->custom_suffix = $name;
	}
	
	protected function getUploadDir()
	{
		if (!$this->type)
			throw new CDbException("u show task the param type [video, media]"); 
		$func = 'get' . ucfirst($this->type) . 'Path';
		
		if (!method_exists($this, $func)) 
			throw new CDbException("u show task method $func");
		
		$this->base_path = call_user_func(array($this, $func));
		$this->hash_path = Corsair::callAssist('hash_path', "{$this->pic_id}") . '/';

		if ($this->isVideo()) $this->other_path = $this->base_path . 'list/' . $this->hash_path;

		return $this->base_path . $this->hash_path;
	}
	
	protected function getEntPath()
	{
		return 'ent/';
	}
	
	protected function getVideoPath()
	{
		if (!isset($this->params['videoid']))
			throw new CDbException("u show task the param videoid"); 
		
		$corsair_pic_type = "";
		Yii::import('application.modules.media.ar.*');
		
		$video_class = VideoAR::getVideoClassbyVideoid($this->params['videoid']);
		if(in_array($video_class, array_keys($this->videoMaps)))
		{
			$corsair_pic_type = $this->videoMaps[$video_class];
		}
		else
		{
			throw new CDbException("ur video class is error[$video_class]");
		}
		
		return $this->pic_dir[strtoupper($corsair_pic_type . '_FOLDER')];
	} 
	
	public function getFileName()
	{
		return ($this->custom_name) ? $this->custom_name : $this->pic_id . $this->custom_suffix;
	}
	
	/**
	 * 根据小视频id获取视频类型
	 * @param unknown $videoid
	 * @return string
	 */
	public function getVideoPicTypeByVideoid($videoid)
	{
		$corsair_pic_type = "";
		Yii::import('application.modules.media.ar.*');
		$video_class = VideoAR::getVideoClassbyVideoid($videoid);
		if(in_array($video_class, array_keys($this->videoMaps)))
			$corsair_pic_type = $this->videoMaps[$video_class];
		
		return $corsair_pic_type;
	}
	
	protected function isVideo()
	{
		return $this->type == CMSConsts::VIDEO;
	}
	
	protected function getOtherDir()
	{
		if (!$this->other_path) return '';

		return $this->getFullUploadDir($this->other_path);
	}
}