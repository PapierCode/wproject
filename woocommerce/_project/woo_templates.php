<?php
/**
 * 
 * Woocommerce template : communs
 * 
 ** Layout (Hooks) : boutique (accueil), catégories, produit
 ** Classes CSS sur l'élément HTML
 ** Images & icônes
 ** Résultats de recherche
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

/*======================================================
=            Classes CSS sur l'élément HTML            =
======================================================*/

add_filter( 'pc_filter_html_css_class', 'pc_woo_edit_html_css_class' );

function pc_woo_edit_html_css_class ( $css_classes ) {

	$css_classes[] = 'has-woocommerce';

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

/*========================================
=            Images & icônes            =
========================================*/

/*----------  Formats d'images  ----------*/

// thumbnail = single responsive
add_filter( 'woocommerce_get_image_size_thumbnail', 'pc_woo_edit_image_size_thumbnail' );

	function pc_woo_edit_image_size_thumbnail() {

		global $product_single_images_sizes;

		return array(
			'width' => $product_single_images_sizes['s'],
			'height' => $product_single_images_sizes['s'],
			'crop' => 1
		);

	}

add_filter( 'woocommerce_get_image_size_single', 'pc_woo_edit_image_size_single' ); 

	function pc_woo_edit_image_size_single() {

		global $product_single_images_sizes;

		return array(
			'width' => $product_single_images_sizes['l'],
			'height' => $product_single_images_sizes['l'],
			'crop' => 1,
		);

	}

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'pc_woo_edit_image_size_gallery_thumbnail' ); 

	function pc_woo_edit_image_size_gallery_thumbnail() {

		global $product_single_images_sizes;

		return array(
			'width' => $product_single_images_sizes['th'],
			'height' => $product_single_images_sizes['th'],
			'crop' => 1,
		);

	}


/*----------  Sprite  ----------*/
	
add_filter( 'pc_filter_sprite', 'pc_woo_edit_sprite' );

	function pc_woo_edit_sprite( $sprite ) {

		$sprite['cart'] = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M18.52,4.93,12.18,0,11,1.58l4.31,3.35H4.74L9.05,1.58,7.82,0,1.48,4.93H0l3,15H17l3-15Zm-3.16,13H4.64l-2.2-11H17.56Z"/></svg>';
		$sprite['cart-more'] = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="19.93" viewBox="0 0 20 19.93"><polygon points="12.75 11.17 11 12.88 11 8.51 9 8.51 9 12.88 7.25 11.17 5.84 12.59 10 16.75 14.16 12.59 12.75 11.17"/><path d="M18.52,4.93,12.18,0,11,1.58l4.31,3.35H4.74L9.05,1.58,7.82,0,1.48,4.93H0l3,15H17l3-15Zm-3.16,13H4.64l-2.2-11H17.56Z"/></svg>';
		$sprite['cart-less'] = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><polygon points="7.25 14.09 9 12.38 9 16.75 11 16.75 11 12.38 12.75 14.09 14.16 12.68 10 8.51 5.84 12.68 7.25 14.09"/><path d="M18.52,4.93,12.18,0,11,1.58l4.31,3.35H4.74L9.05,1.58,7.82,0,1.48,4.93H0l3,15H17l3-15Zm-3.16,13H4.64l-2.2-11H17.56Z"/></svg>';
		
		return $sprite;

	}


/*=====  FIN Images & icônes  =====*/

/*==============================================
=            Résultats de recherche            =
==============================================*/

add_filter( 'pc_filter_search_results_type', 'pc_woo_edit_search_results_type' );

	function pc_woo_edit_search_results_type( $types ) {

		$types['product'] = 'Catalogue';
		return $types;

	}


/*=====  FIN Résultats de recherche  =====*/

/*===============================
=            Include            =
===============================*/

// formulaires
include 'templates/woo-template_forms.php';

// navigation
include 'templates/woo-template_navigation.php';

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
