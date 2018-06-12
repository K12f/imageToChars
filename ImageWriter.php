<?php


class ImageWriter extends WriterMiddleware
{

	/**
	 * 1:彩色,2:灰色
	 * @var int
	 */
	protected $type = 1;
	
	protected $imageContext = null;
	
	protected $white = null;
	
	protected $black = null;
	
	public function __construct(int $type=1)
	{
		$this->type = $type;
	}
	
	public function init()
	{
		$this->imageContext = imagecreatetruecolor($this->imageWidth,$this->imageHeight);
		$this->white = imagecolorallocate($this->imageContext, 255, 255, 255);
		imagefill($this->imageContext, 0, 0, $this->white);
	}
	
	public function write(string $ascii,int $x,int $y)
	{
		if($this->type===2){
	    	$gray = $this->getGray($this->colors);
		    $color = imagecolorallocate(  $this->imageContext, $gray, $gray, $gray);
		    imagestring($this->imageContext,1,$x,$y,$ascii,$color);
	    }else {
		    $color = imagecolorallocate(  $this->imageContext, $this->colors['red'], $this->colors['blue'], $this->colors['green']);
		    imagestring($this->imageContext,1,$x,$y,$ascii,$color);
	    }
	}
	
	public function save(string $name)
	{
		header("Content-type: image/png");
		imagepng($this->imageContext,$name);
		imagedestroy($this->imageContext);
	}
	
	public function destroy()
	{
	}
}