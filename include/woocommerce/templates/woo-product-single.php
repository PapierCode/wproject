<?php
/**
 * 
 * Woocommerce : produit
 * 
 ** Suppressions
 ** CSS classes
 * 
 */


/*====================================
=            Suppressions            =
====================================*/
 
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
 
 
/*=====  FIN Suppressions  =====*/

/*===================================
=            CSS classes            =
===================================*/

add_filter( 'woocommerce_post_class', 'pc_woo_single_product_css_classes', 10 ,2 );

	function pc_woo_single_product_css_classes( $classes, $product ) {

		if ( is_product() ) {
			$classes[] = 'single-product';
		}
		
		return $classes;

	}


/*=====  FIN CSS classes  =====*/