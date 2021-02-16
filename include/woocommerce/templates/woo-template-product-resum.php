<?php
/**
 * 
 * Woocommerce template : produit résumé
 * 
 ** Suppressions
 ** CSS classes
 ** Titre, description et visuel
 ** Ajout au panier (avec quantité)
 * 
 */

 
/*====================================
=            Suppressions            =
====================================*/

// (content-product.php)

// lien 
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
// titre 
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
// visuel 
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );


/*=====  FIN Suppressions  =====*/

/*===================================
=            CSS classes            =
===================================*/

add_filter( 'woocommerce_post_class', 'pc_woo_product_resum_edit_css_classes', 10 ,2 );

	function pc_woo_product_resum_edit_css_classes( $product_css_classes, $product ) {

		if ( is_product_category() ) {

			$product_css_classes[] = 'st';
			$product_css_classes[] = 'st--product';

		}

		return $product_css_classes;

	}


/*=====  FIN CSS classes  =====*/

/*====================================================
=            Titre, description et visuel            =
====================================================*/

// (content-product.php)
add_action( 'woocommerce_shop_loop_item_title', 'pc_woo_product_resum_display_content', 10 );


/*=====  FIN Titre, description et visuel  =====*/

/*=========================================================
=            Containeur prix + ajout au panier            =
=========================================================*/

add_action( 'woocommerce_after_shop_loop_item_title', 'pc_woo_product_resum_wrap_cart_start', 9 );

	function pc_woo_product_resum_wrap_cart_start() {

		echo '<div class="st-cart">';

	}

add_action( 'woocommerce_after_shop_loop_item', 'pc_woo_product_resum_wrap_cart_end', 11 );

	function pc_woo_product_resum_wrap_cart_end() {

		echo '</div>';

	}


/*=====  FIN Containeur prix + ajout au panier  =====*/

/*=======================================================
=            Ajout au panier (avec quantité)            =
=======================================================*/

// (content-product.php)

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'woocommerce_after_shop_loop_item', 'pc_woo_product_resum_display_add_to_cart', 10 );

   function pc_woo_product_resum_display_add_to_cart() {

		global $product;

		if( 'simple' == $product->get_type() ) {

			woocommerce_simple_add_to_cart();
		
		}

   }


/*=====  FIN Ajout au panier (avec quantité)  =====*/
