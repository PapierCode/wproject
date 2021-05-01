<?php
/**
 * 
 * Woocommerce : compte client
 * 
 ** 
 * 
 */


/*=====================================================
=            Affichage nom & prénom client            =
=====================================================*/

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


/*=====  FIN Affichage nom & prénom client  =====*/

/*==================================
=            Navigation            =
==================================*/

add_filter ( 'woocommerce_account_menu_items', 'pc_woo_account_menu_items' );

	function pc_woo_account_menu_items( $items ){

		// suppression
		unset( $items['dashboard'] );
		unset( $items['downloads'] );
		
		return $items;

	}


/*=====  FIN Navigation  =====*/