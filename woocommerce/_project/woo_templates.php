<?php
/**
 * 
 * Woocommerce template : communs
 * 
 ** Layout (Hooks) : boutique (accueil), catégories, produit
 ** Skip links
 ** Classes CSS sur l'élément HTML
 ** Menu item actif
 ** Fil d'ariane
 *
 ** Include
 * 
 */


/*================================================================================
=            Layout (hooks) : boutique (accueil), catégories, produit            =
================================================================================*/

// archive-product.php : accueil boutique et catégories
// single-product.php : layout produit sans contenu


/*----------  Suppressions  ----------*/

// container principal start (archive-product.php & single-product.php)
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
// fil d'ariane (archive-product.php & single-product.php)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// container principal end (archive-product.php & single-product.php)
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// sidebar (archive-product.php & single-product.php)
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


/*----------  Ajout  ----------*/

// container main start (archive-product.php & single-product.php)
add_action( 'woocommerce_before_main_content', 'pc_display_main_start', 10 ); // fonction wpreform

	// footer start (archive-product.php & single-product.php)
	add_action( 'woocommerce_after_main_content', 'pc_display_main_footer_start', 10 );  // fonction wpreform
	// partage (archive-product.php & single-product.php)
	add_action( 'woocommerce_after_main_content', 'pc_display_share_links', 40 );  // fonction wpreform
	// main footer end (archive-product.php & single-product.php)
	add_action( 'woocommerce_after_main_content', 'pc_display_main_footer_end', 50 );  // fonction wpreform

// container main end (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_display_main_end', 60 ); // fonction wpreform


/*=====  FIN Layout (hooks) : boutique (accueil), catégories, produit  =====*/

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

/*======================================================
=            Classes CSS sur l'élément HTML            =
======================================================*/

add_filter( 'pc_filter_html_css_class', 'pc_woo_edit_html_css_class' );

function pc_woo_edit_html_css_class ( $css_classes ) {

	if ( is_shop() ) {

		$css_classes[] = 'is-shop';
	
	} else if ( is_product_category() ) {
	
		$term = get_queried_object(); // catégorie courante (object)
		$terms_childrens = get_term_children( $term->term_id, 'product_cat' ); // enfants de la catégorie courante (array)
	
		if ( count( $terms_childrens ) > 0 ) {
	
			$css_classes[] = 'is-shop-categories-list';
	
		} else {
	
			$css_classes[] = 'is-shop-products-list';
		
		}
	
	} else if ( is_product() ) {

		$css_classes[] = 'is-product';

	} else if ( is_cart() ) {

		$css_classes[] = 'is-cart';

	} else if ( is_checkout() ) {

		$css_classes[] = 'is-checkout';

	} else if (  is_account_page() ) {

		$css_classes[] = 'is-account';

	}

	return $css_classes;

}



/*=====  FIN Classes CSS sur l'élément HTML  =====*/

/*=======================================
=            Menu item actif            =
=======================================*/

add_filter( 'wp_nav_menu_objects', 'pc_woo_nav_item_active', NULL, 2 );

function pc_woo_nav_item_active( $menu_items, $args ) {

	// si menu d'entête
	if ( 'nav-header' == $args->theme_location ) {

		// si c'est une page woocommerce
		if ( is_product() || is_product_category() || is_cart() || is_checkout() || is_account_page() ) {
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


/*=====  FIN Menu item actif  =====*/

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

/*===============================
=            Include            =
===============================*/

// formulaires
include 'templates/woo-template_forms.php';

// boutique (accueil) & liste de catégories
include 'templates/woo-template_shop.php';
include 'templates/woo-template_category-card.php';

// produit
include 'templates/woo-template_product.php';
include 'templates/woo-template_product-card.php';
include 'templates/woo-template_product-single.php';

// tunnel
include 'templates/woo-template_tunnel.php';

// Compte
include 'templates/woo-template_account.php';

// SEO
include 'templates/woo-template_seo.php';


/*=====  FIN Include  =====*/
