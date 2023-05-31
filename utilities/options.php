<?php
//Регистрируем страницу настроек плагина в админ-панели
function tinybot_starter_register_settings_page() {
  add_submenu_page( 'tinybot-main', 'TinyBot Starter', 'TinyBot Starter', TINY_BOT_CAPABILITY, 'tinybot_starter', 'tinybot_starter_show_options_page', 100 );
  add_submenu_page( 'tinybot-main', 'Статус TinyBot Starter', '— Статус бота', TINY_BOT_CAPABILITY, 'tinybot_starter_status', 'tinybot_starter_show_status_info', 110 );
  add_submenu_page( 'tinybot-main', 'Логирование TinyBot Starter', '— Логирование', TINY_BOT_CAPABILITY, 'tinybot_starter_logging', 'tinybot_starter_show_log_info', 120 );
  
  
}

add_action('admin_menu', 'tinybot_starter_register_settings_page');


//Страница настроек плагина TinyBot Starter
function tinybot_starter_show_options_page() {
	echo '<form method="POST" action="options.php">';
		settings_fields( 'tinybot_starter' ); 
		do_settings_sections( 'tinybot_starter' ); 
		submit_button();
	echo '</form>';
	
	?>
	<div class="tg-starter__webhook">
			<?php 
				$site = site_url(); 
				$tinybot_starter_token = trim( get_option('tinybot_starter_token') );
				$tinybot_starter_rest_route =  trim( get_option('tinybot_starter_rest_route') );
				$tinybot_starter_route_name =  trim( get_option('tinybot_starter_route_name') );
				
				$link = "https://api.telegram.org/bot" . $tinybot_starter_token . "/setWebhook?url=" . $site . "//wp-json/" . $tinybot_starter_rest_route . "/" . $tinybot_starter_route_name;
				
				if ($tinybot_starter_token):
					echo '<h3>' . __( 'Для работы бота необходимо подключить веб-хук, пройдя по этой ссылке:', 'tg_starter' ) . '</h3>';
					echo '<p><a href="' . $link . '" target="_blank">' . $link . '</a></p>';
					echo '<p>' . __( 'Сайт должен работать по протоколу https с активным установленным SSL сертификатом', 'tg_starter' ) . '</p>';
				endif;	
			?>	
		</div><!-- webhhok -->
		<?php 
}



//Регистрация полей для страницы настроек TinyBotStarter
add_action( 'admin_init', 'tinybot_starter_options_init' );

function tinybot_starter_options_init() {

	add_settings_section(
		'tinybot_starter_section', 
		'Настройки плагина TinyBot Starter',
		'tinybot_starter_section_callback_function',
		'tinybot_starter' 
	);

	add_settings_field(
		'tinybot_starter_rest_route',
		'REST API Route',
		'tinybot_starter_rest_route_callback_function', // можно указать ''
		'tinybot_starter', // страница
		'tinybot_starter_section' // секция
	);
	
	add_settings_field(
		'tinybot_starter_route_name',
		'Route Name',
		'tinybot_starter_route_name_callback_function', // можно указать ''
		'tinybot_starter', // страница
		'tinybot_starter_section' // секция
	);	
	
	
	add_settings_field(
		'tinybot_starter_token',
		'Telegram Bot Token',
		'tinybot_starter_token_callback_function', // можно указать ''
		'tinybot_starter', // страница
		'tinybot_starter_section' // секция
	);	


	// Регистрируем опции, чтобы они сохранялись при отправке
	// $_POST параметров и чтобы callback функции опций выводили их значение.
	register_setting( 'tinybot_starter', 'tinybot_starter_rest_route' );
	register_setting( 'tinybot_starter', 'tinybot_starter_route_name' );
	register_setting( 'tinybot_starter', 'tinybot_starter_token' );
}

/**
 * Сallback функция для секции.
 *
 * Функция срабатывает в начале секции, если не нужно выводить
 * никакой текст или делать что-то еще до того как выводить опции,
 * то функцию можно не использовать для этого укажите '' в третьем
 * параметре add_settings_section
 *
 * @return void
 */
function tinybot_starter_section_callback_function() {
	echo '<p>Текст описывающий блок настроек</p>';
}


function tinybot_starter_token_callback_function() {
	?>
	<input
		name="tinybot_starter_token"
		type="text"
		value="<?= esc_attr( get_option( 'tinybot_starter_token' ) ) ?>"
		class="code2"
	 />
	<?php
}

function tinybot_starter_rest_route_callback_function() {
	?>
	<input
		name="tinybot_starter_rest_route"
		type="text"
		value="<?= esc_attr( get_option( 'tinybot_rest_route' ) ) ?>"
		class="code2"
	 />
	<?php
}


function tinybot_starter_route_name_callback_function() {
	?>
	<input
		name="tinybot_starter_route_name"
		type="text"
		value="<?= esc_attr( get_option( 'tinybot_starter_route_name' ) ) ?>"
		class="code2"
	 />
	<?php
}

