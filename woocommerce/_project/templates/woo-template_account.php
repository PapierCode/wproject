<?php


add_filter( 'woocommerce_default_address_fields', 'pc_woo_default_address_fields' );

	function pc_woo_default_address_fields( $fields ) {


		$to_remove = array( 'company', 'address_2', 'state' ) ;
		foreach ( $to_remove as $id)  { unset( $fields[$id] ); }

		$fields['country']['required'] = false;
		
		$fields['address_1']['label'] = 'Adresse';
		$fields['address_1']['placeholder'] = '';

		return $fields;

	}

add_filter( 'woocommerce_address_to_edit', 'pc_woo_account_adresses_fields', 10, 2 );

	function pc_woo_account_adresses_fields( $fields, $type ) {

		if ( 'billing' == $type ) {

			$fields[$type.'_phone']['required'] = false;

		}
		
		return $fields;

	}


add_filter ( 'woocommerce_account_menu_items', 'pc_woo_account_menu_items' );

	function pc_woo_account_menu_items( $items ){

		// suppression
		unset( $items['dashboard'] );
		unset( $items['downloads'] );
		
		return $items;

	}

add_action( 'pc_action_page_main_header', 'pc_woo_account_subtitle', 30 );

	function pc_woo_account_subtitle() {
	
		if ( is_account_page() && is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			echo '<p class="pc-woo-account-user-name">';
				echo '<span>'.pc_svg('account').'</span>';
				echo $current_user->first_name.' '.$current_user->last_name;
			echo '</p>';
		}

	}