<?php
/**
 * Shumoff Theme functions and definitions.
 *
 * @package Shumoff_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme setup
 */
function shumoff_theme_setup() {

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );

	// Register custom image sizes
	add_image_size( 'shumoff-featured', 800, 500, true );
	add_image_size( 'shumoff-thumbnail', 400, 300, true );
	add_image_size( 'shumoff-hero', 1400, 600, true );

	// HTML5 support for search form, comment form, comment list, gallery, caption
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	// Register navigation menus
	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu', 'shumoff' ),
			'footer-menu' => __( 'Footer Menu', 'shumoff' ),
			'mobile-menu' => __( 'Mobile Menu', 'shumoff' ),
		)
	);

	// Theme customizer support
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'shumoff_theme_setup' );

/**
 * Enqueue scripts and styles.
 */
function shumoff_enqueue_scripts() {

	// Enqueue Google Fonts (Manrope + Inter)
	wp_enqueue_style(
		'google-fonts',
		'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	// Enqueue main stylesheet (база: каркас, шапка, подвал, главная)
	wp_enqueue_style(
		'theme-style',
		get_stylesheet_directory_uri() . '/style.css',
		array(),
		filemtime( get_stylesheet_directory() . '/style.css' )
	);

	// Enqueue main CSS (компоненты внутренних страниц)
	wp_enqueue_style(
		'theme-main-css',
		get_stylesheet_directory_uri() . '/assets/css/main.css',
		array( 'theme-style' ),
		filemtime( get_stylesheet_directory() . '/assets/css/main.css' )
	);

	// Enqueue main JavaScript
	wp_enqueue_script(
		'theme-main',
		get_stylesheet_directory_uri() . '/assets/js/main.js',
		array(),
		filemtime( get_stylesheet_directory() . '/assets/js/main.js' ),
		true
	);

	// Localize script for AJAX
	wp_localize_script( 'theme-main', 'shumoffTheme', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'shumoff-nonce' ),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'shumoff_enqueue_scripts' );

/**
 * Register sidebars (widget areas).
 */
function shumoff_register_sidebars() {

	$sidebars = array(
		array(
			'id'            => 'sidebar-footer-1',
			'name'          => __( 'Footer Widget Area 1', 'shumoff' ),
			'description'   => __( 'First footer widget area.', 'shumoff' ),
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
		),
		array(
			'id'            => 'sidebar-footer-2',
			'name'          => __( 'Footer Widget Area 2', 'shumoff' ),
			'description'   => __( 'Second footer widget area.', 'shumoff' ),
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
		),
		array(
			'id'            => 'sidebar-footer-3',
			'name'          => __( 'Footer Widget Area 3', 'shumoff' ),
			'description'   => __( 'Third footer widget area.', 'shumoff' ),
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
		),
	);

	foreach ( $sidebars as $sidebar ) {
		register_sidebar( $sidebar );
	}
}
add_action( 'widgets_init', 'shumoff_register_sidebars' );

/**
 * Safe ACF field getter: тема не должна падать при выключенном ACF.
 *
 * @param string    $name    Имя поля.
 * @param int|false $post_id ID записи (по умолчанию — текущая).
 * @param mixed     $default Значение, если поле пусто или ACF неактивен.
 * @return mixed
 */
function shumoff_field( $name, $post_id = false, $default = null ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, $post_id );
		if ( null !== $value && false !== $value && '' !== $value ) {
			return $value;
		}
	}
	return $default;
}

/**
 * Контакты компании: значения из «Настроек сайта» (ACF Options)
 * с дефолтами в коде. Единственный источник правды для шаблонов.
 *
 * @param string $key Ключ контакта.
 * @return string
 */
function shumoff_contact( $key ) {
	$defaults = array(
		'contact_phone'    => '+7 (495) 117-63-37',
		'contact_email'    => 'info@shumoffpodolsk.com',
		'contact_address'  => 'г. Подольск, Московская область',
		'contact_hours'    => 'Пн–Сб: 9:00–20:00, Вс — выходной',
		'contact_whatsapp' => 'https://wa.me/74951176337',
		'contact_telegram' => 'https://t.me/shumoffpodolsk',
	);

	$value = shumoff_field( $key, 'option' );
	if ( ! $value && isset( $defaults[ $key ] ) ) {
		$value = $defaults[ $key ];
	}
	return (string) $value;
}

