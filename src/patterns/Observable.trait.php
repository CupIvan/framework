<?php

trait Observable
{
	private $observers = [];

	public function registerObserver(Observer $obj)
	{
		$this->observers[] = $obj;
	}

	function notifyObservers()
	{
		foreach($this->observers as $obj)
		{
			$obj->notify($this);
		}
	}
}
