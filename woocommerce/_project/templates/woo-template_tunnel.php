<?php
/**
 * 
 * Woocommerce template : panier, validation commande, compte
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

		if ( is_cart() || is_checkout() || is_account_page() ) {

			remove_action( 'pc_action_page_main_footer', 'pc_display_main_footer_start', 10 );
			remove_action( 'pc_action_page_main_footer', 'pc_display_share_links', 90 );
			remove_action( 'pc_action_page_main_footer', 'pc_display_main_footer_end', 100 );

		}

	}


/*----------  Message champs obligatoires  ----------*/

add_action( 'woocommerce_before_customer_login_form', 'pc_woo_display_message_required_fields', 10 );
add_action( 'woocommerce_before_checkout_billing_form', 'pc_woo_display_message_required_fields', 10 );

	function pc_woo_display_message_required_fields() {

		echo '<p class="pc-woo-msg-required-fields"><em>Les champs obligatoires sont signalés par un astérisque</em>&nbsp;<abbr class="required" title="obligatoire">*</abbr></p>';

	}
	

/*=====  FIN Communs  =====*/

/*=================================================
=            Validation de la commande            =
=================================================*/

// autre adresse masquée par défaut
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );

add_filter( 'woocommerce_checkout_fields', 'pc_woo_checkout_fields' );

	function pc_woo_checkout_fields( $fields ) { 

		$fields['billing']['billing_phone']['required'] = false;
		$fields['billing']['billing_email']['label'] = 'E-mail';

		$fields['account']['account_password']['label'] = 'Mot de passe';
		$fields['account']['account_password']['placeholder'] = '';

		$fields['order']['order_comments']['label'] = 'Associez un message à la commande';
		$fields['order']['order_comments']['placeholder'] = '';

		return $fields;

	}

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'pc_woo_admin_order_data_after_shipping_address', 10, 1 );

	function pc_woo_admin_order_data_after_shipping_address( $order ){

		echo '<p><strong>'.__('Phone From Checkout Form').':</strong> ' . get_post_meta( $order->get_id(), '_shipping_phone', true ) . '</p>';

	}


add_filter( 'woocommerce_cart_shipping_method_full_label', 'pc_woo_cart_shipping_label', 10, 2 );

	function pc_woo_cart_shipping_label( $label, $shipping_rate ) {

		$label = str_replace( ':', '&nbsp;:&nbsp;', $label );
		return $label;

	}


/*=====  FIN Validation de la commande  =====*/

add_filter( 'woocommerce_get_terms_and_conditions_checkbox_text', 'pc_woo_terms_and_conditions_checkbox_text' );

	function pc_woo_terms_and_conditions_checkbox_text( $text ) {

		return 'truc';

	}

add_filter( 'woocommerce_order_button_html', 'pc_woo_order_button_html' );

	function pc_woo_order_button_html() {

		return '<div class="pc-woo-submit-box"><button type="submit" class="button button--xl button--red">Commander</button></div>';

	}

/*=============================================
=            Confirmation commande            =
=============================================*/


/*=====  FIN Confirmation commande  =====*/