<?php
/**
 * 
 * WooCommerce Custom
 * 
 */


/*========================================================
=            Association WooCommerce au thème            =
========================================================*/

add_theme_support( 'woocommerce' );


/*=====  FIN Association WooCommerce au thème  =====*/

/*=========================================
=            Fichiers CSS & JS            =
=========================================*/

/*----------  CSS  ----------*/
 
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


/*----------  Javascript  ----------*/

// add_action( 'wp_enqueue_scripts', 'pc_woo_enqueue_scripts', 999 );

	function pc_woo_enqueue_scripts() {

		// désactivation custom select pays		
		wp_dequeue_style( 'selectWoo');
		wp_dequeue_script( 'selectWoo' );
	
	}


/*=====  FIN Fichiers CSS & JS  =====*/

/*===============================
=            Include            =
===============================*/

include 'templates/woo-layout.php';
include 'templates/woo-categories.php';
include 'templates/woo-product-resum.php';
include 'templates/woo-product-single.php';

// fil d'ariane
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
// include 'templates/woo-breadcrumb.php

// WTF ?
add_action( 'init', 'pc_woo_remove_page_thumbnail' );
function pc_woo_remove_page_thumbnail() {
	remove_post_type_support( 'page', 'thumbnail' );
}


/*=====  FIN Include  =====*/