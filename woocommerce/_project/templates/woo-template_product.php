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

/*=======================================
=            Ajout au panier            =
=======================================*/

/*----------  Attribut action du formulaire  ----------*/

add_filter( 'woocommerce_add_to_cart_form_action', 'pc_woo_add_to_cart_form_action' );

	function pc_woo_add_to_cart_form_action() {
		
		if ( is_product_category() ) {

			$queriedObject = get_queried_object();
			$paged = ( get_query_var( 'paged' ) ) ? '?paged='.get_query_var( 'paged' ) : '';
			
			return get_category_link($queriedObject->term_id).$paged;

		} else {

			global $product;
			
			return $product->get_permalink();

		}

	}   
   


/*=====  FIN Ajout au panier  =====*/