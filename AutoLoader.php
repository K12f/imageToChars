<?php


class AutoLoader
{
	public function __construct()
	{
	    spl_autoload_register([$this,'loader']);
	}
	public function loader($className)
	{
		$className .='.php';
		if(file_exists($className)){
		    require_once $className;
		}
	}
}