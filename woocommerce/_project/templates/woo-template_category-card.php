<?php
/**
 * 
 * Woocommerce template : résumé de catégorie
 * 
 ** Layout (hooks)
 ** Classes CSS
 ** Contenu
 * 
 */


/*======================================
=            Layout (hooks)            =
======================================*/

/*----------  Suppressions  ----------*/

// lien start (content-product-cat.php)
remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );

	// visual (content-product-cat.php)
	remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );

	// titre (content-product-cat.php)
	remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );

// lien end (content-product-cat.php)
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );


/*----------  Ajouts  ----------*/

// résumé (content-product-cat.php)
add_action( 'woocommerce_shop_loop_subcategory_title', 'pc_woo_display_category_card_content', 10 );


/*=====  FIN Layout (hooks)  =====*/

/*===================================
=            Classes CSS            =
===================================*/

add_filter( 'product_cat_class', 'pc_woo_edit_category_card_css_classes', 10, 3 );

	function pc_woo_edit_category_card_css_classes( $classes, $class, $term ) {

		return array( 'st', 'st--product-cat' );

	}


/*=====  FIN Classes CSS  =====*/

/*===============================
=            Contenu            =
===============================*/

function pc_woo_display_category_card_content( $term ) {

	$pc_term = new PC_Term( $term );
	$pc_term->display_card();

}


/*=====  FIN Contenu  =====*/