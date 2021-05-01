<?php
/**
 * 
 * Woocommerce template : communs produits
 * 
 ** Messages stock et promotion
 ** "À partir de"
 * 
 */


/*===================================================
=            Messages stock et promotion            =
===================================================*/

/*----------  Promotion  ----------*/

add_filter( 'woocommerce_sale_flash', 'pc_woo_edit_sale_flag_html' );

   	function pc_woo_edit_sale_flag_html( $html ) {

    	return '<p class="promotion">Promotion</p>';
    
   	}


/*----------  Stock & réapprovisionnement  ----------*/

add_filter( 'woocommerce_get_availability_text', 'pc_woo_edit_stock_flag_txt', 10, 2 );

	function pc_woo_edit_stock_flag_txt( $text, $product ) {

		if ( !$product->is_in_stock() ) { $text = 'Stock épuisé'; }
		if ( $product->is_on_backorder() ) { $text = 'En réapprovisionnement'; }

		return $text;

	};


/*=====  FIN Messages stock et promotion  =====*/

/*===================================
=            À partir de            =
===================================*/

add_filter( 'woocommerce_variable_price_html', 'pc_woo_variable_price_format', 10, 2 );

   function pc_woo_variable_price_format( $price, $product ) {

      $min_price = $product->get_variation_price( 'min', true );
      $max_price = $product->get_variation_price( 'max', true );

      if ($min_price != $max_price){
         return '<span class="price-from">À partir de</span> '.wc_price($min_price);
      } else {
         return wc_price($min_price);
      }

   }


/*=====  FIN À partir de  =====*/
