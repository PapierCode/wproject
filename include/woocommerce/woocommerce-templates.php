<?php
/**
 * 
 * Woocommerce template : communs
 * 
 ** Suppression sidebar
 ** Skip links
 ** Main
 ** Titre (h1)
 ** Content
 ** Footer
 ** Include
 * 
 */


/*===========================================
=            Suppression sidebar            =
===========================================*/

// sidebar (archive-product.php & single-product.php)
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


/*=====  FIN Suppression sidebar  =====*/

/*==================================
=            Skip Links            =
==================================*/

add_filter( 'pc_filter_skip_nav', 'pc_woo_edit_skip_nav' );

	function pc_woo_edit_skip_nav( $skip_nav_list ) {

		$skip_nav_list = array( get_the_permalink( wc_get_page_id( 'cart' ) ) => array( 'Panier', 'Accès direct au panier' ) ) + $skip_nav_list;

		return $skip_nav_list;

	}


/*=====  FIN Skip Links  =====*/

/*============================
=            Main            =
============================*/

// début du container (archive-product.php & single-product.php)
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_before_main_content', 'pc_display_main_start', 10 ); // fonction wpreform

// fin du container (archive-product.php & single-product.php)
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_after_main_content', 'pc_display_main_end', 100 ); // fonction wpreform


/*=====  FIN Main  =====*/

/*===================================
=            Woo notices            =
===================================*/

// (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
// (content-single-product.php)
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
// (archive-product.php & single-product.php)
add_action( 'woocommerce_before_main_content', 'woocommerce_output_all_notices', 15 );


/*=====  FIN Woo notices  =====*/

/*==================================
=            Titre (h1)            =
==================================*/

// suppression (archive-product.php)
add_filter( 'woocommerce_show_page_title', function() { return false; } );

// ajout (archive-product.php)
add_action( 'woocommerce_archive_description', 'pc_woo_layout_display_main_title', 10 );

	function pc_woo_layout_display_main_title() {

		echo '<h1><span>'.woocommerce_page_title( false ).'</span></h1>';

	}


/*=====  FIN Titre (h1)  =====*/

/*===============================
=            Content            =
===============================*/

// ajout containers (archive-product.php)

add_action( 'woocommerce_before_shop_loop', 'pc_display_main_content_start', 11 );  // fonction wpreform 
add_action( 'woocommerce_after_shop_loop', 'pc_display_main_content_end', 1 );  // fonction wpreform


/*=====  FIN Content  =====*/

/*==============================
=            Footer            =
==============================*/

// (archive-product.php & single-product.php)

add_action( 'woocommerce_after_main_content', 'pc_display_main_footer_start', 10 );  // fonction wpreform
	add_action( 'woocommerce_after_main_content', 'pc_display_share_links', 30 );  // fonction wpreform
add_action( 'woocommerce_after_main_content', 'pc_display_main_footer_end', 100 );  // fonction wpreform


/*=====  FIN Footer  =====*/

/*===============================
=            Include            =
===============================*/

// fil d'ariane (archive-product.php & single-product.php)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
// include 'woo-template-breadcrumb.php

// accueil catalogue
include 'templates/woo-template-shop.php';

// catégories
include 'templates/woo-template-categories.php';

// produit
include 'templates/woo-template-product.php';
include 'templates/woo-template-product-resum.php';
include 'templates/woo-template-product-single.php';

// panier
include 'templates/woo-template-cart.php';


/*=====  FIN Include  =====*/
