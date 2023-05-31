<?php
/*
Plugin Name: TinyBot Starter
Description: Implements basic Telegram Bot functionality. Use this plugin as a starter template. 
Version: 0.0.1
Author: Nikolay Mironov
*/

//При активации плагина сохраняем в базу основные параметры плагина
register_activation_hook( __FILE__, 'tinybot_starter_activation_func' );

function tinybot_starter_activation_func(){
	add_option( 'tinybot_starter_rest_route', 'tinybot_starter', '', true );
	add_option( 'tinybot_starter_route_name', 'main', '', true );
	add_option( 'tinybot_starter_token', '', '', true );
	add_option( 'tinybot_starter_request', '', '', false );
	add_option( 'tinybot_starter_request_data', '', '', false );
	add_option( 'tinybot_starter_request_method', '', '', false );
	add_option( 'tinybot_starter_request_out', '', '', false );
	add_option( 'tinybot_starter_status', '', '', false );
}

//Подключаем файлы со страницей настроек  и логикой бота
include plugin_dir_path( __FILE__ ) . '/utilities/options.php';
include plugin_dir_path( __FILE__ ) . '/utilities/utilities.php';
include plugin_dir_path( __FILE__ ) . '/logic/keyboards.php';
include plugin_dir_path( __FILE__ ) . '/logic/commands.php';

//Задаем end-поинт для общения между сайтом и чат-ботом
//В качестве функции-обработчика используем tinybot_main_function основного плагина
add_action( 'rest_api_init', function(){

	$tinybot_starter_rest_route = get_option('tinybot_starter_rest_route');
	$tinybot_starter_route_name = get_option('tinybot_starter_route_name');
	$tinybot_starter_token = get_option('tinybot_starter_token');
	
	//Основной маршрут для работы с ботом	
	register_rest_route( $tinybot_starter_rest_route, $tinybot_starter_route_name, [
		'methods'  => 'post',
		'callback' => 'tinybot_main_function',
		'args' => array(
			'tinybot_name' => array(
				'default' => 'tinybot_starter',
			),
		),
		'permission_callback' => '__return_true',
	] );

} );
