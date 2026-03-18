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
	// Style principal (métadonnées du thème)
	wp_enqueue_style(
		'mavi-style',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	// Splide.js — Carrousel (CSS) (enregistré pour utilisation conditionnelle)
	wp_register_style(
		'splide-css',
		'https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/css/splide-core.min.css',
		array(),
		'4.1.4'
	);

	// Styles custom additionnels
	if ( file_exists( get_template_directory() . '/assets/css/main.css' ) ) {
		wp_enqueue_style(
			'mavi-custom',
			get_template_directory_uri() . '/assets/css/main.css',
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
	// Splide.js — Carrousel (JS) (enregistré pour utilisation conditionnelle)
	wp_register_script(
		'splide-js',
		'https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/js/splide.min.js',
		array(),
		'4.1.4',
		true
	);

	// Script principal (enregistré pour utilisation conditionnelle)
	if ( file_exists( get_template_directory() . '/assets/js/main.js' ) ) {
		wp_register_script(
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

	if ( file_exists( get_template_directory() . '/assets/css/main.css' ) ) {
		add_editor_style( 'assets/css/main.css' );
	}
}
add_action( 'after_setup_theme', 'mavi_editor_styles' );

/**
 * Emoji picker style Notion dans l'éditeur Gutenberg.
 */
function mavi_enqueue_editor_emoji_picker() {
	wp_enqueue_style(
		'mavi-emoji-picker',
		get_template_directory_uri() . '/assets/css/emoji-picker.css',
		array(),
		filemtime( get_template_directory() . '/assets/css/emoji-picker.css' )
	);
	wp_enqueue_script(
		'mavi-emoji-picker',
		get_template_directory_uri() . '/assets/js/emoji-picker.js',
		array(),
		filemtime( get_template_directory() . '/assets/js/emoji-picker.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'mavi_enqueue_editor_emoji_picker' );

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
 * Styles de listes personnalisées.
 */
function mavi_register_list_styles() {
	$styles = array(
		array( 'name' => 'mavi-carre',    'label' => __( 'Carré ■', 'mavi' ) ),
		array( 'name' => 'mavi-fleche',   'label' => __( 'Flèche →', 'mavi' ) ),
		array( 'name' => 'mavi-tiret',    'label' => __( 'Tiret —', 'mavi' ) ),
		array( 'name' => 'mavi-coche',    'label' => __( 'Coche ✓', 'mavi' ) ),
		array( 'name' => 'mavi-accent',   'label' => __( 'Point terracotta', 'mavi' ) ),
		array( 'name' => 'mavi-sans',     'label' => __( 'Sans puce', 'mavi' ) ),
	);
	foreach ( $styles as $style ) {
		register_block_style( 'core/list', $style );
	}
}
add_action( 'init', 'mavi_register_list_styles' );

/**
 * Importeur Notion → WordPress.
 */
require_once get_template_directory() . '/inc/notion-importer.php';

/**
 * Transforme le rendu des blocs mavi-content-carousel :
 * - Injecte la structure Splide (splide__track > splide__list > splide__slide)
 *   autour de chaque carte enfant (mavi-slide-card)
 * - Injecte data-fixed-width à partir de la classe mavi-fw-xxx
 *
 * Dans l'éditeur, l'utilisateur voit simplement des cartes côte à côte.
 * Au rendu côté front, ce filtre construit le DOM que Splide.js attend.
 */
function mavi_carousel_render_block( $block_content, $block ) {
	// Charger les scripts s'il y a un carrousel classique ou un bloc code ou autre
	// Pour l'instant, `main.js` gère Splide, Code block copy et Table of contents.
	// On le charge de manière conditionnelle si un de ces éléments est potentiellement présent.
	// Mais on peut simplifier en chargeant `mavi-main` systématiquement, et `splide` conditionnellement
	// Or, comme `mavi-main` dépend de `splide-js` dans ses hooks d'init, c'est mieux de charger `splide`
	// si un carrousel est détecté.
	$class = isset( $block['attrs']['className'] ) ? $block['attrs']['className'] : '';
	if ( strpos( $class, 'mavi-carousel' ) !== false || strpos( $class, 'mavi-content-carousel' ) !== false ) {
		wp_enqueue_style( 'splide-css' );
		wp_enqueue_script( 'splide-js' );
		wp_enqueue_script( 'mavi-main' );
	} else if ( 'core/code' === $block['blockName'] || 'core/heading' === $block['blockName'] || strpos( $class, 'mavi-toc' ) !== false ) {
		// Le main.js gère aussi le code copy et la TOC
		wp_enqueue_script( 'mavi-main' );
	}

	if ( 'core/group' !== $block['blockName'] ) {
		return $block_content;
	}

	if ( strpos( $class, 'mavi-content-carousel' ) === false ) {
		return $block_content;
	}

	// Mettre en cache le parsing HTML DOMDocument qui est lourd
	$cache_key = 'mavi_carousel_' . md5( $block_content );
	$cached_result = get_transient( $cache_key );
	if ( false !== $cached_result ) {
		return $cached_result;
	}

	// Extraire la largeur fixe depuis la classe mavi-fw-xxx
	$fixed_width = '350px';
	if ( preg_match( '/\bmavi-fw-(\d+)\b/', $class, $m ) ) {
		$fixed_width = $m[1] . 'px';
	}

	// Utiliser DOMDocument pour restructurer le HTML
	$dom = new DOMDocument();
	libxml_use_internal_errors( true );
	$dom->loadHTML(
		'<html><body>' . mb_convert_encoding( $block_content, 'HTML-ENTITIES', 'UTF-8' ) . '</body></html>',
		LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
	);
	libxml_clear_errors();

	// Trouver le conteneur principal (premier div avec mavi-content-carousel)
	$xpath    = new DOMXPath( $dom );
	$carousel = $xpath->query( "//div[contains(@class, 'mavi-content-carousel')]" )->item( 0 );
	if ( ! $carousel ) {
		return $block_content;
	}

	// Ajouter la classe splide et l'attribut data-fixed-width
	$current_class = $carousel->getAttribute( 'class' );
	if ( strpos( $current_class, 'splide' ) === false ) {
		$carousel->setAttribute( 'class', $current_class . ' splide' );
	}
	$carousel->setAttribute( 'data-fixed-width', $fixed_width );

	// Collecter les enfants directs qui sont des cartes (mavi-slide-card)
	$cards = array();
	foreach ( $carousel->childNodes as $child ) {
		if ( $child->nodeType === XML_ELEMENT_NODE ) {
			$cards[] = $child;
		}
	}

	if ( empty( $cards ) ) {
		return $block_content;
	}

	// Construire splide__track > splide__list
	$track = $dom->createElement( 'div' );
	$track->setAttribute( 'class', 'splide__track' );
	$list = $dom->createElement( 'div' );
	$list->setAttribute( 'class', 'splide__list' );
	$track->appendChild( $list );

	// Envelopper chaque carte dans un splide__slide
	foreach ( $cards as $card ) {
		$slide = $dom->createElement( 'div' );
		$slide->setAttribute( 'class', 'splide__slide' );
		$carousel->removeChild( $card );
		$slide->appendChild( $card );
		$list->appendChild( $slide );
	}

	// Vider le conteneur et y mettre le track
	// (supprimer les noeuds texte restants)
	while ( $carousel->firstChild ) {
		$carousel->removeChild( $carousel->firstChild );
	}
	$carousel->appendChild( $track );

	// Extraire le HTML résultant
	$body   = $dom->getElementsByTagName( 'body' )->item( 0 );
	$result = '';
	foreach ( $body->childNodes as $child ) {
		$result .= $dom->saveHTML( $child );
	}

	set_transient( $cache_key, $result, DAY_IN_SECONDS );
	return $result;
}
add_filter( 'render_block', 'mavi_carousel_render_block', 10, 2 );

/**
 * Guide admin & infobulles.
 */
require_once get_template_directory() . '/inc/admin-guide.php';
