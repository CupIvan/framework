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
		router::start();
		if (request::$method == 'POST')
			self::redirect();
		template::load('index');
	}
	public static function redirect($url = '')
	{
		if (!$url) $url = request::$referer;
		if (!$url) $url = request::get('redirect');
		if (!$url) $url = request::$uri;
		header('Location: '.$url, 301);
		exit;
	}
}
