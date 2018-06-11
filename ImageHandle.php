<?php

class ImageHandle
{
	protected $chars = [
		'@',
		'%',
		'#',
		'*',
		'+',
		'=',
		'-',
		':',
		'.',
		' ',
	];
	protected $imageContext = null;
	
	public function check(string $imageUrl)
	{
	
	}
	
	public function getImageInfo(string $imageUrl)
	{
		
	}
}

$chars = [
	'@',
	'%',
	'#',
	'*',
	'+',
	'=',
	'-',
	':',
	'.',
	' ',
];
$imageUrl = 'https://s1.ax1x.com/2018/06/08/Cbn7o8.jpg';
$imageString = file_get_contents($imageUrl);
$imageContext = imagecreatefromstring($imageString);

$imageInfo = getimagesize($imageUrl);
$width = $imageInfo[0];
$height = $imageInfo[1];
$pixelZoomX = 10;
$pixelZoomY = ceil($pixelZoomX / ($width / $height));

$imageNewContext = imagecreatetruecolor($width, $height);
$white = imagecolorallocate($imageNewContext, 255, 255, 255);
imagefill($imageNewContext, 0, 0, $white);
$black = imagecolorallocate($imageNewContext, 0, 0, 0);
for ($y = 0; $y < $height; $y += $pixelZoomY) {
	for ($x = 0; $x < $width; $x += $pixelZoomX) {
		$colors = imagecolorsforindex($imageContext, imagecolorat($imageContext, $x, $y));
		$r = $colors['red'];
		$g = $colors['green'];
		$b = $colors['blue'];
		$a = $colors['alpha'];
		$gray = (0.299 * $r + 0.578 * $g + 0.114 * $b) / 255;
		$index = ceil($gray * (count($chars) - 1));
		$char = $chars[$index];
		//图片
		$color = imagecolorallocate($imageNewContext, $r, $g, $b);
		imagestring($imageNewContext, 1, $x, $y, $char, $color);
		//网页字串
//	    echo "<span style='color:rgb({$r},{$g},{$b});'>#</span>";
		//ToDO 文件字串
	}
//	echo '<br />';
}
header("Content-type: image/png");
imagepng($imageNewContext, 'file.png');
imagedestroy($imageNewContext);

