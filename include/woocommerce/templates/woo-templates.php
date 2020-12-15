<?php
/**
 * 
 * 
 * 
 */

/*=========================================
=            Fichiers CSS & JS            =
=========================================*/

/*----------  CSS  ----------*/
 
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


/*----------  Javascript  ----------*/

// add_action( 'wp_enqueue_scripts', 'pc_woo_enqueue_scripts', 999 );

	function pc_woo_enqueue_scripts() {

		// désactivation custom select pays		
		wp_dequeue_style( 'selectWoo');
		wp_dequeue_script( 'selectWoo' );
	
	}


/*=====  FIN Fichiers CSS & JS  =====*/


	
/*========================================
=            Image par défaut            =
========================================*/

// add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');

function custom_woocommerce_placeholder_img_src( $src ) {      
   return get_bloginfo('template_directory').'/images/st-default.jpg';      
}


/*=====  FIN Image par défaut  =====*/

/*===================================
=            xxxxxxxxxxxxxxxxxxx            =
===================================*/

add_filter( 'woocommerce_post_class', 'pc_edit_product_css_classes', 10, 2 );

	function pc_edit_product_css_classes( $classes, $product  ) {

		if  ( is_shop() || is_product_category() ) { $classes[] = 'st st--product'; }

		return $classes;

	}


/*=====  FIN xxxxxxxxxxxxxxxxxxx  =====*/

/*===========================================
=            Données structurées            =
===========================================*/

// add_filter( 'woocommerce_structured_data_product', 'pc_woo_edit_structured_datas', 10, 2 );

function pc_woo_edit_structured_datas ( $markup, $product ) {

   $productMetas = get_post_meta( $product->get_id() );
   $markup['description'] = $productMetas['st-resum'][0];
   $markup['brand'] = array(
	  '@type' => 'Brand',
	  'name' => get_the_title($productMetas['prod-producer'][0])
   );
   return $markup;

}



/*=====  FIN Données structurées  =====*/

/*=====================================
=            Stock message            =
=====================================*/

// add_filter('woocommerce_get_availability_text', 'pc_woo_stock_msg', 10, 2);

function pc_woo_stock_msg( $text, $product ) {

   if ( !$product->is_in_stock() ) { $text = 'Stock épuisé pour cette semaine'; }
   if ( $product->is_on_backorder() ) { $text = 'Produit non disponible cette semaine'; }
   return $text;

};

// add_filter('woocommerce_out_of_stock_message', 'pc_woo_variable_stock_msg');

function pc_woo_variable_stock_msg( $text ) {

   return 'Stock épuisé pour cette semaine';

}


/*----------  Produit en réappro ne peut être commander  ----------*/

// add_filter( 'woocommerce_variation_is_purchasable', 'pc_no_purchasable', 20, 2 );
// add_filter( 'woocommerce_is_purchasable', 'pc_no_purchasable', 20, 2 );

 function pc_no_purchasable( $purchasable, $product ) {

	 $return = ( $product->is_on_backorder() ) ? false : true;
	 return $return;

 }

// add_action( 'woocommerce_single_product_summary', 'pc_no_purchasable_msg', 15 );

 function pc_no_purchasable_msg() {
	 global $product;
	 if ( $product->is_on_backorder() ) {
		 echo '<p class="stock available-on-backorder">Produit non disponible cette semaine</p>';
	 }
 }

/*----------  Select variante  ----------*/

// add_filter( 'woocommerce_variation_is_active', 'pc_variante_options_disabled', 10, 2 );

 function pc_variante_options_disabled( $active, $variation ) {
	 
	 if ( ! $variation->is_in_stock() || $variation->is_on_backorder() ) {
		 return false;
	 }
	 return $active;

 }

// add_filter( 'woocommerce_variation_option_name',  'pc_variante_select_stock', 10, 4 );

 function pc_variante_select_stock($name, $term, $attribute, $product) {

	 if ( is_product() || is_product_category() ) {

		 $search = ( is_object($term) ) ? $term->slug : $name;

		 foreach ( $product->get_available_variations() as $variation ) {

			 if ( $variation['attributes']['attribute_'.$attribute] == $search ){
				 
				 $variation_obj = wc_get_product( $variation['variation_id'] );
				 if ( ! $variation_obj->is_in_stock() || $variation_obj->is_on_backorder() ) {
					 $name = $name.' (indisponible)';
				 } else {
					 $name = $name.' ('.$variation_obj->get_stock_quantity().' en stock)';
				 }
				 break;
			 }
			 
		 }

	 }

	 return $name;
 }



/*=====  FIN Stock message  =====*/

/*==========================================
=            Ordre des produits            =
==========================================*/

// add_filter( 'woocommerce_get_catalog_ordering_args', 'pc_products_order' );

function pc_products_order( $sort_args ) {

   $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

   $sort_args['orderby'] = 'title';
   $sort_args['order'] = 'asc';

   return $sort_args;

}


/*=====  FIN Ordre des produits  =====*/