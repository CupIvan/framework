<?php
/**
 * Маршрутизация URL
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-06-30
 */
class router
{
	public static function start($pattern = '')
	{
		if (!is_dir($dir = 'post')) return false;
		foreach (scandir($dir) as $fname)
		if (strpos($fname, '.php') !== false)
		if (!$pattern || ($pattern && strpos($fname, $pattern) !== false))
		{
			require_once "$dir/$fname";
		}
	}
	public static function post($url, $handler)
	{
		$res = self::method('POST', $url, $handler);

		if ($res === false && framework::$DEBUG)
		{
			message::show();
			debug::show();
			exit;
		}

		if (!is_null($res)) site::redirect();
	}
	static public function get($url, $handler)
	{
		self::method('GET', $url, $handler);
	}
	private static function method($method, $url, $handler)
	{
		if (request::$method != $method) return NULL;
		if (is_null($m = self::is_url($url))) return NULL;

		$res = $handler($m);

		return $res;
	}
	private static function is_url($url)
	{
		return preg_match('#'.$url.'#', request::$uri, $m) ? $m : NULL;
	}
}
