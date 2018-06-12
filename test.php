<?php

require_once 'AutoLoader.php';
(new AutoLoader());
$imageUrl = 'https://s1.ax1x.com/2018/06/08/Cbn7o8.jpg';

$writer = new ImageWriter($type=1);
$imageHandle = new ImageHandle($writer,$imageUrl,5);
$imageHandle->start('hello.png');
