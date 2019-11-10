<?php
/**
 * Таблица MySQL как база данных
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-11-05
 */
namespace db;

class TableSQL implements AbstractDb
{
	protected $tableName = '';

	public function __construct(string $tableName, array $params = [])
	{
		$this->tableName = $tableName;
	}
	public function create(array $fields)
	{
		$sql = mysql::prepare('INSERT INTO `?p` SET ?kv', $this->tableName, @$fields);
		if (!mysql::query($sql)) return NULL;
		return $fields + ['id' => mysql::getLastInsertId()];
	}
	public function search(array $filter, array $params=[]) : array
	{
		$sql  = mysql::prepare('SELECT * FROM `?p`', $this->tableName);
		if (!empty($filter)) $sql .= mysql::prepare('WHERE ?kv', $filter);
		if (!empty($params[$x='order'])) $sql .= mysql::prepare('ORDER BY ?p', $params['order']);
		if (!empty($params[$x='limit'])) $sql .= mysql::prepare('LIMIT ?i', $params['limit']);
		return mysql::getList($sql);
	}
}
