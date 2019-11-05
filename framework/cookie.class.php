<?php

class cookie
{
	static $salt = 'default cookie salt';

	public static function get($k, $default = NULL)
	{
		$k = str_replace('.', '_', $k);
		if (empty($_COOKIE[$k])) return $default;
		$v = $_COOKIE[$k];
		$x = explode('_', $v);
		return ($v == self::salt_value($x[0])) ? $x[0] : $default;
	}
	public static function set($k, $v, $days = 30)
	{
		setcookie($k, $_COOKIE[$k] = self::salt_value($v), time() + $days * 24 * 3600, '/');
	}
	public static function clear($k)
	{
		setcookie($k, '', time(), '/');
		unset($_COOKIE[$k]);
	}
	private static function salt_value($v)
	{
		return $v.'_'.substr(md5($v.self::$salt), -4);
	}
}
