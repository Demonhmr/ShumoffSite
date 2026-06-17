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

	// Enqueue main stylesheet
	wp_enqueue_style(
		'theme-style',
		get_stylesheet_directory_uri() . '/style.css',
		array(),
		'1.0.0'
	);
	wp_style_add_data( 'theme-style', 'rtl', 'replace' );

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
