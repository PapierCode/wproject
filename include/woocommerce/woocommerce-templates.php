<?php
/**
 * 
 * Woocommerce template : communs
 * 
 ** Hooks (suppressions)
 ** Hooks (ajouts)
 ** Skip links
 ** Titre (h1)
 ** Include
 * 
 */


/*============================================
=            Hooks (suppressions)            =
============================================*/

// container principal start (archive-product.php & single-product.php)
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
// fil d'ariane (archive-product.php & single-product.php)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// ---------

// shop description (archive-product.php)
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

// ---------

// messages (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
// nombre de résultats (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
// classement (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// ---------

// pager (archive-product.php)
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

// ---------

// container principal end (archive-product.php & single-product.php)
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// ---------

// sidebar (archive-product.php & single-product.php)
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


/*=====  FIN Hooks (suppressions)  =====*/

/*======================================
=            Hooks (ajouts)            =
======================================*/

// container main start (archive-product.php & single-product.php)
add_action( 'woocommerce_before_main_content', 'pc_display_main_start', 10 ); // fonction wpreform

// messages (archive-product.php & single-product.php)
add_action( 'woocommerce_before_main_content', 'woocommerce_output_all_notices', 20 ); // fonction woo

// ---------

// titre (archive-product.php)
add_action( 'woocommerce_archive_description', 'pc_woo_layout_display_main_title', 10 );

// ---------

// div.main-content start (archive-product.php)
add_action( 'woocommerce_before_shop_loop', 'pc_display_main_content_start', 10 ); // fonction wpreform
// description (archive-product.php)
add_action( 'woocommerce_before_shop_loop', 'pc_woo_shop_description', 20 );
add_action( 'woocommerce_before_shop_loop', 'pc_woo_category_details_display_description', 30 );

// ---------

// div.main-content end (archive-product.php)
add_action( 'woocommerce_after_shop_loop', 'pc_display_main_content_end', 10 ); // fonction wpreform

// ---------

// footer start (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_display_main_footer_start', 10 );  // fonction wpreform
// lien retour (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_woo_single_product_display_back_link', 20 );
// pagination shop (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_woo_shop_pager', 20 );
// catégorie footer (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_woo_category_details_footer', 30 );
// partage shop (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_display_share_links', 40 );  // fonction wpreform
// main footer end (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_display_main_footer_end', 50 );  // fonction wpreform

// container main end (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_display_main_end', 60 ); // fonction wpreform


/*=====  FIN Hooks (ajouts)  =====*/

/*==================================
=            Skip Links            =
==================================*/

add_filter( 'pc_filter_skip_nav', 'pc_woo_edit_skip_nav' );

	function pc_woo_edit_skip_nav( $skip_nav_list ) {

		global $woo_pages;

		$skip_nav_list = array( get_the_permalink( $woo_pages['cart'] ) => array( 'Panier', 'Accès direct au panier' ) ) + $skip_nav_list;

		return $skip_nav_list;

	}


/*=====  FIN Skip Links  =====*/

/*==================================
=            Titre (h1)            =
==================================*/

// suppression (archive-product.php)
add_filter( 'woocommerce_show_page_title', function() { return false; } );

function pc_woo_layout_display_main_title() {

	echo '<h1><span>'.woocommerce_page_title( false ).'</span></h1>';

}


/*=====  FIN Titre (h1)  =====*/

/*===============================
=            Include            =
===============================*/

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
