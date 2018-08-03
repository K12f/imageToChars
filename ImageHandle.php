<?php

class ImageHandle
{
	protected $_allowMimes = [
		'image/jpeg',
		'image/png',
		'image/jpg',
		'image/gif',
	];
	
	protected $imageUrl = '';
	protected $pixelZoomX = 10;
	protected $pixelZoomY = 0;
	protected $imageInfo = [];
	protected $imageContext = null;
	protected $writerContext = null;
	
	/**
	 * ImageHandle constructor.
	 * @param WriterMiddleware $writerContext
	 * @param string $imageUrl
	 * @param int $pixelZoomX
	 */
	public function __construct(WriterMiddleware $writerContext,string $imageUrl,int $pixelZoomX=10)
	{
		$this->writerContext = $writerContext;
		$this->imageUrl = $imageUrl;
		$this->pixelZoomX = $pixelZoomX;
	}
	
	/**
	 * @param string $name
	 */
	public function start(string $name)
	{
		try {
			$this->validate($this->imageUrl);
			$this->imageContext = $this->getContext($this->imageUrl);
			$this->writerContext->setImageWidth($this->imageInfo[0]);
			$this->writerContext->setImageHeight($this->imageInfo[1]);
			$this->writerContext->init();
			$this->setZoomY();
			$this->scan($this->imageContext, $this->imageInfo[0],$this->imageInfo[1]);
			
			$this->writerContext->save($name);
			$this->writerContext->destroy();
			$code = 200;
			$message ='ok';
		} catch (Exception $e) {
			$code = $e->getCode();
			$message = $e->getMessage();
		}
		echo json_encode(['code'=>$code,'message'=>$message]);
		exit();
	}
	
	/**
	 * @param $imageContext
	 * @param int $width
	 * @param int $height
	 * @return array
	 * @throws Exception
	 */
	protected function scan($imageContext,  int $width, int $height)
	{
		$result = [];
		for ($x = 0; $x < $width; $x+=$this->pixelZoomX) {
			for ($y = 0; $y < $height; $y+=$this->pixelZoomY) {
				$colors = imagecolorsforindex($imageContext, imagecolorat($imageContext, $x, $y));
				if (empty($colors)) {
					throw new \Exception('获取图片颜色失败', 400);
				}
				$this->writerContext->setColors($colors);
				
				$gray = $this->writerContext->getGray($colors);
				$ascii = $this->writerContext->gray2ascii($this->writerContext,$gray);
				$this->writerContext->write($ascii,$x,$y);
			}
		}
		return $result;
	}
	
	/**
	 * @param string $imageUrl
	 * @throws Exception
	 */
	protected function validate(string $imageUrl)
	{
		if (empty($imageUrl)) {
			throw new \Exception('获取图片失败', 400);
		}
		//是否是一个图片
		if (!in_array(get_headers($imageUrl, 1)['Content-Type'], $this->_allowMimes, true)) {
			throw new \Exception('非法的图片', 400);
		}
		$this->imageInfo = $this->getImageInfo($imageUrl);
		if (!in_array($this->imageInfo['mime'], $this->_allowMimes, true)) {
			throw new \Exception('非法的图片类型', 400);
		}
		
	}
	
	/**
	 * @param string $imageUrl
	 * @return resource
	 */
	protected function getContext(string $imageUrl)
	{
		$imageString = file_get_contents($imageUrl);
		return imagecreatefromstring($imageString);
	}
	
	/**
	 * @param string $imageUrl
	 * @return array|bool
	 * @throws Exception
	 */
	protected function getImageInfo(string $imageUrl): array
	{
		$imageInfo = getimagesize($imageUrl);
		if (empty($imageInfo)) {
			throw new \Exception('获取图片类型失败', 400);
		}
		return $imageInfo;
	}
	
	public function setZoomY()
	{
		$this->pixelZoomY =(int)ceil($this->pixelZoomX/($this->imageInfo[0]/$this->imageInfo[1]));
		return $this->pixelZoomY;
	}
	
}