<?php


trait Helper
{
	/**
	 * @param WriterMiddleware $writerMiddleware
	 * @param float $gray
	 * @return string
	 */
	public function gray2ascii(WriterMiddleware $writerMiddleware,float $gray)
	{
		$index = (int)ceil($gray / 255* (count($writerMiddleware->asciis)-1));
		return array_key_exists($index,$writerMiddleware->asciis)?$writerMiddleware->asciis[$index]:"@";
//		return "@";
	}
	
	/**
	 * @param array $colors
	 * @return float
	 */
	public function getGray(array $colors)
	{
		return (0.299 * $colors['red'] + 0.578 * $colors['green'] + 0.114 * $colors['blue']);
	}
}