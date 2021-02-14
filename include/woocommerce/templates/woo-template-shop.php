<?php
/**
 * 
 * Woocommerce template : accueil catalogue
 * 
 ** Description
 * 
 */


/*===================================
=            Description            =
===================================*/

// suppression (archive-product.php)
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

// ajout (archive-product.php)
add_action( 'woocommerce_archive_description', 'pc_woo_shop_description', 10 );

	function pc_woo_shop_description() {

		if ( is_shop() && !get_query_var( 'catpaged' ) ) {

			$description = get_post_field( 'post_content', wc_get_page_id('shop') );

			if ( '' != $description ) {
				echo pc_wp_wysiwyg( $description );
			}

		}

	}


/*=====  FIN Description  =====*/

/*==================================
=            Pagination            =
==================================*/

add_action( 'woocommerce_after_main_content', 'pc_woo_shop_footer' );
	
	function pc_woo_shop_footer() {

		if ( is_shop() ) { 
			
			$terms = get_terms( array(
				'taxonomy' => 'product_cat',
				'hide_empty' => false,
				'parent' => 0
			) );
			$fake_query = (object) array( 'max_num_pages' => ceil( count( $terms ) / get_option( 'posts_per_page' ) ) );
			$current_page_number = ( get_query_var( 'catpaged' ) ) ? get_query_var( 'catpaged' ) : 1;
			
			pc_get_pager( $fake_query, $current_page_number, array( 'format' => '?catpaged=%#%#main') );

		}

	}


/*=====  FIN Pagination  =====*/