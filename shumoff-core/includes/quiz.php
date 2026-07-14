<?php
/**
 * Квиз-калькулятор стоимости (ТЗ: docs/quiz_calculator.md).
 *
 * Серверная часть: конфигурация шагов с ценами из реального прайса,
 * AJAX-приём лида с той же защитой, что и у формы заявки
 * (nonce, honeypot, rate-limit), пересчёт сметы на сервере,
 * уведомления на почту и в Telegram, UTM-метки.
 *
 * @package Shumoff_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Классы авто в квизе → тип кузова в прайсе.
 *
 * @return array[]
 */
function shumoff_quiz_classes() {
	return array(
		'sedan'      => array(
			'label' => 'Легковой (Седан / Хэтчбек)',
			'body'  => 'Седан-Хэтчбэк',
		),
		'crossover'  => array(
			'label' => 'Кроссовер / Минивэн',
			'body'  => 'Кроссовер',
		),
		'suv'        => array(
			'label' => 'Внедорожник',
			'body'  => 'Внедорожник',
		),
		'commercial' => array(
			'label' => 'Коммерческий транспорт',
			'body'  => 'Микроавтобус',
		),
	);
}

/**
 * Варианты «что беспокоит» → зоны обработки из прайса.
 * Пустой список зон — цена только после осмотра (скрипы пластика).
 *
 * @return array[]
 */
function shumoff_quiz_concerns() {
	return array(
		'wheels' => array(
			'label' => 'Гул от колёс и дороги (арки и пол)',
			'zones' => array( 'Пол', 'Арки снаружи с подкрылками' ),
		),
		'doors'  => array(
			'label' => 'Шум улицы и ветра (двери)',
			'zones' => array( '4-е двери' ),
		),
		'roof'   => array(
			'label' => 'Шум дождя и гул сверху (крыша)',
			'zones' => array( 'Крыша' ),
		),
		'creaks' => array(
			'label' => 'Скрипы и сверчки в салоне (пластик)',
			'zones' => array(),
		),
		'full'   => array(
			'label' => 'Хочу полную тишину (полный комплекс)',
			'zones' => array( 'Полная комплектация' ),
			'full'  => true,
		),
	);
}

/**
 * Пакеты, доступные в квизе (шаг 4 по ТЗ — Medium и Premium).
 *
 * @return array[]
 */
function shumoff_quiz_packages() {
	return array(
		'Medium'  => array(
			'label' => 'Оптимальный (пакет Medium)',
			'note'  => 'Баланс цены и качества: снятие основного гула, шум ниже примерно на 50%.',
		),
		'Premium' => array(
			'label' => 'Максимальный (пакет Premium)',
			'note'  => 'Премиальные многослойные материалы, идеальная акустика, снижение шума до 70%.',
		),
	);
}

/**
 * Марки для выпадающего списка: термины таксономии car_brand
 * плюс дефолтный набор популярных марок.
 *
 * @return string[]
 */
function shumoff_quiz_brands() {
	$defaults = array(
		'LADA', 'Kia', 'Hyundai', 'Toyota', 'Volkswagen', 'Škoda', 'Renault',
		'Nissan', 'Mazda', 'Mitsubishi', 'Ford', 'Chevrolet', 'BMW',
		'Mercedes-Benz', 'Audi', 'Lexus', 'Geely', 'Haval', 'Chery', 'Exeed', 'Omoda',
	);

	$brands = array();
	if ( taxonomy_exists( 'car_brand' ) ) {
		$terms = get_terms(
			array(
				'taxonomy'   => 'car_brand',
				'hide_empty' => false,
				'fields'     => 'names',
			)
		);
		if ( is_array( $terms ) ) {
			$brands = $terms;
		}
	}

	// Дефолты в конце, без дублей (без учёта регистра).
	$seen = array_map( 'mb_strtolower', $brands );
	foreach ( $defaults as $brand ) {
		if ( ! in_array( mb_strtolower( $brand ), $seen, true ) ) {
			$brands[] = $brand;
		}
	}

	return $brands;
}

/**
 * Срез прайса для JS-калькулятора:
 * класс квиза => зона => пакет => array( mat, total ).
 *
 * @return array
 */
function shumoff_quiz_price_matrix() {
	$zones = array( 'Пол', 'Арки снаружи с подкрылками', '4-е двери', 'Крыша', 'Полная комплектация' );

	$matrix = array();
	foreach ( shumoff_quiz_classes() as $key => $class ) {
		$table = shumoff_get_price_table( $class['body'] );
		if ( ! $table ) {
			continue;
		}
		foreach ( $zones as $zone ) {
			foreach ( array_keys( shumoff_quiz_packages() ) as $package ) {
				if ( isset( $table[ $zone ][ $package ]['total'] ) ) {
					$matrix[ $key ][ $zone ][ $package ] = array(
						'mat'   => (int) $table[ $zone ][ $package ]['mat'],
						'total' => (int) $table[ $zone ][ $package ]['total'],
					);
				}
			}
		}
	}
	return $matrix;
}

