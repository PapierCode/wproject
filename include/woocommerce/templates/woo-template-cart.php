<?php
/**
 * 
 * Woocommerce template : panier
 * 
 ** Ajout au panier
 * 
 */


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

/*===================================
=            Page panier            =
===================================*/

add_filter( 'pc_the_content_before', 'pc_woo_remove_editor_form_cart' );
add_filter( 'pc_the_content_after', 'pc_woo_remove_editor_form_cart' );

	function pc_woo_remove_editor_form_cart( $html ) {
		if ( is_cart() ) {
			return '';
		} else {
			return $html;
		}
	}


/*=====  FIN Page panier  =====*/