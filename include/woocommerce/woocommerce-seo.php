<?php
/**
 * 
 * Woocommerce SEO
 * 
 */


add_filter( 'pc_filter_seo_metas', 'pc_woo_edit_seo_metas' );

	function pc_woo_edit_seo_metas( $metas ) {

		if ( is_shop() ) {

			global $woo_pages;
			$pc_shop = new PC_Post( get_post( $woo_pages['shop'] ) );
			$metas = $pc_shop->get_seo_metas();

		}

		return $metas;

	}
