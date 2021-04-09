<?php
/**
 * 
 * Woocommerce template : panier & validation commande
 * 
 ** Communs
 ** Validation commande
 * 
 */


/*===============================
=            Communs            =
===============================*/

/*----------  Page sans container editor  ----------*/

add_filter( 'pc_the_content_before', 'pc_woo_remove_editor_form_cart' );
add_filter( 'pc_the_content_after', 'pc_woo_remove_editor_form_cart' );

	function pc_woo_remove_editor_form_cart( $html ) {

		if ( is_cart() || is_checkout() || is_account_page() ) {

			return '';

		} else {

			return $html;
			
		}

	}


/*----------  No footer  ----------*/

add_action( 'wp', 'pc_woo_remove_main_footer' );

	function pc_woo_remove_main_footer() {

		if ( is_cart() || is_checkout() ) {

			remove_action( 'pc_action_page_main_footer', 'pc_display_main_footer_start', 10 );
			remove_action( 'pc_action_page_main_footer', 'pc_display_share_links', 90 );
			remove_action( 'pc_action_page_main_footer', 'pc_display_main_footer_end', 100 );

		}

	}


/*=====  FIN Communs  =====*/

/*=================================================
=            Validation de la commande            =
=================================================*/

/*----------  Autre adresse  ----------*/

// masquée par défaut
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );


/*=====  FIN Validation de la commande  =====*/