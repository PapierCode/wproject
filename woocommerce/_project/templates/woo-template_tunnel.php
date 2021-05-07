<?php
/**
 * 
 * Woocommerce template : panier, validation commande, compte
 * 
 ** Modifications Wpreform
 ** Page de validation de la commande
 * 
 */


/*==============================================
=            Modifications Wpreform            =
==============================================*/

/*----------  Sans container editor  ----------*/

add_filter( 'pc_the_content_before', 'pc_woo_remove_editor_form_cart' );
add_filter( 'pc_the_content_after', 'pc_woo_remove_editor_form_cart' );

	function pc_woo_remove_editor_form_cart( $html ) {

		if ( is_cart() || is_checkout() || is_account_page() ) {

			return '';

		} else {

			return $html;
			
		}

	}


/*----------  Sans données structurées  ----------*/

add_filter( 'pc_filter_page_schema_article_display', 'pc_woo_remove_schema_article' );

	function pc_woo_remove_schema_article() {

		if ( is_cart() || is_checkout() || is_account_page() ) {

			return false;

		} else {

			return true;
			
		}

	}


/*----------  Sans piedi de page  ----------*/

add_action( 'wp', 'pc_woo_remove_main_footer' );

	function pc_woo_remove_main_footer() {

		if ( is_cart() || is_checkout() || is_account_page() ) {

			remove_action( 'pc_action_page_main_footer', 'pc_display_main_footer_start', 10 );
			remove_action( 'pc_action_page_main_footer', 'pc_display_share_links', 90 );
			remove_action( 'pc_action_page_main_footer', 'pc_display_main_footer_end', 100 );

		}

	}


/*=====  FIN Modifications Wpreform  =====*/


add_filter( 'woocommerce_product_variation_title_include_attributes', function(){ return false; } );


/*=========================================================
=            Page de validation de la commande            =
=========================================================*/

/*----------  Adresse de livraison masquée par défaut  ----------*/

add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );


/*----------  Mise en forme frais de port  ----------*/

add_filter( 'woocommerce_cart_shipping_method_full_label', 'pc_woo_cart_shipping_label', 10, 2 );

	function pc_woo_cart_shipping_label( $label, $shipping_rate ) {

		$label = str_replace( ':', '&nbsp;:&nbsp;', $label );
		return $label;

	}

/*----------  Bouton de validation  ----------*/

add_filter( 'woocommerce_order_button_html', 'pc_woo_order_button_html' );

	function pc_woo_order_button_html() {

		return '<div class="pc-woo-submit-box"><button type="submit" class="button button--xl button--red">Commander</button></div>';

	}


/*=====  FIN Page de validation de la commande  =====*/