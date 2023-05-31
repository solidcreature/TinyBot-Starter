<?php 
add_filter( 'tinybot_get_default_keyboard_rows', 'tinybot_starter_default_keyboards', 10, 2 );

function tinybot_starter_default_keyboards($rows = array(), $type = 'default') {
	if ($type == 'default') {
		$rows[] = array('Узнать свой ID');
	}

	return $rows;
}