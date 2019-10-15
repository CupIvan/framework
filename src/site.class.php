<?php
/**
 * Основной модуль сайта
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-10-15
 */
class site
{
	public static function start()
	{
		if (request::$method == 'POST')
		{
			if (request::uri('([a-z]+)/([a-z]+)', $m))
			if (method_exists($m[1], $m[2]))
			{
				$method = $m[2];
				$m[1]::$method();
			}
			self::redirect(request::$referer);
		}
	}
	public static function redirect($url = '')
	{
		if (!$url) $url = request::get('redirect');
		if (!$url) $url = request::$uri;
		header('Location: '.$url, 301);
		exit;
	}
}
