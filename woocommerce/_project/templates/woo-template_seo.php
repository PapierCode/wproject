<?php
/**
 * 
 * Woocommerce SEO
 * 
 */


add_filter( 'pc_filter_seo_metas', 'pc_woo_edit_seo_metas' );

	function pc_woo_edit_seo_metas( $metas ) {

		if ( is_shop() ) {

			$pc_shop = new PC_Post( get_post( wc_get_page_id('shop') ) );
			$metas = $pc_shop->get_seo_metas();

		}

		return $metas;

	}
