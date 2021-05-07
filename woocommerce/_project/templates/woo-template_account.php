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

add_action( 'pc_action_page_main_header', 'pc_woo_account_subtitle', 40 );

function pc_woo_account_subtitle() {

	if ( is_account_page() && is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		if ( 'customer' == $current_user->roles[0] ) {
			echo '<p class="pc-woo-account-user-name">';
				echo '<span class="ico">'.pc_svg('account').'</span>';
				echo '<span class="txt">'.$current_user->first_name.' '.$current_user->last_name.'</span>';
			echo '</p>';
		}
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
		$items['edit-account'] = 'Compte';
		
		return $items;

	}


/*=====  FIN Navigation  =====*/

/*==========================================
=            Mot de passe perdu            =
==========================================*/

add_filter( 'woocommerce_add_success', 'pc_woo_account_lost_password_confirmation' );

	function pc_woo_account_lost_password_confirmation( $message ) {

		if ( 'Password reset email has been sent.' == $message ) {
			$message = 'L\'e-mail de réinitialisation a été envoyé.';
		}
		return $message;

	}


/*=====  FIN Mot de passe perdu  =====*/