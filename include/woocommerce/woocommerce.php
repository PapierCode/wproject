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

/*----------  CSS  ----------*/
 
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


/*----------  Javascript  ----------*/

add_action( 'wp_enqueue_scripts', 'pc_woo_enqueue_scripts', 999 );

	function pc_woo_enqueue_scripts() {
	
		wp_dequeue_style( 'selectWoo' );
		wp_deregister_script( 'selectWoo' );
		wp_dequeue_script( 'selectWoo' );

		wp_deregister_script( 'wc-password-strength-meter' );
		wp_dequeue_script( 'wc-password-strength-meter' );

		// wp_deregister_script( 'wc-country-select' );
		// wp_dequeue_script( 'wc-country-select' );
	
	}


/*=====  FIN Fichiers CSS & JS  =====*/

/*========================================
=            Tailles d'images            =
========================================*/

add_action('init', 'pc_woo_remove_images_sizes');

	function pc_woo_remove_images_sizes() {

		$sizes_to_remove = array(
			'woocommerce_thumbnail',
			'woocommerce_single',
			'woocommerce_gallery_thumbnail',
			'shop_catalog',
			'shop_single',
			'shop_thumbnail'
		);

		foreach ($sizes_to_remove as $size) {
			remove_image_size( $size );
		}

	}

add_filter( 'pc_filter_add_img_sizes', 'pc_woo_add_images_sizes' );

	function pc_woo_add_images_sizes( $images_project_sizes ) {

		$images_project_sizes['product-single'] = array( 'width'=>400, 'height'=>400, 'crop'=>true );
		return $images_project_sizes;

	}


/*=====  FIN Tailles d'images  =====*/

/*=================================
=            Variables            =
=================================*/

$woo_pages = array(
	'shop' => wc_get_page_id('shop'),
	'cart' => wc_get_page_id('cart'),
	'checkout' => wc_get_page_id('checkout'),
	'myaccount' => wc_get_page_id('myaccount')
);

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

include 'woocommerce-functions.php';
include 'woocommerce-admin.php';
include 'woocommerce-templates.php';


/*=====  FIN Include  =====*/

