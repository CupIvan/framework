<?php

class rest
{
	public static function not_auth($message='unknow')
	{
		self::send(['error'=>$message], 301);
	}
	public static function not_implemented($message='unknow')
	{
		self::send(['error'=>$message], 501);
	}
	public static function error($message='unknow')
	{
		self::send(['error'=>$message], 500);
	}
	public static function send($a, $code=200)
	{
		$res = $a;

		if (is_object($a) && $a instanceOf Model)
			$res = $a->toJSON();
		if (is_array($a))
			$res = json_encode($a, JSON_UNESCAPED_UNICODE);

		// https://ru.wikipedia.org/wiki/Список_кодов_состояния_HTTP
		$code_st = [
			200 => 'OK',
			401 => 'Unauthorized',
			404 => 'Not Found',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
		]; $code_st = $code_st[$code] ?? '';
		header("HTTP/1.1 $code ".$code_st);
		header("Content-type: application/json; charset: UTF-8");
		echo $res;
		exit;
	}
}
