<?php


namespace gradebook;


trait TSingleton
{
	private static $instance;

    protected function __construct() {}

	public static function instance()
	{
		if (self::$instance === null) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}