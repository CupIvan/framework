<?php
/**
 * Таблица MySQL как база данных
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-11-05
 */
namespace db;

class MysqlTable implements AbstractDb
{
	private $tableName = '';

	public function __construct($base, $tableName, $user=NULL, $pass=NULL, $host=NULL)
	{
		$this->tableName = $tableName;
		if (!is_null($x=$base)) mysql::$base = $x;
		if (!is_null($x=$user)) mysql::$user = $x;
		if (!is_null($x=$pass)) mysql::$pass = $x;
		if (!is_null($x=$host)) mysql::$host = $x;
	}
	public function search(array $filter, array $params=[]) : array
	{
		$sql = mysql::prepare('SELECT * FROM `?p` WHERE ?kv', $this->tableName, @$filter);
		if (!empty($params[$x='limit'])) $sql .= mysql::prepare('LIMIT ?i', $params['limit']);
		return mysql::getList($sql);
	}
}
