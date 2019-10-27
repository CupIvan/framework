<?php
/**
 * Подгрузка шаблонов
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-10-15
 */
class template
{
	public static $base = '.';

	public static function load($fname = '')
	{
		if (!$fname) $fname = 'index';
		if (!strpos($fname, '.tpl')) $fname .= '.tpl';

		$x = $x=self::$base."/tpl/$fname";
		if ($fname == 'index.tpl' && !file_exists($x))
			autoload::download("/tpl/$fname");

		@include $x;
	}
}

template::$base = getcwd();