/**
 * Конфигурация квиза для фронтенда (wp_localize_script).
 *
 * @return array
 */
function shumoff_quiz_config() {
	return array(
		'classes'  => shumoff_quiz_classes(),
		'concerns' => shumoff_quiz_concerns(),
		'packages' => shumoff_quiz_packages(),
		'brands'   => array_values( shumoff_quiz_brands() ),
		'prices'   => shumoff_quiz_price_matrix(),
		'discount' => 0.10, // Скидка квиза: 10% на материалы.
	);
}

/**
 * Смета по ответам квиза. Считается на сервере — данным клиента не доверяем.
 *
 * @param string   $class_key    Класс авто (ключ shumoff_quiz_classes).
 * @param string[] $concern_keys Что беспокоит (ключи shumoff_quiz_concerns).
 * @param string   $package      Medium | Premium.
 * @return array|null { total, discount, final, zones: string[] } либо null (только после осмотра).
 */
function shumoff_quiz_estimate( $class_key, $concern_keys, $package ) {
	$classes  = shumoff_quiz_classes();
	$concerns = shumoff_quiz_concerns();
	if ( ! isset( $classes[ $class_key ] ) || ! array_key_exists( $package, shumoff_quiz_packages() ) ) {
		return null;
	}

	$table = shumoff_get_price_table( $classes[ $class_key ]['body'] );
	if ( ! $table ) {
		return null;
	}

	// «Полная тишина» перекрывает остальные зоны.
	$zones = array();
	foreach ( (array) $concern_keys as $key ) {
		if ( ! isset( $concerns[ $key ] ) ) {
			continue;
		}
		if ( ! empty( $concerns[ $key ]['full'] ) ) {
			$zones = array( 'Полная комплектация' );
			break;
		}
		$zones = array_merge( $zones, $concerns[ $key ]['zones'] );
	}
	$zones = array_values( array_unique( $zones ) );
	if ( empty( $zones ) ) {
		return null;
	}

	$total = 0;
	$mat   = 0;
	foreach ( $zones as $zone ) {
		if ( ! isset( $table[ $zone ][ $package ]['total'] ) ) {
			return null;
		}
		$total += (int) $table[ $zone ][ $package ]['total'];
		$mat   += (int) $table[ $zone ][ $package ]['mat'];
	}

	$discount = (int) round( $mat * 0.10 );

	return array(
		'total'    => $total,
		'discount' => $discount,
		'final'    => $total - $discount,
		'zones'    => $zones,
	);
}

/**
 * Обработка лида из квиза.
 *
 * @param array $data Сырые данные ($_POST).
 * @return array { success: bool, message: string, field?: string }
 */
