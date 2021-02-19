<?php
/**
 * 
 * Woocommerce template : accueil catalogue
 * 
 ** Description
 * 
 */


/*==================================
=            Pagination            =
==================================*/
	
function pc_woo_display_shop_pager() {

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