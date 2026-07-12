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

	// Enqueue main stylesheet (theme header + CSS variables)
	wp_enqueue_style(
		'theme-style',
		get_stylesheet_directory_uri() . '/style.css',
		array(),
		'1.0.0'
	);

	// Enqueue main CSS (all component styles)
	wp_enqueue_style(
		'theme-main-css',
		get_stylesheet_directory_uri() . '/assets/css/main.css',
		array( 'theme-style' ),
		'1.0.0'
	);

	// Enqueue main JavaScript
	wp_enqueue_script(
		'theme-main',
		get_stylesheet_directory_uri() . '/assets/js/main.js',
		array(),
		'1.0.0',
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
	if ( function_exists( 'get_field' ) && is_singular() ) {
		$acf_title = get_field( 'seo_title' );
		$acf_desc  = get_field( 'seo_description' );
		$acf_kw    = get_field( 'seo_keywords' );
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
 * Form handler: appointment form submission
 * ============================================================
 */
function shumoff_handle_appointment_form() {
	if ( ! isset( $_POST['appt_name'] ) ) {
		return;
	}

	// Verify nonce (optional — add nonce field if desired)
	$name  = sanitize_text_field( $_POST['appt_name'] ?? '' );
	$phone = sanitize_text_field( $_POST['appt_phone'] ?? '' );
	$car   = sanitize_text_field( $_POST['appt_car'] ?? '' );

	if ( empty( $name ) || empty( $phone ) ) {
		wp_die( 'Пожалуйста, заполните обязательные поля.' );
	}

	// Email to admin
	$to      = get_option( 'admin_email' );
	$subject = 'Новая заявка с сайта Shumoff — ' . $name;
	$message = "Имя: $name\n";
	$message .= "Телефон: $phone\n";
	$message .= "Автомобиль: $car\n";
	$message .= "Дата: " . current_time( 'd.m.Y H:i' ) . "\n";
	$message .= "URL: " . home_url( $_SERVER['REQUEST_URI'] ?? '' ) . "\n";

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );

	wp_mail( $to, $subject, $message, $headers );

	// Redirect to thank-you page
	$redirect = add_query_arg( 'sent', '1', home_url( '/' ) );
	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'template_redirect', 'shumoff_handle_appointment_form' );

/**
 * Admin notice: form sent successfully
 */
function shumoff_form_success_notice() {
	if ( isset( $_GET['sent'] ) && '1' === $_GET['sent'] ) {
		echo '<div class="form-success-notice">✓ Заявка отправлена! Мы свяжемся с вами в течение 15 минут.</div>';
	}
}
add_action( 'wp_footer', 'shumoff_form_success_notice' );

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
