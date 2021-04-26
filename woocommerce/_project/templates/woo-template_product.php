<?php
/**
 * 
 * Woocommerce template : communs produits
 * 
 ** Messages
 ** Ajout au panier
 * 
 */


/*================================
=            Messages            =
================================*/

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


/*=====  FIN Messages  =====*/

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

add_filter( 'woocommerce_reset_variations_link', 'pc_woo_reset_variations_link' );

   	function pc_woo_reset_variations_link() {

		return '';

 	}


/*=====  FIN À partir de  =====*/

/*=======================================
=            Ajout au panier            =
=======================================*/

/*----------  Attribut action du formulaire  ----------*/

// add_filter( 'woocommerce_add_to_cart_form_action', 'pc_woo_add_to_cart_form_action' );

// 	function pc_woo_add_to_cart_form_action() {
		
// 		if ( is_product_category() ) {

// 			$queriedObject = get_queried_object();
// 			$paged = ( get_query_var( 'paged' ) ) ? '?paged='.get_query_var( 'paged' ) : '';
			
// 			return get_category_link($queriedObject->term_id).$paged;

// 		} else {

// 			global $product;
			
// 			return $product->get_permalink();

// 		}

// 	}   
   
/*----------  Select variations  ----------*/

add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'pc_woo_dropdown_variation_attribute_options_args', 10 );

	function pc_woo_dropdown_variation_attribute_options_args( $args ) {

		$args['show_option_none'] = $args['attribute'];
		return $args;

	}

add_filter( 'woocommerce_attribute_label', 'pc_woo_attribute_label', 10 );

	function pc_woo_attribute_label() {

		return 'Option';

	}


/*=====  FIN Ajout au panier  =====*/