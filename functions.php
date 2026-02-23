<?php
/**
 * MAVI by Besky — functions.php
 *
 * Enqueue styles, scripts et fonctionnalités du thème FSE.
 *
 * @package Mavi
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue les styles du thème.
 */
function mavi_enqueue_styles() {
	// Google Fonts — Source Sans 3 (body) + Playfair Display (headings)
	wp_enqueue_style(
		'mavi-google-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600&family=Source+Sans+3:ital,wght@0,300;0,400;0,600;0,700;1,400;1,600&display=swap',
		array(),
		null
	);

	// Style principal (métadonnées du thème)
	wp_enqueue_style(
		'mavi-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	// Splide.js — Carrousel (CSS)
	wp_enqueue_style(
		'splide-css',
		'https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/css/splide-core.min.css',
		array(),
		'4.1.4'
	);

	// Styles custom additionnels
	if ( file_exists( get_template_directory() . '/assets/css/custom.css' ) ) {
		wp_enqueue_style(
			'mavi-custom',
			get_template_directory_uri() . '/assets/css/custom.css',
			array( 'mavi-style' ),
			wp_get_theme()->get( 'Version' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'mavi_enqueue_styles' );

/**
 * Enqueue les scripts du thème.
 */
function mavi_enqueue_scripts() {
	// Splide.js — Carrousel (JS)
	wp_enqueue_script(
		'splide-js',
		'https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/js/splide.min.js',
		array(),
		'4.1.4',
		true
	);

	// Script principal
	if ( file_exists( get_template_directory() . '/assets/js/main.js' ) ) {
		wp_enqueue_script(
			'mavi-main',
			get_template_directory_uri() . '/assets/js/main.js',
			array( 'splide-js' ),
			wp_get_theme()->get( 'Version' ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'mavi_enqueue_scripts' );

/**
 * Enqueue les styles dans l'éditeur pour un rendu fidèle.
 */
function mavi_editor_styles() {
	add_editor_style( 'style.css' );
	add_editor_style( 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600&family=Source+Sans+3:ital,wght@0,300;0,400;0,600;0,700;1,400;1,600&display=swap' );

	if ( file_exists( get_template_directory() . '/assets/css/custom.css' ) ) {
		add_editor_style( 'assets/css/custom.css' );
	}
}
add_action( 'after_setup_theme', 'mavi_editor_styles' );

/**
 * Enregistre les patterns de blocs du thème.
 */
function mavi_register_block_pattern_categories() {
	register_block_pattern_category(
		'mavi',
		array(
			'label' => __( 'MAVI — Notion Style', 'mavi' ),
		)
	);

	register_block_pattern_category(
		'mavi-sections',
		array(
			'label' => __( 'MAVI — Sections', 'mavi' ),
		)
	);
}
add_action( 'init', 'mavi_register_block_pattern_categories' );

/**
 * Importeur Notion → WordPress.
 */
require_once get_template_directory() . '/inc/notion-importer.php';
