<?php

class mysql
{
	public static $host = 'localhost';
	public static $user = 'root';
	public static $pass = '';
	public static $base = '';

	private static $connection = NULL;
	private static $handlers   = NULL;

	public static function getList($sql)
	{
		$res = [];
		$q = self::query($sql);
		while ($row = mysqli_fetch_assoc($q))
			$res[] = $row;
		return $res;
	}

	public static function on($action, $handler)
	{
		self::$handlers["on_$action"] = $handler;
	}

	private static function connect()
	{
		if (!is_null(self::$connection)) return true;

		if (!self::$connection = @mysqli_connect(self::$host, self::$user, self::$pass))
		{
			self::$handlers['on_connect_error']();
			return false;
		}
		if (!mysqli_select_db(self::$connection, self::$base))
		{
			self::$handlers['on_db_error']();
			return false;
		}
		return true;
	}

	private static function query($sql)
	{
		if (!self::connect()) return false;
		$res = @mysqli_query(self::$connection, $sql);
		return $res;
	}
}

mysql::on('connect_error', function(){ die('Невозможно подключиться к базе данных!'); });
mysql::on('on_db_error',   function(){ die('База данных не настроена!'); });
