<?php
/**
 * 
 * Woocommerce template : communs produits
 * 
 ** Prix
 ** Messages
 * 
 */


/*================================
=            Messages            =
================================*/

/*----------  Promotion  ----------*/

add_filter( 'woocommerce_sale_flash', 'pc_woo_edit_sale_flag_html' );

   	function pc_woo_edit_sale_flag_html( $html ) {

    	return '<p class="promo">Promotion</p>';
    
   	}


/*----------  Stock & réapprovisionnement  ----------*/

add_filter( 'woocommerce_get_availability_text', 'pc_woo_edit_stock_flag_txt', 10, 2 );

	function pc_woo_edit_stock_flag_txt( $text, $product ) {

		if ( !$product->is_in_stock() ) { $text = 'Stock épuisé'; }
		if ( $product->is_on_backorder() ) { $text = 'En réapprovisionnement'; }

		return $text;

	};


/*=====  FIN Messages  =====*/