<?php
/**
 * 
 * Woocommerce template : panier, validation commande, compte
 * 
 ** Modifications Wpreform
 ** Panier
 ** Page de validation de la commande
 * 
 */


/*==============================================
=            Modifications Wpreform            =
==============================================*/

/*----------  Sans container editor  ----------*/

add_filter( 'pc_filter_page_wysiwyg_container', 'pc_woo_remove_editor_form_cart' );

	function pc_woo_remove_editor_form_cart( $bool ) {

		if ( is_cart() || is_checkout() || is_account_page() ) {

			$bool = false;

		}
		
		return $bool;

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


/*----------  Sans pied de page  ----------*/

add_action( 'wp', 'pc_woo_remove_main_footer' );

	function pc_woo_remove_main_footer() {

		if ( is_cart() || is_checkout() || is_account_page() ) {

			remove_action( 'pc_action_page_main_footer', 'pc_display_main_footer_start', 10 );
			remove_action( 'pc_action_page_main_footer', 'pc_display_share_links', 90 );
			remove_action( 'pc_action_page_main_footer', 'pc_display_main_footer_end', 100 );

		}

	}


/*=====  FIN Modifications Wpreform  =====*/

/*=================================
=            Variation            =
=================================*/

add_filter( 'woocommerce_display_item_meta', 'pc_woo_display_item_meta', 10, 3 );

	function pc_woo_display_item_meta( $html, $item, $args ) {

		if ( ( is_checkout() || is_account_page() ) && count( $item->get_formatted_meta_data() ) > 0 ) {

		// à modifier aussi dans cart/cart-item-data.php

		$html = ' (';
		$index = 1;
		foreach ( $item->get_formatted_meta_data() as $meta ) {
			if ( $index > 1 ) { $html .= ', '; }
			$html .= $meta->display_key.'&nbsp;'.$meta->value;
			$index++;
		}
		$html .= ')';

		}

		return $html;

	}


/*=====  FIN Variation  =====*/

/*==============================
=            Panier            =
==============================*/

add_filter( 'woocommerce_product_variation_title_include_attributes', function(){ return false; } );


/*----------  Coupons  ----------*/

add_filter( 'woocommerce_cart_totals_coupon_label', 'pc_woo_edit_cart_totals_coupon_label', 10, 2 );

	function pc_woo_edit_cart_totals_coupon_label( $label, $coupon ) {

		$label = '<span>Code promo&nbsp;: </span><span>'.$coupon->get_code().'</span>';
		return $label;

	}

add_filter( 'woocommerce_cart_totals_coupon_html', 'pc_woo_edit_cart_totals_coupon_html', 10, 3 );

	function pc_woo_edit_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) {

		if ( is_cart() ) {
		
			$coupon_html = str_replace( 'woocommerce-remove-coupon', 'pc-cart-button', $coupon_html );
			$coupon_html = str_replace( 'data', 'title="Supprimer ce coupon" data', $coupon_html );
			$coupon_html = str_replace( '[Enlever]', '<span class="visually-hidden">Supprimer ce coupon</span>', $coupon_html );

		} else {

			$coupon_html = $discount_amount_html;

		}

		return $coupon_html;

	}


/*=====  FIN Panier  =====*/


/*=========================================================
=            Page de validation de la commande            =
=========================================================*/

/*----------  Pas de code promo à cette étape  ----------*/

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );


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