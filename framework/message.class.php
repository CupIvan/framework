<?php

class message
{
	private static $list = [];
	public static function error($st, $type = '')
	{
		self::$list[] = ['class'=>'error', 'text'=>$st, 'type'=>$type];
		session::set('messages', self::$list);
	}
	public static function show($type = '')
	{
		foreach (session::get('messages', []) as $a)
			echo '<div class="'.$a['class'].'">'.$a['text'].'</div>';
		session::set('messages', NULL);
	}
}
