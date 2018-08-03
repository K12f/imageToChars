<?php

require_once 'AutoLoader.php';
(new AutoLoader());
$imageUrl = 'https://s1.ax1x.com/2018/08/03/P0jM2F.jpg';

$writer = new ImageWriter($type=2);
$imageHandle = new ImageHandle($writer,$imageUrl,5);
$imageHandle->start('hello.png');
