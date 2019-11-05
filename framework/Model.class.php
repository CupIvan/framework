<?php
/**
 * Интерфейс абстрактной модели
 * @author CupIvan <mail@cupivan.ru>
 * @date   2018-02-18
 */
class Model implements ArrayAccess, Iterator
{
	protected $data = [];
	protected $orig = [];
	protected $defaults = [];

	public function __construct($a = [])
	{
		if ($a instanceOf Model) $a = $a->getData();
		if (is_array($a))
		{
			$this->orig = $a;
			foreach ($a as $k=>$v)
				if ($this->__validate($k, $v)) { if ($v != $this->orig[$k]) $this->data[$k] = $v; }
				else unset($this->orig[$k]);
		}
	}

	public function get($k, $params=[])
	{
		if (isset($this->data[$k])) return $this->data[$k];
		if (isset($this->orig[$k])) return $this->orig[$k];
		if (isset($this->defaults[$k])) return $this->defaults[$k];
		$this->defaults[$k] = $v = $this->__get_default($k, $params);
		if (is_null($v) && !is_array($params)) return $params; // default value
		return $v;
	}
	public function getOriginal($k)
	{
		return isset($this->orig[$k]) ? $this->orig[$k] : NULL;
	}
	public function getFields($f)
	{
		if (is_string($f)) $f = explode(',', $f);
		$res = [];
		foreach ($f as $field)
				$res[$field] = $this->get($field);
		return new Model($res);
	}
	public function filterFields($f)
	{
		if (is_string($f)) $f = explode(',', $f);
		$res = array_intersect_key($this->data + $this->orig, array_fill_keys($f, 1));
		return new Model($res);
	}
	public function setDefaults($a)
	{
		$this->defaults = array_merge($a);
	}
	public function setDefault($k, $v)
	{
		$this->defaults[$k] = $v;
	}
	public function setData($data)
	{
		$this->data = $data;
	}
	public function updateData($data)
	{
		foreach ($data as $k => $v) $this->$k = $v;
	}
	public function update($a) { foreach ($a as $k => $v) $this->$k = $v; }
	public function getData()
	{
		$a = $this->data + $this->orig;
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

	public function __get_default($k, $params=[]) { return NULL; }
	public function __validate($k, &$v) { return true; }
	public function __unset($k) { unset($this->data[$k]); unset($this->orig[$k]); unset($this->defaults[$k]); }
	public function isChanged($k) { return serialize(@$this->data[$k]) != serialize(@$this->orig[$k]); }

	/** магические методы */
	public function __isset($k) { return isset($this->data[$k]) || isset($this->orig[$k]); }
	public function __get($k) { return $this->get($k); }
	public function __set($k, $v = NULL)
	{
		if (!$this->__validate($k, $v)) return $v;
		if (@$this->orig[$k] === $v) return $v;
		return $this->data[$k] = $v;
	}
	public function __toString() { return $this->get('title', ''); }

	/** функции ArrayAccess */
	public function offsetExists($k)  { return $this->__isset($k); }
	public function offsetGet($k)     { return $this->get($k); }
	public function offsetSet($k, $v) { return $this->__set($k, $v); }
	public function offsetUnset($k)   { return $this->__unset($k); }

	/** функции Iterator */
	static $_i_ck, $_i_data, $_i_keys;
	public function rewind()
	{
		self::$_i_data = $this->data + $this->orig;
		self::$_i_keys = array_keys(self::$_i_data);
		self::$_i_ck = 0;
	}
	public function current() { return self::$_i_data[$this->key()]; }
	public function key()   { return isset(self::$_i_keys[self::$_i_ck]) ? self::$_i_keys[self::$_i_ck] : NULL; }
	public function next()  { self::$_i_ck++; }
	public function valid() { return isset(self::$_i_data[$this->key()]); }
}
