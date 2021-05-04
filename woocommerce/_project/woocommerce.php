<?php
/**
 * 
 * WooCommerce Custom
 * 
 ** Fichiers CSS & JS
 ** Variables
 ** Include
 * 
 */


/*=========================================
=            Fichiers CSS & JS            =
=========================================*/

/*----------  Suppression CSS Woocommerce  ----------*/
 
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


/*----------  Suppressions javascript et dépendances CSS  ----------*/

add_action( 'wp_enqueue_scripts', 'pc_woo_enqueue_scripts', 999 );

	function pc_woo_enqueue_scripts() {
	
		wp_dequeue_style( 'selectWoo' );
		wp_deregister_script( 'selectWoo' );
		wp_dequeue_script( 'selectWoo' );

		wp_deregister_script( 'wc-password-strength-meter' );
		wp_dequeue_script( 'wc-password-strength-meter' );

	
	}


/*=====  FIN Fichiers CSS & JS  =====*/

/*=================================
=            Variables            =
=================================*/

$shop_name = 'Boutique';


/*----------  Custom vars  ----------*/

add_filter( 'query_vars', 'pc_woo_query_vars' );

	function pc_woo_query_vars($vars) {
		
		$vars[] = 'catpaged'; // pagination des catégories
		return $vars;

	}


/*=====  FIN Variables  =====*/

/*===============================
=            Include            =
===============================*/

include 'woo_admin.php';
include 'woo_templates.php';


/*=====  FIN Include  =====*/