/**
 * Телефон в формате для ссылки tel: (только цифры с плюсом).
 *
 * @return string
 */
function shumoff_contact_phone_link() {
	$digits = preg_replace( '/[^0-9]/', '', shumoff_contact( 'contact_phone' ) );
	return '+' . $digits;
}

/**
 * FAQ: из «Настроек сайта» или дефолтный набор.
 * Используется и для разметки на главной, и для JSON-LD FAQPage —
 * контент задаётся в одном месте.
 *
 * @return array[] Массив из ['question' => ..., 'answer' => ...].
 */
function shumoff_get_faqs() {
	$faqs = shumoff_field( 'site_faqs', 'option' );
	if ( is_array( $faqs ) && ! empty( $faqs ) ) {
		return $faqs;
	}

	$phone = shumoff_contact( 'contact_phone' );

	return array(
		array(
			'question' => 'Сколько времени занимает шумоизоляция?',
			'answer'   => 'Время зависит от выбранного комплекта. Simple — 1-2 дня, Medium — 2-3 дня, Premium — 4-5 дней. Мы всегда стараемся выполнить работу в кратчайшие сроки, не жертвуя качеством.',
		),
		array(
			'question' => 'Какие материалы вы используете?',
			'answer'   => 'Мы работаем с проверенными брендами: StP (СтандартПласт), SoftLine, Шумайз, Akston. Материалы сертифицированы и имеют гарантию производителя.',
		),
		array(
			'question' => 'Даёте ли вы гарантию на работу?',
			'answer'   => 'Да, мы предоставляем гарантию 12 месяцев на все выполненные работы. Если в течение гарантийного срока обнаружится дефект — устраним бесплатно.',
		),
		array(
			'question' => 'Можно ли присутствовать при работе?',
			'answer'   => 'Конечно! Вы можете присутствовать в нашей зоне ожидания с Wi-Fi и кофе. Также мы делаем подробный фотоотчёт на каждом этапе работ.',
		),
		array(
			'question' => 'Как записаться на шумоизоляцию?',
			'answer'   => 'Записаться можно по телефону ' . $phone . ', через WhatsApp, Telegram или заполнив форму на сайте. Мы перезвоним в течение 15 минут и подберём удобное время.',
		),
	);
}

/**
 * Комплекты на главной: из «Настроек сайта» или дефолтный набор.
 *
 * @return array[] Массив из ['name','subtitle','price_from','features'(array),'featured'].
 */
function shumoff_get_packages() {
	$packages = shumoff_field( 'site_packages', 'option' );
	if ( is_array( $packages ) && ! empty( $packages ) ) {
		return array_map(
			function ( $p ) {
				$features = isset( $p['features'] ) && is_string( $p['features'] )
					? array_filter( array_map( 'trim', explode( "\n", $p['features'] ) ) )
					: (array) ( $p['features'] ?? array() );
				return array(
					'name'       => $p['name'] ?? '',
					'subtitle'   => $p['subtitle'] ?? '',
					'price_from' => $p['price_from'] ?? '',
					'features'   => $features,
					'featured'   => ! empty( $p['featured'] ),
				);
			},
			$packages
		);
	}

	return array(
		array(
			'name'       => 'Simple',
			'subtitle'   => 'Базовый комплект',
			'price_from' => '15000',
			'features'   => array(
				'Шумоизоляция дверных карт (2 шт.)',
				'Шумоизоляция арок (2 шт.)',
				'Тонкий виброизолятор',
				'Время: 1-2 дня',
			),
			'featured'   => false,
		),
		array(
			'name'       => 'Medium',
			'subtitle'   => 'Оптимальный комплект',
			'price_from' => '35000',
			'features'   => array(
				'Шумоизоляция дверей (4 шт.)',
				'Шумоизоляция пола (в салон)',
				'Шумоизоляция крыши',
				'Шумоизоляция арок (4 шт.)',
				'Вибро + шумоизолятор',
				'Время: 2-3 дня',
			),
			'featured'   => true,
		),
		array(
			'name'       => 'Premium',
			'subtitle'   => 'Полный комплекс',
			'price_from' => '60000',
			'features'   => array(
				'Шумоизоляция всех дверей (4 шт.)',
				'Шумоизоляция пола (в салон + багажник)',
				'Шумоизоляция крыши',
				'Шумоизоляция арок (4 шт.)',
				'Шумоизоляция капота / багажника',
				'Премиум-материалы',
				'Время: 4-5 дней',
			),
			'featured'   => false,
		),
	);
}

