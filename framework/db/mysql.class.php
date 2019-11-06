<?php
/**
 * Класс для работы с MySQL
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-10-15
 */
namespace db;
class mysql
{
	public static $host = 'localhost';
	public static $user = 'root';
	public static $pass = '';
	public static $base = '';

	public static $history = [];

	private static $connection = NULL;
	private static $handlers   = NULL;

	public static function getList(string $sql) : array
	{
		$res = [];
		$q = self::query($sql);
		if (!$q) return [];
		while ($row = mysqli_fetch_assoc($q))
			$res[] = $row;
		return $res;
	}

	public static function getItem(string $sql) : array
	{
		$q = self::query($sql);
		if (!$q) return false;
		return mysqli_fetch_assoc($q);
	}

	public static function on(string $action, callable $handler)
	{
		self::$handlers["on_$action"] = $handler;
	}

	public static function fire(string $action, $params=NULL)
	{
		if (empty(self::$handlers["on_$action"])) return NULL;
		return self::$handlers["on_$action"]($params);
	}

	public static function prepare(string $sql, ...$params)
	{
		$counter = 0;
		$sql = preg_replace_callback('#\?(s|i|f|p|ai|kv)#', function($a) use (&$counter, $params){
			$value = $params[$counter++];
			switch ($a[1])
			{
				case 'p':  return $value;
				case 'i':  return (int)$value;
				case 'f':  return (float)$value;
				case 's':  return '"'.str_replace('"', '\\"', $value).'"';
				case 'ai': return json_encode($value);
				case 'kv':
					$st = '';
					foreach ($value as $k => $v)
						$st .= ($st?', ':'')."`$k` = ".'"'.str_replace('"', '\\"', $v).'"';
					return $st;
			}
			return NULL;
		}, $sql);
		return " $sql \n";
	}

	public static function connect()
	{
		if (!is_null(self::$connection)) return true;

 		if (!self::$connection = @mysqli_connect(self::$host, self::$user, self::$pass))
		{
			self::fire('connect_error');
			return false;
		}
		if (!mysqli_select_db(self::$connection, self::$base))
		{
			self::fire('db_error');
			return false;
		}
		return true;
	}

	public static function query($sql)
	{
		if (!self::connect()) return false;
		$t = microtime(true);
		$res = @mysqli_query(self::$connection, $sql);
		self::$history[] = ['sql'=>$sql, 'time'=>$t, 'duration'=>microtime(true)-$t, 'errno'=>mysqli_errno(self::$connection), 'error'=>mysqli_error(self::$connection)];
		if (!$res) { self::fire('query_error', $sql); return false; }
		return $res;
	}

	public static function getLastInsertId()
	{
		return mysqli_insert_id(self::$connection);
	}
}

mysql::on('connect_error', function(){ die('Невозможно подключиться к базе данных!'); });
mysql::on('db_error',      function(){ die('База данных не настроена!'); });
