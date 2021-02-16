<?php
/**
 * 
 * Woocommerce template : communs produits
 * 
 ** Prix
 ** Messages
 * 
 */


/*============================
=            Prix            =
============================*/

/*----------  Espace avant €  ----------*/

add_filter( 'woocommerce_currency_symbol', 'pc_woo_price_space' );

	function pc_woo_price_space( $currency_symbol ) {

		return '&nbsp;'.$currency_symbol;

	}


/*=====  FIN Prix  =====*/

/*================================
=            Messages            =
================================*/

/*----------  Promotion  ----------*/

add_filter( 'woocommerce_sale_flash', 'pc_woo_sale_msg' );

   	function pc_woo_sale_msg( $html ) {

    	return '<p class="promo">Promotion</p>';
    
   	}


/*----------  Stock & réapprovisionnement  ----------*/

add_filter( 'woocommerce_get_availability_text', 'pc_woo_stock_msg', 10, 2 );

	function pc_woo_stock_msg( $text, $product ) {

		if ( !$product->is_in_stock() ) { $text = 'Stock épuisé'; }
		if ( $product->is_on_backorder() ) { $text = 'En réapprovisionnement'; }

		return $text;

	};


/*=====  FIN Messages  =====*/