<?php
/**
 * 
 * Woocommerce template : navigation
 * 
 ** Skip links
 ** Item actif dans le menu principal
 ** Liens panier & compte dans l'entête
 ** Mise à jour du panier dans l'entête
 ** Fil d'ariane
 * 
 */


/*==================================
=            Skip Links            =
==================================*/

add_filter( 'pc_filter_skip_nav', 'pc_woo_edit_skip_nav' );

	function pc_woo_edit_skip_nav( $skip_nav_list ) {

		$skip_nav_list = array( 
			get_the_permalink( wc_get_page_id('cart') ) => array( 'Panier', 'Accès direct au panier' ),
			get_the_permalink( wc_get_page_id('myaccount') ) => array( 'Compte client', 'Accès direct au compte client' )
		) + $skip_nav_list;

		return $skip_nav_list;

	}


/*=====  FIN Skip Links  =====*/

/*=========================================================
=            Item actif dans le menu principal            =
=========================================================*/

add_filter( 'wp_nav_menu_objects', 'pc_woo_nav_item_active', NULL, 2 );

function pc_woo_nav_item_active( $menu_items, $args ) {

	// si menu d'entête
	if ( 'nav-header' == $args->theme_location ) {

		// si c'est une page woocommerce
		if ( is_product() || is_product_category() || is_cart() || is_checkout() ) {
			$id_to_search = wc_get_page_id( 'shop' );
		}

		if ( isset( $id_to_search ) ) {
			foreach ( $menu_items as $object ) {
				if ( $object->object_id == $id_to_search ) {
					// ajout classe WP (remplacée dans le Walker du menu)
					$object->classes[] = 'current-menu-item';
				}
			}
		}

	}

	return $menu_items;

};


/*=====  FIN Item actif dans le menu principal  =====*/

/*===========================================================
=            Liens panier & compte dans l'entête            =
===========================================================*/

add_filter( 'pc_filter_header_tools', 'pc_woo_edit_header_tools' );

	function pc_woo_edit_header_tools( $items ) {
		
		/*----------  Compte  ----------*/
				
		$account_url = get_the_permalink( wc_get_page_id('myaccount') );
		$account_title = ( is_user_logged_in() ) ? 'Mon compte' : 'Connexion';
		$items = array_merge( array( 'account' => array(
			'attrs' => '',
			'html' => '<a href="'.$account_url.'" rel="nofollow" title="'.$account_title.'" class="h-tools-link"><span class="h-tools-txt">'.$account_title.'</span><span class="h-tools-ico">'.pc_svg('account').'</span></a>'
		) ), $items );


		/*----------  Panier  ----------*/
		
		$quantity = WC()->cart->get_cart_contents_count();
		$cart_link = '<a href="'.wc_get_cart_url().'" rel="nofollow" title="Voir le panier" class="h-tools-link"><span class="h-tools-txt">Panier</span><span class="h-tools-ico">'.pc_svg('cart').'</span>';
		$cart_link .= ( $quantity > 0 ) ? '<span class="h-tools-cart-counter">'.$quantity.'</span>' : '';
		$cart_link .= '</a>';

		$items = array_merge( array( 'cart' => array(
			'attrs' => '',
			'html' => $cart_link
		) ), $items );
		
		return $items;

	}


/*=====  FIN Liens panier & compte dans l'entête  =====*/

/*============================================================
=             Mise à jour du panier dans l'entête            =
============================================================*/

add_filter( 'woocommerce_add_to_cart_fragments', 'pc_header_cart_update', 10, 1 ); 

    function pc_header_cart_update( $fragments ) {
	
		global $woocommerce;
		ob_start();
		echo '<span class="h-tools-cart-counter">'.WC()->cart->get_cart_contents_count().'</span>';
        $fragments['.h-tools-cart-counter'] = ob_get_clean();
        return $fragments; 

    }


/*=====  FIN  Mise à jour du panier dans l'entête  =====*/

/*====================================
=            Fil d'ariane            =
====================================*/

add_filter( 'pc_filter_breadcrumb', 'pc_woo_edit_breadcrumb' );

	function pc_woo_edit_breadcrumb( $links ) {

		if ( is_shop() || is_product_category() || is_cart() || is_checkout() ) {

			global $shop_name;
			$links[] = array(
				'name' => $shop_name,
				'permalink' => get_the_permalink( wc_get_page_id('shop') )
			);

			if ( is_checkout() ) {

				$links[] = array(
					'name' => 'Panier',
					'permalink' => get_the_permalink( wc_get_page_id('cart') )
				);

			}

		}

		return $links;

	}


/*=====  FIN Fil d'ariane  =====*/