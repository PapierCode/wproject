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

/*========================================
=            Tailles d'images            =
========================================*/

add_filter( 'intermediate_image_sizes_advanced', 'pc_woo_remove_images_sizes', 10 );

	function pc_woo_remove_images_sizes( $sizes ) {

		$sizes_to_remove = array(
			'woocommerce_thumbnail',
			'woocommerce_single',
			'woocommerce_gallery_thumbnail',
			'shop_catalog',
			'shop_single',
			'shop_thumbnail'
		);

		foreach ($sizes_to_remove as $size) {
			unset( $sizes[$size] );
		}

		return $sizes;

	}

add_filter( 'pc_filter_images_sizes', 'pc_woo_edit_images_sizes' );

	function pc_woo_edit_images_sizes( $images_sizes ) {

		$images_sizes['product-single-s'] = array( 'width'=>400, 'height'=>400, 'crop'=>true );
		$images_sizes['product-single-l'] = array( 'width'=>700, 'height'=>700, 'crop'=>true );
		return $images_sizes;

	}


/*=====  FIN Tailles d'images  =====*/

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

