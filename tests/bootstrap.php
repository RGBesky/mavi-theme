<?xml version="1.0" encoding="UTF-8"?>
<?php
/**
 * Bootstrap pour les tests unitaires isolés (sans charger tout WordPress).
 * On mocke les fonctions WordPress nécessaires au parsing pur.
 */

// Définir des constantes pour éviter les erreurs de chargement conditionnel
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

// Mocks des fonctions WordPress globales avant d'inclure le fichier
if ( ! function_exists( 'add_action' ) ) {
	function add_action() {}
}
if ( ! function_exists( 'wp_json_encode' ) ) {
	function wp_json_encode( $data ) {
		return json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	}
}
if ( ! function_exists( 'esc_html' ) ) {
	function esc_html( $text ) {
		return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' );
	}
}
if ( ! function_exists( 'esc_url' ) ) {
	function esc_url( $url ) {
		return htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
	}
}
if ( ! function_exists( 'esc_attr' ) ) {
	function esc_attr( $text ) {
		return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' );
	}
}

// Mocks pour la fonction de traduction
if ( ! function_exists( '__' ) ) {
    function __( $text, $domain = 'default' ) {
        return $text;
    }
}

// Charger le fichier à tester
require_once dirname( __DIR__ ) . '/inc/notion-importer.php';
