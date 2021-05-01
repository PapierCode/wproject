<?php
/**
 * 
 * Woocommerce : formulaires
 * 
 ** Message champs obligatoires
 ** Adresses
 * 
 */


/*===================================================
=            Message champs obligatoires            =
===================================================*/

add_action( 'woocommerce_before_customer_login_form', 'pc_woo_display_message_required_fields', 10 );
add_action( 'woocommerce_before_checkout_billing_form', 'pc_woo_display_message_required_fields', 10 );

	function pc_woo_display_message_required_fields() {

		echo '<p class="pc-woo-msg-required-fields"><em>Les champs obligatoires sont signalés par un astérisque</em>&nbsp;<abbr class="required" title="obligatoire">*</abbr></p>';

	}


/*=====  FIN Message champs obligatoires  =====*/

/*================================
=            Adresses            =
================================*/

/*----------  Tous les formulaires (validation de la commande & compte)  ----------*/
 
add_filter( 'woocommerce_default_address_fields', 'pc_woo_default_address_fields' );

	function pc_woo_default_address_fields( $fields ) {


		$to_remove = array( 'company', 'address_2', 'state' ) ;
		foreach ( $to_remove as $id)  { unset( $fields[$id] ); }

		$fields['country']['required'] = false;
		
		$fields['address_1']['label'] = 'Adresse';
		$fields['address_1']['placeholder'] = '';

		return $fields;

	}


/*----------  Modification depuis le compte  ----------*/
	
add_filter( 'woocommerce_address_to_edit', 'pc_woo_account_adresses_fields', 10, 2 );

	function pc_woo_account_adresses_fields( $fields, $type ) {

		if ( 'billing' == $type ) {

			$fields[$type.'_phone']['required'] = false;

		}
		
		return $fields;

	}


/*----------  Validaton de la commande  ----------*/

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


/*=====  FIN Adresses  =====*/
