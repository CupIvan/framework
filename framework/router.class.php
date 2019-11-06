<?php
/**
 * Маршрутизация URL
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-06-30
 */
class router
{
	private static $is_search = true;

	static public function start($pattern = '')
	{
		if (!is_dir($dir = 'post')) return false;
		foreach (scandir($dir) as $fname)
		if (strpos($fname, '.php') !== false)
		if (!$pattern || ($pattern && strpos($fname, $pattern) !== false))
		{
			require_once "$dir/$fname";
			if (self::$is_search) break; // COMMENT: если где-то сработал обработчик - остальные пропускаем
		}
	}
	static public function post($url, $handler)
	{
		if (request::$method == 'POST')
		if (self::$is_search)
		{
			$m = self::is_url($url);
			if (is_null($m)) return false;
			$res = $handler($m);

			if ($res === false && framework::$DEBUG)
			{
				message::show();
				debug::show();
				exit;
			}

			self::$is_search = false;
			site::redirect();
		}
		return false;
	}
	static private function is_url($url)
	{
		return preg_match('#'.$url.'#', request::$uri, $m) ? $m : NULL;
	}
}
