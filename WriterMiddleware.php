<?php

abstract class WriterMiddleware implements Writer
{
	use Helper;
	
	public $asciis = [
		'@',
		'%',
		'#',
		'*',
		' ',
	];
	
	protected $imageWidth = 0;
	
	protected $imageHeight = 0;
	
	protected $colors = [
		'r'=>0,
		'g'=>0,
		'b'=>0,
		'a'=>0,
	];
	
	public function setImageWidth(int $width)
	{
	    $this->imageWidth = $width;
	}
	
	public function setImageHeight(int $height)
	{
		$this->imageHeight = $height;
	}
	
	public function setColors(array $colors)
	{
	    $this->colors =$colors;
	    return $this->colors;
	}
	public function getAscii()
	{
		return $this->asciis;
	}
	
	public function setAscii(array $chars)
	{
		if(is_array($chars)){
		    $this->asciis = array_merge($this->asciis,$chars);
		}elseif (is_string($chars)){
			array_push($this->asciis,$chars);
		}
		return $this->asciis;
	}
	
	public abstract function init();
	
	public abstract function write(string $ascii,int $x,int $y);
	
	public abstract function save(string $name);
	
	public abstract function destroy();
}