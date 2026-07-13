<?php
/**
 * Прайс-лист шумоизоляции: доступ к матрице «кузов × зона × комплект».
 *
 * @package Shumoff_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Полная матрица цен.
 *
 * @return array тип кузова => зона => комплект => array( mat, work, total )
 */
function shumoff_core_get_price_list() {
	static $list = null;
	if ( null === $list ) {
		$list = include SHUMOFF_CORE_DIR . 'data/price-list.php';
		/**
		 * Позволяет переопределить прайс (например, из настроек админки).
		 *
		 * @param array $list Матрица цен.
		 */
		$list = apply_filters( 'shumoff_price_list', $list );
	}
	return $list;
}

/**
 * Список типов кузова из прайса (для селекта в админке и валидации).
 *
 * @return string[]
 */
function shumoff_get_body_types() {
	return array_keys( shumoff_core_get_price_list() );
}

/**
 * Таблица цен для типа кузова.
 *
 * Понимает распространённые синонимы («Седан», «Хэтчбэк», «Минивэн»),
 * чтобы свободно заполненное поле «класс автомобиля» находило свой прайс.
 *
 * @param string $body_type Тип кузова.
 * @return array|null зона => комплект => цены, либо null, если кузов не найден.
 */
function shumoff_get_price_table( $body_type ) {
	$list = shumoff_core_get_price_list();
	$body = trim( (string) $body_type );

	if ( isset( $list[ $body ] ) ) {
		return $list[ $body ];
	}

	$key = mb_strtolower( $body );

	// Регистронезависимое совпадение с ключами прайса.
	foreach ( $list as $name => $table ) {
		if ( mb_strtolower( $name ) === $key ) {
			return $table;
		}
	}

	$aliases = array(
		'седан'    => 'Седан-Хэтчбэк',
		'хэтчбэк'  => 'Седан-Хэтчбэк',
		'хетчбек'  => 'Седан-Хэтчбэк',
		'бизнес'   => 'Седан Бизнес',
		'минивэн'  => 'Минивен',
		'suv'      => 'Кроссовер',
	);
	if ( isset( $aliases[ $key ], $list[ $aliases[ $key ] ] ) ) {
		return $list[ $aliases[ $key ] ];
	}

	return null;
}

/**
 * Итог «Полная комплектация» для кузова и комплекта.
 *
 * @param string $body_type Тип кузова.
 * @param string $package   Simple | Medium | Premium.
 * @return int|null
 */
function shumoff_get_full_package_price( $body_type, $package ) {
	$table = shumoff_get_price_table( $body_type );
	if ( isset( $table['Полная комплектация'][ $package ]['total'] ) ) {
		return (int) $table['Полная комплектация'][ $package ]['total'];
	}
	return null;
}
