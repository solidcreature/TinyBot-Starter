<?php 
add_action('tinybot_start_message_hook','tinybot_starter_start', 10, 3);
add_action('tinybot_commands_hook','tinybot_starter_chatid', 10, 3);
add_action('tinybot_no_commands_hook','tinybot_starter_nocommand', 10, 3);

//Отправляем привественное сообщение
function tinybot_starter_start($from_id, $message, $person_id) {
	$text = 'TinyBot Starter for Telegram v0.0.1';	
	$keyboard = tinybot_default_keyboard('default');	
	
	tinybot_send($from_id, $text, $keyboard);
	
	exit('ok');
}

//Отправляем участнику его ID в Телеграме
function tinybot_starter_chatid($from_id, $message, $person_id) {
	if ($message != 'Узнать свой ID') return;
	
	$text = 'Ваш ID в Телеграме: <code>' . $from_id . '</code>';	
	tinybot_send($from_id, $text);
	
	exit('ok');
}

//Отправляем привественное сообщение
function tinybot_starter_nocommand($from_id, $message, $person_id) {
	$text = 'Бот не распознал команду <em>' . $message . '</em>';	
	tinybot_send($from_id, $text);
	
	exit('ok');
}
