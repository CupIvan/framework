<?php

class EventChannel
{
	private $subscribers = [];

	public function subscribe($topic, Observer $obj)
	{
		$subscribers[$topic][] = $obj;
	}

	public function publish($topic, $data)
	{
		if (!empty($subscribers[$topic]))
		foreach ($subscribers[$topic] as $obj) $obj->notify($data);
	}
}
