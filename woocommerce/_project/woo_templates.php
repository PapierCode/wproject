<?php
/**
 * 
 * Woocommerce template : communs
 * 
 ** Hooks (suppressions)
 ** Hooks (ajouts)
 ** Html css classes
 ** Skip links
 ** Shop & catégories : titre & description
 ** Include
 * 
 */


/*============================================
=            Hooks (suppressions)            =
============================================*/

// container principal start (archive-product.php & single-product.php)
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
// fil d'ariane (archive-product.php & single-product.php)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// ---------

// shop description (archive-product.php)
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

// ---------

// messages (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
// nombre de résultats (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
// classement (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// ---------

// pager (archive-product.php)
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

// ---------

// container principal end (archive-product.php & single-product.php)
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// ---------

// sidebar (archive-product.php & single-product.php)
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


/*=====  FIN Hooks (suppressions)  =====*/

/*======================================
=            Hooks (ajouts)            =
======================================*/

// container main start (archive-product.php & single-product.php)
add_action( 'woocommerce_before_main_content', 'pc_display_main_start', 10 ); // fonction wpreform

// ---------

// titre (archive-product.php)
add_action( 'woocommerce_archive_description', 'pc_woo_display_main_title', 10 );

// ---------

// div.main-content start (archive-product.php)
add_action( 'woocommerce_before_shop_loop', 'pc_display_main_content_start', 10 ); // fonction wpreform
// messages (archive-product.php)
add_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 20 );
// descriptions shop & catégories (archive-product.php)
add_action( 'woocommerce_before_shop_loop', 'pc_woo_display_description', 30 );

// ---------

// div.main-content end (archive-product.php)
add_action( 'woocommerce_after_shop_loop', 'pc_display_main_content_end', 10 ); // fonction wpreform

// ---------

// footer start (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_display_main_footer_start', 10 );  // fonction wpreform
// lien retour (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_woo_display_product_single_back_link', 20 );
// pagination shop (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_woo_display_shop_pager', 20 );
// catégorie footer (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_woo_display_category_single_footer', 30 );
// partage shop (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_display_share_links', 40 );  // fonction wpreform
// main footer end (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_display_main_footer_end', 50 );  // fonction wpreform

// container main end (archive-product.php & single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_display_main_end', 60 ); // fonction wpreform


/*=====  FIN Hooks (ajouts)  =====*/

/*======================================================
=            Classes CSS sur l'élément HMTL            =
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

	}

	return $css_classes;

}



/*=====  FIN Classes CSS sur l'élément HMTL  =====*/

/*==================================
=            Skip Links            =
==================================*/

add_filter( 'pc_filter_skip_nav', 'pc_woo_edit_skip_nav' );

	function pc_woo_edit_skip_nav( $skip_nav_list ) {

		global $woo_pages;

		$skip_nav_list = array( get_the_permalink( $woo_pages['cart'] ) => array( 'Panier', 'Accès direct au panier' ) ) + $skip_nav_list;

		return $skip_nav_list;

	}


/*=====  FIN Skip Links  =====*/

/*===============================================================
=            Shop & catégories : titre & description            =
===============================================================*/

/*----------  H1  ----------*/

// suppression (archive-product.php)
add_filter( 'woocommerce_show_page_title', function() { return false; } );

function pc_woo_display_main_title() {

	echo '<h1><span>'.woocommerce_page_title( false ).'</span></h1>';

}


/*----------  Description  ----------*/

function pc_woo_display_description() {

	if ( !get_query_var( 'catpaged' ) ) {

		if ( is_shop() ) {

			global $woo_pages;
			$description = get_post_field( 'post_content', $woo_pages['shop'] );

		} else if ( is_product_category() ) {

			global $pc_term;
			$metas = $pc_term->metas;
			$description = ( isset( $metas['content-desc'] ) ) ? $metas['content-desc'] : '';

		}		
		
		if ( '' != $description ) {
			echo pc_wp_wysiwyg( $description );
		}

	}

}


/*=====  FIN Shop & catégories : titre et description  =====*/

/*===============================
=            Include            =
===============================*/

// include 'woo-template_breadcrumb.php

// accueil boutique
include 'templates/woo-template_shop.php';

// catégories
include 'templates/woo-template_categories.php';

// produit
include 'templates/woo-template_product.php';
include 'templates/woo-template_product-resum.php';
include 'templates/woo-template_product-single.php';

// tunnel
include 'templates/woo-template_cart-checkout.php';

// SEO
include 'templates/woo-template_seo.php';


/*=====  FIN Include  =====*/
