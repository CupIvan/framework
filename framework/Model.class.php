<?php
/**
 * Интерфейс абстрактной модели
 * @author CupIvan <mail@cupivan.ru>
 * @date   2018-02-18
 */
class Model implements ArrayAccess, Iterator
{
	protected $data = [];

	public function __construct($a = [])
	{
		if ($a instanceOf Model) $a = $a->getData();
		if (is_array($a))
			$this->data = $a;
	}

	public function set(array $data)
	{
		$this->data = $data;
	}
	public function get(string $k, $default='')
	{
		return $this->data[$k] ?? $dafault;
	}
	public function getData()
	{
		$a = $this->data;
		foreach ($a as $k => $v)
			if ($v instanceOf Model) $a[$k] = $v->getData();
			else
			if ($v instanceOf ListModel) $a[$k] = $v->getData();
		return $a;
	}
	public function getInt($k, $default = 0) { return $this->toInt($k, $default); }
	public function getTruncated($k, $length)
	{
		$st = $this->$k;
		return (mb_strlen($st) > $length) ? mb_substr($st, 0, $length - 1).'…' : $st;
	}

	public function toArray() { return $this->getData(); }
	public function toJSON() { return json_encode($this->getData(), JSON_UNESCAPED_UNICODE); }
	public function toInt($k, $default = 0) { return (int)$this->get($k, $default); }
	public function toQuotes($k, $default = '') { return str_replace(['"', '"'], ['&#39;', '&#34;'], $this->get($k, $default)); }
	public function toStrip($k,  $default = '') { return strip_tags($this->get($k, $default)); }
	public function toInput($k,  $default = '') { return $this->toQuotes($k, $default); }
	public function toHtml($k,  $default = '')  { return htmlspecialchars($this->get($k, $default)); }

	public function __unset($k) { unset($this->data[$k]); unset($this->orig[$k]); unset($this->defaults[$k]); }
	public function isEmpty()   { return empty($this->data); }

	/** магические методы */
	public function __get($k) { return $this->get($k); }
	public function __set($k, $v = NULL)
	{
		return $this->data[$k] = $v;
	}
	public function __toString() { return $this->get('title'); }

	/** функции ArrayAccess */
	public function offsetExists($k)  { return $this->__isset($k); }
	public function offsetGet($k)     { return $this->get($k); }
	public function offsetSet($k, $v) { return $this->__set($k, $v); }
	public function offsetUnset($k)   { return $this->__unset($k); }

	/** функции Iterator */
	static $_i_ck, $_i_keys;
	public function rewind()
	{
		self::$_i_keys = array_keys(self::$_i_data);
		self::$_i_ck = 0;
	}
	public function current() { return $this->data[$this->key()]; }
	public function key()   { return isset(self::$_i_keys[self::$_i_ck]) ? self::$_i_keys[self::$_i_ck] : NULL; }
	public function next()  { self::$_i_ck++; }
	public function valid() { return isset($this->data[$this->key()]); }
}
