<?php
/**
 * 
 * Woocommerce : mise en page globale
 * 
 ** Suppressions
 ** Main
 ** Titre (h1)
 ** Content
 * 
 */


/*====================================
=            Suppressions            =
====================================*/

// Sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
// Nombre de résultats
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
// Classement
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


/*=====  FIN Suppressions  =====*/

/*============================
=            Main            =
============================*/

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_before_main_content', 'pc_display_main_start', 10 ); // fonction wpreform

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_after_main_content', 'pc_display_main_end', 10 ); // fonction wpreform


/*=====  FIN Main  =====*/

/*==================================
=            Titre (h1)            =
==================================*/

add_filter( 'woocommerce_show_page_title', function() { return false; } ); // suppression
add_action( 'woocommerce_archive_description', 'pc_woo_display_main_title', 5 );

	function pc_woo_display_main_title() {

		echo '<h1><span>'.woocommerce_page_title( false ).'</span></h1>';

	}


/*=====  FIN Titre (h1)  =====*/

/*===============================
=            Content            =
===============================*/

add_action( 'woocommerce_before_shop_loop', 'pc_display_main_content_start', 10 );  // fonction wpreform 
add_action( 'woocommerce_after_shop_loop', 'pc_display_main_content_end', 1 );  // fonction wpreform

add_action( 'woocommerce_after_shop_loop', 'pc_display_main_footer_start', 9 );  // fonction wpreform
add_action( 'woocommerce_after_shop_loop', 'pc_display_main_footer_end', 11 );  // fonction wpreform


/*=====  FIN Content  =====*/
