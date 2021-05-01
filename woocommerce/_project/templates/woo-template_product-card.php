<?php
/**
 * 
 * Woocommerce template : produit résumé
 * 
 ** Layout (Hooks)
 ** Classes CSS
 ** Contenu
 * 
 */

 
/*======================================
=            Layout (hooks)            =
======================================*/

/*----------  Suppressions  ----------*/

// lien start (content-product.php)
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

	// promotion (content-product.php)
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	// visuel (content-product.php)
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

	// titre (content-product.php)
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

	// notes (content-product.php)
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	// prix (content-product.php)
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// lien end (content-product.php)
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
// ajout au panier ( content-product.php)
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );


/*----------  Ajouts  ----------*/

// contenu (content-product.php)
add_action( 'woocommerce_before_shop_loop_item', 'pc_woo_display_product_card_content', 10 );

// Promotion/stock/prix (PC_Post)
add_action( 'pc_post_card_before_end', 'pc_woo_display_product_card_price', 10 );


/*=====  FIN Layout (hooks)  =====*/

/*===================================
=            Classes CSS            =
===================================*/

add_filter( 'woocommerce_post_class', 'pc_woo_edit_product_card_css_classes', 10 ,2 );

	function pc_woo_edit_product_card_css_classes( $product_css_classes, $product ) {

		if ( is_product_category() ) {

			$product_css_classes[] = 'st';
			$product_css_classes[] = 'st--product';

		}

		return $product_css_classes;

	}


/*=====  FIN Classes CSS  =====*/

/*===============================
=            Contenu            =
===============================*/

function pc_woo_display_product_card_content() {

	global $product;

	$pc_post = new PC_Post( get_post( $product->get_id() ) );
	$pc_post->display_card();

}

function pc_woo_display_product_card_price( $pc_post ) {

	if ( 'product' == $pc_post->type ) {

		global $product;

		echo '<div class="st-price">';
		
			echo wc_get_stock_html( $product );
			woocommerce_show_product_loop_sale_flash();

			woocommerce_template_loop_price();

		echo '</div>';

	}

}


/*=====  FIN Containeur stock + prix + ajout au panier  =====*/