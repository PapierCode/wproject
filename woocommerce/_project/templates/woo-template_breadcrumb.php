<?php
/**
 * 
 * Woocommerce template : fil d'ariane
 * 
 */


/*----------  Lien "Accueil"  ----------*/

//add_filter( 'woocommerce_breadcrumb_home_url', 'pc_woo_custom_breadrumb_home_url' );

   function pc_woo_custom_breadrumb_home_url() {

      return get_permalink( wc_get_page_id( 'shop' ) );

   }


/*----------  Condition d'affichage  ----------*/

// add_action('init', 'pc_woo_breadcrumb_display' );

//    function pc_woo_breadcrumb_display() {

// 		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

// 		if ( is_product_category() ) {
// 			add_action( 'woocommerce_archive_description', 'woocommerce_breadcrumb', 5 );
// 		}
// 		if ( is_product() ) {
// 			add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 6 );
// 		}
    
//    }
