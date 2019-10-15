<?php

class autoload
{
	/** автоподгрузка */
	public static function search($class_name)
	{
		if (!self::load_local($class_name))
		if (self::download("src/$class_name.class.php"))
			self::load_local($class_name);
	}
	/** скачивание файла из репозитория github */
	public static function download($fname)
	{
		$content = @file_get_contents('https://raw.githubusercontent.com/CupIvan/framework/master/'.$fname);
		if ($content)
		{
			@mkdir(dirname($fname), 0755, true);
			@file_put_contents($fname, $content);
			return true;
		}
		return false;
	}
	/** автоподгрузка из локальной папки */
	private static function load_local($class_name)
	{
		if (!file_exists($x="./src/$class_name.class.php")) return false;
		require_once $x;
		return true;
	}
}
