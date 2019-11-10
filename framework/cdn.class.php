<?php

class cdn
{
	public static function add($lib, $version = NULL)
	{
		if ($lib == 'react') { $x = $version ?? '16';?>
<script src="https://unpkg.com/react@<?=$x?>/umd/react.development.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@<?=$x?>/umd/react-dom.development.js" crossorigin></script>
<?
		}
		if ($lib == 'bootstrap') { $x = $version ?? '4.3.1';?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/<?=$x?>/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/<?=$x?>/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?
		}
		if ($lib == 'jquery') { $x = $version ?? '3.3.1';?>
	<script src="https://code.jquery.com/jquery-<?=$x?>.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<?
		}
		if ($lib == 'popper') { $x = $version ?? '1.14.7';?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/<?=$x?>/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<?
		}
	}
}