/**
 * Fallback для меню: список основных разделов, пока меню не назначено.
 */
function shumoff_menu_fallback() {
	$links = array(
		get_post_type_archive_link( 'services' ) => __( 'Услуги', 'shumoff' ),
		get_post_type_archive_link( 'cases' )    => __( 'Кейсы', 'shumoff' ),
		get_post_type_archive_link( 'cars' )     => __( 'Автомобили', 'shumoff' ),
	);
	echo '<ul>';
	foreach ( $links as $url => $label ) {
		if ( $url ) {
			printf( '<li><a href="%s"><span>%s</span></a></li>', esc_url( $url ), esc_html( $label ) );
		}
	}
	echo '</ul>';
}

/**
 * Custom excerpt length.
 */
function shumoff_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'shumoff_excerpt_length' );

/**
 * Custom excerpt more.
 */
function shumoff_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'shumoff_excerpt_more' );

/**
 * ============================================================
 * SEO: Meta title, description, keywords, Open Graph
 * ============================================================
 */

/**
 * Get SEO meta data for the current page.
 *
 * @return array title, description, keywords, url, image
 */
function shumoff_get_seo_meta() {
	$site_name = get_bloginfo( 'name' );
	$site_desc = get_bloginfo( 'description' );
	$url       = home_url( add_query_arg( array(), $_SERVER['REQUEST_URI'] ?? '' ) );
	$image     = '';

	// Default SEO
	$title       = 'Шумоизоляция автомобилей в Подольске и Москве | Shumoff Podolsk';
	$description = 'Профессиональная шумоизоляция автомобилей в Подольске и Москве. Опыт 10+ лет, гарантия 12 месяцев. Simple, Medium, Premium комплекты от 15 000 ₽.';
	$keywords    = 'шумоизоляция, шумоизоляция авто, шумоизоляция автомобиля, Подольск, Москва, Shumoff, StP, виброизоляция, звукоизоляция авто';

	// Front page
	if ( is_front_page() ) {
		$title       = 'Шумоизоляция автомобилей в Подольске и Москве | Shumoff Podolsk';
		$description = 'Профессиональная шумоизоляция автомобилей в Подольске и Москве. Опыт 10+ лет, гарантия 12 месяцев. Simple, Medium, Premium комплекты от 15 000 ₽.';
		$keywords    = 'шумоизоляция, шумоизоляция авто, шумоизоляция автомобиля, Подольск, Москва, Shumoff, StP, виброизоляция, звукоизоляция авто';
	}
	// Single services
	elseif ( is_singular( 'services' ) ) {
		$title       = single_post_title( '', false ) . ' | Shumoff Podolsk';
		$description = wp_strip_all_tags( get_the_excerpt() ?: 'Шумоизоляция услуги от Shumoff Podolsk.' );
		$keywords    = 'шумоизоляция, услуги шумоизоляции, ' . single_post_title( '', false );
		if ( has_post_thumbnail() ) {
			$image = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
		}
	}
	// Single cases
	elseif ( is_singular( 'cases' ) ) {
		$title       = single_post_title( '', false ) . ' — кейс | Shumoff Podolsk';
		$description = wp_strip_all_tags( get_the_excerpt() ?: 'Выполненная работа по шумоизоляции.' );
		if ( has_post_thumbnail() ) {
			$image = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
		}
	}
	// Single cars
	elseif ( is_singular( 'cars' ) ) {
		$title       = single_post_title( '', false ) . ' — шумоизоляция | Shumoff Podolsk';
		$description = 'Шумоизоляция ' . single_post_title( '', false ) . ' в Подольске. Simple, Medium, Premium. Гарантия 12 месяцев.';
		if ( has_post_thumbnail() ) {
			$image = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
		}
	}
	// Archive services
	elseif ( is_post_type_archive( 'services' ) ) {
		$title       = 'Услуги шумоизоляции | Shumoff Podolsk';
		$description = 'Полный перечень услуг по шумоизоляции автомобиля: двери, пол, крыша, арки, капот, багажник.';
	}
	// Archive cases
	elseif ( is_post_type_archive( 'cases' ) ) {
		$title       = 'Наши работы — кейсы шумоизоляции | Shumoff Podolsk';
		$description = 'Примеры выполненных работ по шумоизоляции автомобилей. Фото до и после, описание материалов.';
	}
	// Archive cars
	elseif ( is_post_type_archive( 'cars' ) ) {
		$title       = 'Автомобили — шумоизоляция | Shumoff Podolsk';
		$description = 'Цены на шумоизоляцию для разных марок автомобилей. Выберите свою марку.';
	}
	// 404
	elseif ( is_404() ) {
		$title       = '404 — Страница не найдена | Shumoff Podolsk';
		$description = 'Запрашиваемая страница не найдена.';
	}
	// Search
	elseif ( is_search() ) {
		$title       = 'Поиск: ' . get_search_query() . ' | Shumoff Podolsk';
		$description = 'Результаты поиска по сайту Shumoff Podolsk.';
	}

	// Override with ACF fields if available
	if ( is_singular() ) {
		$acf_title = shumoff_field( 'seo_title' );
		$acf_desc  = shumoff_field( 'seo_description' );
		$acf_kw    = shumoff_field( 'seo_keywords' );
		if ( $acf_title ) {
			$title = $acf_title;
		}
		if ( $acf_desc ) {
			$description = $acf_desc;
		}
		if ( $acf_kw ) {
			$keywords = $acf_kw;
		}
	}

	return array(
		'title'       => $title,
		'description' => mb_substr( $description, 0, 160 ),
		'keywords'    => $keywords,
		'url'         => $url,
		'image'       => $image,
	);
}

