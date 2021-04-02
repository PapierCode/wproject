<?php
/**
 * 
 * Woocommerce template : produit résumé
 * 
 ** Hooks (suppressions)
 ** Hooks (ajouts)
 ** CSS classes
 ** Contenu
 ** Ajout au panier avec quantité
 ** Containeur prix + ajout au panier
 * 
 */

 
/*============================================
=            Hooks (suppressions)            =
============================================*/

// lien start (content-product.php)
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

// ---------

// visuel (content-product.php)
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

// ---------

// titre (content-product.php)
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

// ---------

// lien end (content-product.php)
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );


/*=====  FIN Hooks (suppressions)  =====*/

/*======================================
=            Hooks (ajouts)            =
======================================*/

// article start (content-product.php)
add_action( 'woocommerce_before_shop_loop_item', 'pc_woo_display_article_tag_start', 10 );

// ---------

// contenu (content-product.php)
add_action( 'woocommerce_shop_loop_item_title', 'pc_woo_display_product_resum_content', 10 );

// ---------

// Containeur prix + ajout au panier start(content-product.php)
add_action( 'woocommerce_after_shop_loop_item_title', 'pc_woo_display_product_resum_cart_wrapper_start', 5 );

// ---------

// Ajout au panier avec quantité (content-product.php)
add_action( 'woocommerce_after_shop_loop_item', 'pc_woo_display_product_resum_add_to_cart', 10 );
// Containeur prix + ajout au panier end (content-product.php)
add_action( 'woocommerce_after_shop_loop_item', 'pc_woo_display_product_resum_cart_wrapper_end', 20 );
// article end (content-product.php)
add_action( 'woocommerce_after_shop_loop_item', 'pc_woo_display_article_tag_end', 30 );


/*=====  FIN Hooks (ajouts)  =====*/

/*===================================
=            CSS classes            =
===================================*/

add_filter( 'woocommerce_post_class', 'pc_woo_edit_product_resum_css_classes', 10 ,2 );

	function pc_woo_edit_product_resum_css_classes( $product_css_classes, $product ) {

		if ( is_product_category() ) {

			$product_css_classes[] = 'st';
			$product_css_classes[] = 'st--product';

		}

		return $product_css_classes;

	}


/*=====  FIN CSS classes  =====*/

/*===============================
=            Contenu            =
===============================*/

function pc_woo_display_product_resum_content() {

	global $product;

	$pc_post = new PC_Post( get_post( $product->get_id() ) );
	$pc_post->display_card();

}


/*=====  FIN Contenu  =====*/

/*=====================================================
=            Ajout au panier avec quantité            =
=====================================================*/

function pc_woo_display_product_resum_add_to_cart() {

	global $product;

	if( 'simple' == $product->get_type() ) {

		woocommerce_simple_add_to_cart();
	
	}

}


/*=====  FIN Ajout au panier avec quantité  =====*/

/*=========================================================
=            Containeur prix + ajout au panier            =
=========================================================*/

function pc_woo_display_product_resum_cart_wrapper_start() {

	echo '<div class="pc-add-to-cart pc-add-to-cart--st">';

}

function pc_woo_display_product_resum_cart_wrapper_end() {

	echo '</div>';

}


/*=====  FIN Containeur prix + ajout au panier  =====*/