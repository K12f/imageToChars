<?php
require_once './Helper.php';
require_once './Writer.php';
require_once './WriterMiddleware.php';
require_once './ImageWriter.php';
require_once './FileWriter.php';
require_once './HtmlWriter.php';
require_once './ImageHandle.php';
$imageUrl = 'https://s1.ax1x.com/2018/06/08/Cbn7o8.jpg';

$writer = new ImageWriter($type=1);
$imageHandle = new ImageHandle($writer,$imageUrl,5);
$imageHandle->start('hello.png');