/**
 * Override WordPress title (fallback if no SEO plugin).
 */
function shumoff_document_title( $title ) {
	$seo = shumoff_get_seo_meta();
	return $seo['title'];
}
add_filter( 'pre_get_document_title', 'shumoff_document_title', 10 );

/**
 * ============================================================
 * robots.txt virtual
 * ============================================================
 */
function shumoff_robots_txt( $output, $public ) {
	// Уважаем настройку «не индексировать сайт» (dev/staging-площадки).
	if ( '0' === (string) $public ) {
		return $output;
	}

	$home_url = home_url( '/' );
	$output  = "User-agent: *\n";
	$output .= "Allow: /\n";
	$output .= "Disallow: /wp-admin/\n";
	$output .= "Disallow: /wp-includes/\n";
	$output .= "Disallow: /wp-content/plugins/\n";
	$output .= "Disallow: /wp-content/cache/\n";
	$output .= "Disallow: /xmlrpc.php\n";
	$output .= "Disallow: /*/feed/\n";
	$output .= "Disallow: /*/trackback/\n";
	$output .= "Disallow: /?s=\n";
	$output .= "Disallow: /search\n";
	$output .= "Sitemap: " . $home_url . "sitemap.xml\n";
	return $output;
}
add_filter( 'robots_txt', 'shumoff_robots_txt', 10, 2 );

/**
 * ============================================================
 * Форма заявки обрабатывается плагином shumoff-core
 * (includes/leads.php): AJAX + фолбэк без JS, nonce, honeypot,
 * rate-limit, CPT «Заявки», почта и Telegram.
 * Здесь — только вывод уведомления для фолбэка без JS.
 * ============================================================
 */
function shumoff_form_notice() {
	if ( isset( $_GET['sent'] ) && '1' === $_GET['sent'] ) {
		echo '<div class="form-success-notice">✓ Заявка отправлена! Мы свяжемся с вами в течение 15 минут.</div>';
	} elseif ( isset( $_GET['lead_error'] ) ) {
		echo '<div class="form-success-notice form-success-notice--error">' . esc_html( sanitize_text_field( wp_unslash( $_GET['lead_error'] ) ) ) . '</div>';
	}
}
add_action( 'wp_footer', 'shumoff_form_notice' );

/**
 * ============================================================
 * Helper: Add body classes
 * ============================================================
 */
function shumoff_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-front-page';
	}
	if ( is_singular() ) {
		$classes[] = 'is-singular';
	}
	return $classes;
}
add_filter( 'body_class', 'shumoff_body_classes' );
