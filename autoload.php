<?php
/**
 * @author CupIvan <mail@cupivan.ru>
 * @date 2019-10-14
 */

spl_autoload_register(function($class_name) {
	if ($class_name == 'autoload')
	{
		$fname = 'src/autoload.class.php';
		if (!file_exists($fname))
		{
			@mkdir(dirname($fname), 0755, true);
			$st = file_get_contents('https://raw.githubusercontent.com/CupIvan/framework/master/'.$fname);
			if ($st) file_put_contents($fname, $st);
		}
		require_once $fname;
	}
	else
	autoload::search($class_name);
});
