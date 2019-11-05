<?php

class autoload
{
	/** автоподгрузка */
	public static function search($class_name)
	{
		$class_name = str_replace('\\', '/', $class_name);
		if (!self::load_local($class_name))
		if (self::download("framework/$class_name.class.php"))
			self::load_local($class_name);
	}
	/** скачивание файла из репозитория github */
	public static function download($fname)
	{
		// если файл на локальном диске - просто создаём символьную ссылку на него
		if (file_exists($x=getcwd().'/'.framework::$URL.$fname))
		{
			$dir = dirname($fname);
			if (!is_dir($dir)) mkdir($dir, 0777, 1);
			return symlink($x, $fname);
		}
		// иначе пробуем скачать из инета
		$content = @file_get_contents(framework::$URL.$fname);
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
		if (!file_exists($x="./framework/$class_name.class.php")) return false;
		require_once $x;
		return true;
	}
}
