<?php
/**
 * Заявки с сайта: CPT «Заявки», обработка формы (AJAX + фолбэк без JS),
 * защита от спама (nonce, honeypot, rate-limit), уведомления на почту
 * и в Telegram.
 *
 * @package Shumoff_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CPT «Заявки»: только админка, без публичных страниц.
 */
function shumoff_register_leads_cpt() {
	register_post_type(
		'leads',
		array(
			'labels'              => array(
				'name'          => 'Заявки',
				'singular_name' => 'Заявка',
				'menu_name'     => 'Заявки',
				'edit_item'     => 'Просмотр заявки',
				'search_items'  => 'Искать заявки',
				'not_found'     => 'Заявок пока нет',
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'menu_position'       => 24,
			'menu_icon'           => 'dashicons-email-alt',
			'supports'            => array( 'title' ),
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ), // Заявки создаёт только форма.
			'map_meta_cap'        => true,
		)
	);
}
add_action( 'init', 'shumoff_register_leads_cpt' );

/**
 * Колонки списка заявок в админке.
 */
function shumoff_leads_columns( $columns ) {
	return array(
		'cb'         => $columns['cb'],
		'title'      => 'Имя',
		'lead_phone' => 'Телефон',
		'lead_car'   => 'Автомобиль',
		'lead_page'  => 'Страница',
		'date'       => 'Дата',
	);
}
add_filter( 'manage_leads_posts_columns', 'shumoff_leads_columns' );

function shumoff_leads_column_content( $column, $post_id ) {
	switch ( $column ) {
		case 'lead_phone':
			$phone = get_post_meta( $post_id, 'lead_phone', true );
			if ( $phone ) {
				printf( '<a href="tel:%s">%s</a>', esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ), esc_html( $phone ) );
			}
			break;
		case 'lead_car':
			echo esc_html( get_post_meta( $post_id, 'lead_car', true ) );
			break;
		case 'lead_page':
			$url = get_post_meta( $post_id, 'lead_page', true );
			if ( $url ) {
				printf( '<a href="%1$s" target="_blank" rel="noopener">%1$s</a>', esc_url( $url ) );
			}
			break;
	}
}
add_action( 'manage_leads_posts_custom_column', 'shumoff_leads_column_content', 10, 2 );

/**
 * Rate-limit по IP: не более 5 заявок за 10 минут.
 *
 * @return bool true, если лимит превышен.
 */
function shumoff_lead_rate_limited() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	if ( '' === $ip ) {
		return false;
	}
	$key   = 'shumoff_lead_rl_' . md5( $ip );
	$count = (int) get_transient( $key );
	if ( $count >= 5 ) {
		return true;
	}
	set_transient( $key, $count + 1, 10 * MINUTE_IN_SECONDS );
	return false;
}

/**
 * Обработка заявки: валидация, сохранение, уведомления.
 *
 * @param array $data Сырые данные ($_POST).
 * @return array { success: bool, message: string, field?: string }
 */