function shumoff_process_quiz_lead( $data ) {
	// Honeypot — как в основной форме: боту отвечаем «успехом».
	if ( ! empty( $data['quiz_extra'] ) ) {
		return array(
			'success' => true,
			'message' => 'Расчёт отправлен! Мы свяжемся с вами в ближайшее время.',
		);
	}

	if ( ! isset( $data['shumoff_quiz_nonce'] ) || ! wp_verify_nonce( $data['shumoff_quiz_nonce'], 'shumoff_quiz' ) ) {
		return array(
			'success' => false,
			'message' => 'Сессия устарела. Обновите страницу и пройдите квиз ещё раз.',
		);
	}

	$class_key = isset( $data['quiz_class'] ) ? sanitize_key( $data['quiz_class'] ) : '';
	$brand     = isset( $data['quiz_brand'] ) ? sanitize_text_field( wp_unslash( $data['quiz_brand'] ) ) : '';
	$model     = isset( $data['quiz_model'] ) ? sanitize_text_field( wp_unslash( $data['quiz_model'] ) ) : '';
	$package   = isset( $data['quiz_package'] ) ? sanitize_text_field( wp_unslash( $data['quiz_package'] ) ) : '';
	$messenger = isset( $data['quiz_messenger'] ) ? sanitize_key( $data['quiz_messenger'] ) : '';
	$phone     = isset( $data['quiz_phone'] ) ? sanitize_text_field( wp_unslash( $data['quiz_phone'] ) ) : '';
	$page      = isset( $data['quiz_page'] ) ? esc_url_raw( wp_unslash( $data['quiz_page'] ) ) : '';
	$utm       = isset( $data['quiz_utm'] ) ? sanitize_text_field( wp_unslash( $data['quiz_utm'] ) ) : '';

	$concern_keys = array();
	if ( isset( $data['quiz_concerns'] ) && is_array( $data['quiz_concerns'] ) ) {
		$concern_keys = array_map( 'sanitize_key', $data['quiz_concerns'] );
	}

	if ( empty( $data['quiz_consent'] ) ) {
		return array(
			'success' => false,
			'message' => 'Подтвердите согласие с политикой обработки персональных данных.',
			'field'   => 'consent',
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

	// Общий с формой заявки rate-limit по IP.
	if ( shumoff_lead_rate_limited() ) {
		return array(
			'success' => false,
			'message' => 'Слишком много заявок подряд. Позвоните нам или попробуйте позже.',
		);
	}

	$classes    = shumoff_quiz_classes();
	$concerns   = shumoff_quiz_concerns();
	$packages   = shumoff_quiz_packages();
	$class_name = isset( $classes[ $class_key ] ) ? $classes[ $class_key ]['label'] : '—';
	$car        = trim( $brand . ' ' . $model );

	$concern_labels = array();
	foreach ( $concern_keys as $key ) {
		if ( isset( $concerns[ $key ] ) ) {
			$concern_labels[] = $concerns[ $key ]['label'];
		}
	}

	$estimate      = shumoff_quiz_estimate( $class_key, $concern_keys, $package );
	$estimate_line = $estimate
		? sprintf(
			'от %s ₽ (скидка 10%% на материалы: −%s ₽ → от %s ₽); зоны: %s',
			number_format( $estimate['total'], 0, ',', ' ' ),
			number_format( $estimate['discount'], 0, ',', ' ' ),
			number_format( $estimate['final'], 0, ',', ' ' ),
			implode( ', ', $estimate['zones'] )
		)
		: 'после осмотра';

	$messengers = array(
		'whatsapp' => 'WhatsApp',
		'telegram' => 'Telegram',
		'call'     => 'Звонок менеджера',
	);

	$title = 'Квиз: ' . ( '' !== $car ? $car : $class_name );

	$lead_id = wp_insert_post(
		array(
			'post_type'   => 'leads',
			'post_status' => 'publish',
			'post_title'  => $title,
			'meta_input'  => array(
				'lead_phone'    => $phone,
				'lead_car'      => '' !== $car ? $car : $class_name,
				'lead_page'     => $page,
				'lead_ip'       => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
				'lead_source'   => 'quiz',
				'lead_class'    => $class_name,
				'lead_concerns' => implode( '; ', $concern_labels ),
				'lead_package'  => isset( $packages[ $package ] ) ? $package : '—',
				'lead_estimate' => $estimate_line,
				'lead_contact'  => isset( $messengers[ $messenger ] ) ? $messengers[ $messenger ] : '—',
				'lead_utm'      => $utm,
			),
		),
		true
	);

	$lines = array(
		'Источник: квиз-калькулятор',
		'Автомобиль: ' . ( '' !== $car ? $car : '—' ) . ' (' . $class_name . ')',
		'Беспокоит: ' . ( $concern_labels ? implode( '; ', $concern_labels ) : '—' ),
		'Пакет: ' . ( isset( $packages[ $package ] ) ? $package : '—' ),
		'Предварительная смета: ' . $estimate_line,
		'Куда отправить расчёт: ' . ( isset( $messengers[ $messenger ] ) ? $messengers[ $messenger ] : '—' ),
		'Телефон: ' . $phone,
		'Страница: ' . ( $page ? $page : '—' ),
		'UTM: ' . ( $utm ? $utm : '—' ),
		'Дата: ' . current_time( 'd.m.Y H:i' ),
	);
	$text = implode( "\n", $lines );

	wp_mail(
		get_option( 'admin_email' ),
		'Заявка из квиза — ' . $title,
		$text,
		array( 'Content-Type: text/plain; charset=UTF-8' )
	);

	shumoff_lead_notify_telegram( "🧮 Заявка из квиза\n" . $text );

	if ( is_wp_error( $lead_id ) ) {
		error_log( 'Shumoff quiz lead insert failed: ' . $lead_id->get_error_message() );
	}

	return array(
		'success' => true,
		'message' => 'Готово! Мы зафиксировали скидку 10% и отправим расчёт в ближайшее время.',
	);
}

/**
 * AJAX-обработчик квиза.
 */
function shumoff_ajax_quiz() {
	$result = shumoff_process_quiz_lead( $_POST );
	if ( $result['success'] ) {
		wp_send_json_success( $result );
	}
	wp_send_json_error( $result );
}
add_action( 'wp_ajax_shumoff_quiz', 'shumoff_ajax_quiz' );
add_action( 'wp_ajax_nopriv_shumoff_quiz', 'shumoff_ajax_quiz' );
