<?php

trait PropertyContainer
{
	private $propertyContainer = [];

	public function setProperty($k, $v)
	{
		$this->propertyContainer[$k] = $v;
	}

	public function getProperty($k)
	{
		return $this->propertyContainer[$k] ?? NULL;
	}

	public function deleteProperty($k)
	{
		unset($this->propertyContainer[$k]);
	}
}
