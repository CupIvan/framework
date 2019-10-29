<?php
/**
 * Модуль отладки
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-10-28
 */
class debug
{
	public static  $info = [];
	private static $is_init = false;
	private static $is_show = false;

	public function __destruct()
	{
		self::show();
	}

	public static function show()
	{
		self::$info['session']  = $_SESSION??[];
		self::$info['request']  = $_REQUEST;
		self::$info['cookies']  = $_COOKIE;
		self::$info['server']   = $_SERVER;
		self::$info['memory']   = memory_get_usage();
		self::$info['time_end'] = microtime(true);
		if (self::$is_show) return false; else self::$is_show = true;
		template::load('debugbar');
	}

	public static function info($msg)
	{
		return self::msg($msg, 'INFO');
	}
	public static function warn($msg)
	{
		return self::msg($msg, 'WARN');
	}
	public static function critical($msg)
	{
		return self::msg($msg, 'CRIT');
	}
	public static function print($obj)
	{
		self::init();
		self::$info['print'][] = $obj;
	}

	private static function init()
	{
		if (self::$is_init) return;
		$GLOBALS['g_debug'] = new debug;
		self::$is_init = true;
	}
	private static function msg($msg, $type)
	{
		self::init();
		self::$info['log'][] = ['time'=>microtime(true), 'type'=>$type, 'msg'=>$msg];
	}
}

debug::$info['time_start'] = $GLOBALS['TIME_START'] ?? microtime(true);
