<?php
/**
 * Модуль для работы с сессией
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-04-11
 */

session_start();

class session
{
	public static function get($k, $default = '')
	{
		return isset($_SESSION[$k]) ? $_SESSION[$k] : $default;
	}
	public static function set($k, $v = true)
	{
		if (is_null($v)) { unset($_SESSION[$k]); return $v; }
		return $_SESSION[$k] = $v;
	}
	public static function add($k, $v)
	{
		if (empty($_SESSION[$k])) $_SESSION[$k] = [];
		$_SESSION[$k] = array_replace_recursive($_SESSION[$k], $v);
		return $_SESSION[$k];
	}
}
