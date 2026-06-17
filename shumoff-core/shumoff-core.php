<?php
/*
Plugin Name: Shumoff Core
Description: Регистрация кастомных типов записей (CPT) и таксономий для сайта Shumoff v2.
Version: 1.0
Author: Tech Lead Agent
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Прямой доступ запрещен
}

add_action( 'init', 'shumoff_register_cpts_and_taxonomies' );

function shumoff_register_cpts_and_taxonomies() {

	// -----------------------------------------------------
	// 1. ТАКСОНОМИИ (Рубрикаторы)
	// -----------------------------------------------------

	// Таксономия: Марки автомобилей (для Автомобилей и Кейсов)
	$brand_labels = array(
		'name'              => 'Марки автомобилей',
		'singular_name'     => 'Марка автомобиля',
		'search_items'      => 'Искать марку',
		'all_items'         => 'Все марки',
		'edit_item'         => 'Редактировать марку',
		'update_item'       => 'Обновить марку',
		'add_new_item'      => 'Добавить новую марку',
		'new_item_name'     => 'Новое имя марки',
		'menu_name'         => 'Марки авто',
	);
	register_taxonomy( 'car_brand', array( 'cars', 'cases' ), array(
		'hierarchical'      => true, // Как категории
		'labels'            => $brand_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true, // Для Гутенберга/Bricks
		'rewrite'           => array( 'slug' => 'brand' ),
	));

	// Таксономия: Типы работ (для Услуг и Кейсов)
	$type_labels = array(
		'name'              => 'Типы работ',
		'singular_name'     => 'Тип работы',
		'search_items'      => 'Искать тип работы',
		'all_items'         => 'Все типы работ',
		'edit_item'         => 'Редактировать тип',
		'update_item'       => 'Обновить тип',
		'add_new_item'      => 'Добавить тип',
		'new_item_name'     => 'Новое имя типа',
		'menu_name'         => 'Типы работ',
	);
	register_taxonomy( 'case_type', array( 'services', 'cases' ), array(
		'hierarchical'      => true,
		'labels'            => $type_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'work-type' ),
	));

	// -----------------------------------------------------
	// 2. КАСТОМНЫЕ ТИПЫ ЗАПИСЕЙ (CPT)
	// -----------------------------------------------------

	// CPT: Услуги
	$services_labels = array(
		'name'               => 'Услуги',
		'singular_name'      => 'Услуга',
		'menu_name'          => 'Услуги',
		'add_new'            => 'Добавить услугу',
		'add_new_item'       => 'Добавить новую услугу',
		'edit_item'          => 'Редактировать услугу',
		'new_item'           => 'Новая услуга',
		'view_item'          => 'Просмотр услуги',
		'search_items'       => 'Искать услуги',
		'not_found'          => 'Услуги не найдены',
		'not_found_in_trash' => 'В корзине услуг не найдено',
	);
	register_post_type( 'services', array(
		'labels'              => $services_labels,
		'public'              => true,
		'has_archive'         => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-hammer',
		'show_in_rest'        => true,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'             => array( 'slug' => 'services' ),
	));

	// CPT: Автомобили
	$cars_labels = array(
		'name'               => 'Автомобили',
		'singular_name'      => 'Автомобиль',
		'menu_name'          => 'Автомобили',
		'add_new'            => 'Добавить автомобиль',
		'add_new_item'       => 'Добавить новый автомобиль',
		'edit_item'          => 'Редактировать автомобиль',
		'new_item'           => 'Новый автомобиль',
		'view_item'          => 'Просмотр автомобиля',
		'search_items'       => 'Искать автомобили',
		'not_found'          => 'Автомобили не найдены',
		'not_found_in_trash' => 'В корзине автомобилей не найдено',
	);
	register_post_type( 'cars', array(
		'labels'              => $cars_labels,
		'public'              => true,
		'has_archive'         => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 21,
		'menu_icon'           => 'dashicons-car',
		'show_in_rest'        => true,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'rewrite'             => array( 'slug' => 'cars' ),
	));

	// CPT: Кейсы (Выполненные работы)
	$cases_labels = array(
		'name'               => 'Кейсы',
		'singular_name'      => 'Кейс',
		'menu_name'          => 'Кейсы (Работы)',
		'add_new'            => 'Добавить кейс',
		'add_new_item'       => 'Добавить новый кейс',
		'edit_item'          => 'Редактировать кейс',
		'new_item'           => 'Новый кейс',
		'view_item'          => 'Просмотр кейса',
		'search_items'       => 'Искать кейсы',
		'not_found'          => 'Кейсов не найдено',
		'not_found_in_trash' => 'В корзине кейсов не найдено',
	);
	register_post_type( 'cases', array(
		'labels'              => $cases_labels,
		'public'              => true,
		'has_archive'         => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 22,
		'menu_icon'           => 'dashicons-portfolio',
		'show_in_rest'        => true,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'rewrite'             => array( 'slug' => 'cases' ),
	));

	// CPT: Отзывы (Рекомендовано в ТЗ для SEO и доверия)
	$reviews_labels = array(
		'name'               => 'Отзывы',
		'singular_name'      => 'Отзыв',
		'menu_name'          => 'Отзывы',
		'add_new'            => 'Добавить отзыв',
		'add_new_item'       => 'Добавить новый отзыв',
		'edit_item'          => 'Редактировать отзыв',
		'new_item'           => 'Новый отзыв',
		'view_item'          => 'Просмотр отзыва',
		'search_items'       => 'Искать отзывы',
		'not_found'          => 'Отзывов не найдено',
	);
	register_post_type( 'reviews', array(
		'labels'              => $reviews_labels,
		'public'              => false, // Отзывы не имеют своих страниц (single), только выводятся блоками
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 23,
		'menu_icon'           => 'dashicons-format-chat',
		'show_in_rest'        => true,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
	));
}

// Очистка правил ЧПУ (Flush Rewrite Rules) при активации плагина
register_activation_hook( __FILE__, 'shumoff_core_activate' );
function shumoff_core_activate() {
	shumoff_register_cpts_and_taxonomies();
	flush_rewrite_rules();
}

// -----------------------------------------------------
// 3. ИНТЕГРАЦИЯ ПОЛЕЙ ACF PRO
// -----------------------------------------------------
add_action( 'acf/init', 'shumoff_register_acf_fields' );

function shumoff_register_acf_fields() {
	// Проверяем, активен ли плагин ACF
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	// 3.1. Поля для Кейсов
	acf_add_local_field_group( array(
		'key'      => 'group_case_settings',
		'title'    => 'Детали кейса',
		'fields'   => array(
			array(
				'key'           => 'field_case_gallery',
				'label'         => 'Фотографии процесса (До / В процессе / После)',
				'name'          => 'case_gallery',
				'type'          => 'gallery',
				'return_format' => 'array',
			),
			array(
				'key'   => 'field_case_materials',
				'label' => 'Список материалов',
				'name'  => 'case_materials',
				'type'  => 'textarea',
				'rows'  => 4,
			),
			array(
				'key'    => 'field_case_price',
				'label'  => 'Стоимость работ',
				'name'   => 'case_price',
				'type'   => 'text',
				'append' => '₽',
			),
			array(
				'key'   => 'field_case_time',
				'label' => 'Время работ',
				'name'  => 'case_time',
				'type'  => 'text',
			),
			array(
				'key'    => 'field_case_noise_before',
				'label'  => 'Шум ДО (дБ)',
				'name'   => 'case_noise_before',
				'type'   => 'number',
				'append' => 'дБ',
			),
			array(
				'key'    => 'field_case_noise_after',
				'label'  => 'Шум ПОСЛЕ (дБ)',
				'name'   => 'case_noise_after',
				'type'   => 'number',
				'append' => 'дБ',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'cases',
				),
			),
		),
	) );

	// 3.2. Поля для Услуг
	acf_add_local_field_group( array(
		'key'      => 'group_service_settings',
		'title'    => 'Настройки услуги',
		'fields'   => array(
			array(
				'key'     => 'field_service_price_from',
				'label'   => 'Цена (от)',
				'name'    => 'service_price_from',
				'type'    => 'text',
				'prepend' => 'от',
				'append'  => '₽',
			),
			array(
				'key'   => 'field_service_duration',
				'label' => 'Время выполнения',
				'name'  => 'service_duration',
				'type'  => 'text',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'services',
				),
			),
		),
	) );

	// 3.3. Поля для Автомобилей
	acf_add_local_field_group( array(
		'key'      => 'group_car_settings',
		'title'    => 'Настройки автомобиля',
		'fields'   => array(
			array(
				'key'   => 'field_car_class',
				'label' => 'Класс автомобиля',
				'name'  => 'car_class',
				'type'  => 'text',
			),
			array(
				'key'     => 'field_car_full_price',
				'label'   => 'Цена полной шумоизоляции (от)',
				'name'    => 'car_full_price',
				'type'    => 'text',
				'prepend' => 'от',
				'append'  => '₽',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'cars',
				),
			),
		),
	) );

	// 3.4. Поля для Отзывов
	acf_add_local_field_group( array(
		'key'      => 'group_review_settings',
		'title'    => 'Данные отзыва',
		'fields'   => array(
			array(
				'key'           => 'field_review_rating',
				'label'         => 'Оценка',
				'name'          => 'review_rating',
				'type'          => 'number',
				'min'           => 1,
				'max'           => 5,
				'default_value' => 5,
			),
			array(
				'key'     => 'field_review_source',
				'label'   => 'Источник',
				'name'    => 'review_source',
				'type'    => 'select',
				'choices' => array(
					'yandex' => 'Яндекс Карты',
					'2gis'   => '2ГИС',
					'video'  => 'Видеоотзыв',
					'direct' => 'Напрямую',
				),
			),
			array(
				'key'   => 'field_review_video_url',
				'label' => 'Ссылка на видеоотзыв (YouTube/VK)',
				'name'  => 'review_video_url',
				'type'  => 'oembed',
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_review_source',
							'operator' => '==',
							'value'    => 'video',
						),
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'reviews',
				),
			),
		),
	) );
}
?>
