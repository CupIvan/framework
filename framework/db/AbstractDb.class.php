<?php
/**
 * Абстрактный интерфейс баз данных
 * @author CupIvan <mail@cupivan.ru>
 * @date   2019-11-05
 */
namespace db;

interface AbstractDb
{
	public function create(array $filter);
	public function search(array $filter, array $params=[]) : array;
}
