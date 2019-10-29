<?php
/**
 * Инициализация фреймворка
 * @author CupIvan <mail@cupivan.ru>
 * @date 2019-10-14
 */

class framework
{
	static public $TIME_START;
	static public $DEBUG = false;
	static public $URL   = 'https://raw.githubusercontent.com/CupIvan/framework/master/';
	static public $DIR   = 'framework';
}
framework::$TIME_START = microtime(true);

// автозагрузчик классов
spl_autoload_register(function($class_name)
{
	if ($class_name == 'autoload')
	{
		// проверяем, что автозагрузчик установлен
		if (framework::$DEBUG)
		if (!file_exists($fname = framework::$DIR.'/autoload.class.php'))
		if ($st = file_get_contents(framework::$URL.$fname))
		{
			file_put_contents($tmp='/tmp/autoload.php', $st);
			require_once $tmp;
			autoload::download($fname);
		}
		return require_once(framework::$DIR.'/autoload.class.php');
	}
	return autoload::search($class_name);
});