function shumoff_process_lead( $data ) {
	// Honeypot: поле «appt_extra» скрыто стилями; человек его не заполняет.
	// Боту отвечаем «успехом», чтобы не раскрывать защиту.
	// appt_company — старое имя поля, принимаем на случай закэшированных страниц.
	if ( ! empty( $data['appt_extra'] ) || ! empty( $data['appt_company'] ) ) {
		return array(
			'success' => true,
			'message' => 'Заявка отправлена! Мы свяжемся с вами в течение 15 минут.',
		);
	}

	if ( ! isset( $data['shumoff_nonce'] ) || ! wp_verify_nonce( $data['shumoff_nonce'], 'shumoff_appointment' ) ) {
		return array(
			'success' => false,
			'message' => 'Сессия устарела. Обновите страницу и отправьте форму ещё раз.',
		);
	}

	$name  = isset( $data['appt_name'] ) ? sanitize_text_field( wp_unslash( $data['appt_name'] ) ) : '';
	$phone = isset( $data['appt_phone'] ) ? sanitize_text_field( wp_unslash( $data['appt_phone'] ) ) : '';
	$car   = isset( $data['appt_car'] ) ? sanitize_text_field( wp_unslash( $data['appt_car'] ) ) : '';
	$page  = isset( $data['appt_page'] ) ? esc_url_raw( wp_unslash( $data['appt_page'] ) ) : '';

	if ( '' === $name ) {
		return array(
			'success' => false,
			'message' => 'Укажите ваше имя.',
			'field'   => 'name',
		);
	}

	$phone_digits = preg_replace( '/\D/', '', $phone );
	if ( strlen( $phone_digits ) < 10 || strlen( $phone_digits ) > 15 ) {
		return array(
			'success' => false,
			'message' => 'Укажите корректный номер телефона.',
			'field'   => 'phone',
		);
	}

	// Rate-limit считаем только по валидным заявкам, чтобы исправление
	// опечаток в форме не тратило лимит пользователя.
	if ( shumoff_lead_rate_limited() ) {
		return array(
			'success' => false,
			'message' => 'Слишком много заявок подряд. Позвоните нам или попробуйте позже.',
		);
	}

	// Сохраняем заявку — лид не теряется, даже если письмо не дошло.
	$lead_id = wp_insert_post(
		array(
			'post_type'   => 'leads',
			'post_status' => 'publish',
			'post_title'  => $name,
			'meta_input'  => array(
				'lead_phone' => $phone,
				'lead_car'   => $car,
				'lead_page'  => $page,
				'lead_ip'    => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
			),
		),
		true
	);

	$lines = array(
		'Имя: ' . $name,
		'Телефон: ' . $phone,
		'Автомобиль: ' . ( $car ? $car : '—' ),
		'Страница: ' . ( $page ? $page : '—' ),
		'Дата: ' . current_time( 'd.m.Y H:i' ),
	);
	$text = implode( "\n", $lines );

	wp_mail(
		get_option( 'admin_email' ),
		'Новая заявка с сайта Shumoff — ' . $name,
		$text,
		array( 'Content-Type: text/plain; charset=UTF-8' )
	);

	shumoff_lead_notify_telegram( "🔔 Новая заявка с сайта\n" . $text );

	if ( is_wp_error( $lead_id ) ) {
		// Письмо/Telegram отправлены, но запись не создалась — фиксируем в лог.
		error_log( 'Shumoff lead insert failed: ' . $lead_id->get_error_message() );
	}

	return array(
		'success' => true,
		'message' => 'Заявка отправлена! Мы свяжемся с вами в течение 15 минут.',
	);
}

/**
 * Уведомление в Telegram (если в «Настройках сайта» заданы токен и chat_id).
 *
 * @param string $text Текст сообщения.
 */
function shumoff_lead_notify_telegram( $text ) {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}
	$token = (string) get_field( 'notify_telegram_token', 'option' );
	$chat  = (string) get_field( 'notify_telegram_chat', 'option' );
	if ( '' === $token || '' === $chat ) {
		return;
	}

	wp_remote_post(
		'https://api.telegram.org/bot' . rawurlencode( $token ) . '/sendMessage',
		array(
			'timeout'  => 3,
			'blocking' => false, // Не задерживаем ответ пользователю.
			'body'     => array(
				'chat_id' => $chat,
				'text'    => $text,
			),
		)
	);
}

/**
 * AJAX-обработчик формы заявки.
 */
function shumoff_ajax_appointment() {
	$result = shumoff_process_lead( $_POST );
	if ( $result['success'] ) {
		wp_send_json_success( $result );
	}
	wp_send_json_error( $result );
}
add_action( 'wp_ajax_shumoff_appointment', 'shumoff_ajax_appointment' );
add_action( 'wp_ajax_nopriv_shumoff_appointment', 'shumoff_ajax_appointment' );

/**
 * Фолбэк без JavaScript: обычный POST с редиректом.
 */
function shumoff_fallback_appointment() {
	if ( ! isset( $_POST['appt_name'], $_POST['shumoff_nonce'] ) || wp_doing_ajax() ) {
		return;
	}

	$result   = shumoff_process_lead( $_POST );
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$redirect = remove_query_arg( array( 'sent', 'lead_error' ), $redirect );

	if ( $result['success'] ) {
		$redirect = add_query_arg( 'sent', '1', $redirect );
	} else {
		$redirect = add_query_arg( 'lead_error', rawurlencode( $result['message'] ), $redirect );
	}

	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'template_redirect', 'shumoff_fallback_appointment' );
