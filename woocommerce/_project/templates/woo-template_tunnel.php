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

		if ( is_cart() || is_checkout() ) {

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

		$to_remove = array( 'company', 'country', 'address_2', 'phone' ) ;
		foreach ( $to_remove as $id)  {
			unset( $fields['billing']['billing_'.$id] );
			unset( $fields['shipping']['shipping_'.$id] );
		}

		$label_address = 'Adresse';
		$fields['billing']['billing_address_1']['label'] = $label_address;
		$fields['billing']['billing_address_1']['placeholder'] = '';
		$fields['shipping']['shipping_address_1']['label'] = $label_address;
		$fields['shipping']['shipping_address_1']['placeholder'] = '';

		$fields['account']['account_password']['label'] = 'Mot de passe';
		$fields['account']['account_password']['placeholder'] = '';

		$fields['order']['order_comments']['label'] = 'Associez un message à la commande';
		$fields['order']['order_comments']['placeholder'] = '';

		return $fields;

	}


/*=====  FIN Validation de la commande  =====*/