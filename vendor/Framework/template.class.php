<?php

class template
{
	public static function load($fname = '')
	{
		if (!$fname) $fname = 'index';
		if (!strpos($fname, '.tpl')) $fname .= '.tpl';

		if ($fname == 'index.tpl' && !file_exists($x="tpl/$fname"))
			autoload::download($x);

		@include "tpl/$fname";
	}
}
