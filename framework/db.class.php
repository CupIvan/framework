<?php
/**
 * Фасад для баз данных
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-11-05
 */
class db
{
	private static $db = [];
	public static function set($name, $obj)
	{
		self::$db[$name] = $obj;
	}
	public static function get($name)
	{
		return self::$db[$name] ?? new db\AbstractDb();
	}
}
