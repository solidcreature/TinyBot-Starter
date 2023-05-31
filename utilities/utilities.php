<?php
//Сохраняем данные последнего сообщения в опциях сайта
add_action('tinybot_check_request','tinybot_starter_save_message_data',3,99);
add_action('tinybot_starter_save_request_data','tinybot_starter_save_request_data_func',2,99);
add_action('tinybot_starter_save_request_out','tinybot_starter_save_request_out_func',1,99);



function tinybot_starter_save_message_data($from_id, $chat_id, $data) {
	update_option('tinybot_starter_request', $data);
}

function tinybot_starter_save_request_data_func($method, $data) {
	update_option('tinybot_starter_request_method', $method);
	update_option('tinybot_starter_request_data', $data);
}

function tinybot_starter_save_request_out_func($out) {
	update_option('tinybot_starter_request_out', $out);
}


//Функция
function tinybot_starter_show_log_info() {
	
	echo '<style>pre {	display: block;	padding: 9.5px;	margin: 0;	line-height: 1.42857143;	color: #333;	word-break: break-all;	word-wrap: break-word;
	background-color: #f9f9f9;	border: 1px solid #ccc;	border-radius: 1px;	white-space: pre-wrap;	overflow: auto; margin-right: 20px; }</style>';

	echo '<h1>Данные последнего сообщения отправленного в бот</h1>';	
	echo '<pre>';
	print_r(get_option('tinybot_starter_request'));
	echo '</pre>';
	
	echo '<h1>Ответ сформированный системой</h1>';	
	echo '<pre>';
	print_r(get_option('tinybot_starter_request_data'));
	echo '</pre>';
	
	echo '<h1>Ответ API телеграма</h1>';	
	echo '<pre>';
	print_r(get_option('tinybot_starter_request_out'));
	echo '</pre>';
	
}

//Функция отвечающая за отображение статуса плагина
function tinybot_starter_show_status_info() {
	$bot_token = get_option('tinybot_starter_token');
	
	if (!isset($bot_token))  {
		echo '<h1>Токен бота еще не задан. Доступ к статусу бота закрыт</h1>';
		return;
	}	
	
	echo '<style>pre {	display: block;	padding: 9.5px;	margin: 0;	line-height: 1.42857143;	color: #333;	word-break: break-all;	word-wrap: break-word;
	background-color: #f9f9f9;	border: 1px solid #ccc;	border-radius: 1px;	white-space: pre-wrap;	overflow: auto; margin-right: 20px; }</style>';
		
	echo '<h1>Текущее состояние бота и базовая информация</h1>';
	echo '<pre>';
	global $tinybot_name;
	$tinybot_name = 'tinybot_starter';
	$webhook_info = tinybot_get_webhook_info();
	echo tinybot_get_info();
	echo 'URL: ' . $webhook_info->url . PHP_EOL;
	echo 'IP Address: ' . $webhook_info->ip_address . PHP_EOL;
	echo 'Has Custom Certificate: ' . $webhook_info->has_custom_certificate . PHP_EOL;
	echo 'Pending Update Count: ' . $webhook_info->pending_update_count . PHP_EOL;
	echo 'Max Connections: ' . $webhook_info->max_connections . PHP_EOL;	
	if (isset($webhook_info->last_error_date)) {
		echo 'last_error_date: ' . date('j F Y, H:i:s', $webhook_info->last_error_date) . PHP_EOL;	
		echo 'last_error_message: ' . $webhook_info->last_error_message . PHP_EOL;	
	}	
	echo '</pre>';
}