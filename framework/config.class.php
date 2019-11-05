<?php

class config
{
	static $a = [];
	static function get($k)
	{
		return @self::$a[$k] ?: '';
	}
	static function set($k, $v)
	{
		self::$a[$k] = $v;
	}
}
