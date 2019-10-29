<?php
/**
 * Входные параметры
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-06-05
 */
class request
{
	public static $uri;
	public static $method;
	public static $referer;

	public static function is($k)      { return isset($_REQUEST[$k]); }
	public static function set($k, $v) { return $_REQUEST[$k] = $v; }
	public static function get($k=NULL, $default = '') { if (is_null($k)) return $_REQUEST; return self::is($k) ? $_REQUEST[$k] : $default; }
	public static function getInt($k, $default = 0)  { return self::is($k) ? (int)$_REQUEST[$k] : $default; }
	public static function uri($x, &$m=NULL)
	{
		return preg_match("#$x#", self::$uri, $m);
	}
	public static function url_string($a)
	{
		$st = '';
		$a = array_merge($_REQUEST, $a);
		foreach ($a as $k => $v)
		if (!is_null($v))
			$st .= ($st?'&':'?')."$k=".urlencode($v);
		return $st;
	}
}

request::$uri     = @$_SERVER['DOCUMENT_URI'];
request::$method  = @$_SERVER['REQUEST_METHOD'];
request::$referer = @$_SERVER['HTTP_REFERER'];
