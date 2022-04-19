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

		$skip_nav_list[] = array( 'href' => get_the_permalink( wc_get_page_id('cart') ), 'label' => 'Panier' );
		
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
			'html' => '<a href="'.$account_url.'" rel="nofollow" title="'.$account_title.'" class="h-tools-link"><span class="txt">'.$account_title.'</span><span class="ico">'.pc_svg('account').'</span></a>'
		) ), $items );


		/*----------  Panier  ----------*/
		
		$quantity = WC()->cart->get_cart_contents_count();
		$cart_link = '<a href="'.wc_get_cart_url().'" rel="nofollow" title="Voir le panier" class="h-tools-link"><span class="txt">Panier</span><span class="ico">'.pc_svg('cart').'</span>';
		$cart_link .= '</a>';
		$cart_link .= ( $quantity > 0 ) ? '<span class="h-tools-cart-counter">'.$quantity.'</span>' : '';

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

		if ( is_shop() || is_product_category() || is_cart() || is_checkout() || is_product() ) {

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

			if ( is_product() ) {

				global $product;
				$terms = get_the_terms( $product->get_id(), 'product_cat' );

				if ( count( $terms ) > 0 ) {

					$terms_url = array();
					foreach ($terms as $key => $term) {
						$terms_url[$key] = get_term_link( $term, 'product_cat' );
					}
					$referer = wp_get_referer();

					if ( $referer && in_array( $referer, $terms_url ) ) {

						$term_from_id = array_search( $referer, $terms_url );
						$term_from = $terms[$term_from_id];
						$term_from_parent_id = $term_from->parent;
						
						if ( $term_from_parent_id > 0 ) {
							
							$terms_from_parents = array();
							while ( $term_from_parent_id > 0 ) {
								$pc_term_from_parent = new PC_Term( get_term_by( 'term_taxonomy_id', $term_from_parent_id ) );
								array_unshift( $terms_from_parents, array(
									'name' => $pc_term_from_parent->get_card_title(),
									'permalink' => $pc_term_from_parent->permalink
								));
								$term_from_parent_id = $pc_term_from_parent->parent;
							}
							$links = array_merge( $links, $terms_from_parents );

						}

						$pc_term_from = new PC_Term( $terms[$term_from_id] );
						$links[] = array(
							'name' => $pc_term_from->get_card_title(),
							'permalink' => $pc_term_from->permalink
						);
			
					} // FIN if $referer && in_array()

				} // FIN if count $terms

			} // FIN is_product()

		}

		return $links;

	}


/*=====  FIN Fil d'ariane  =====*/