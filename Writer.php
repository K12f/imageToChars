<?php


interface Writer
{
	public function getAscii();
	
	public function setAscii(array $chars);
	
	public function init();
	
	public function write(string $ascii,int $x,int $y);
	
	public function save(string $name);
	
	public function destroy();
}