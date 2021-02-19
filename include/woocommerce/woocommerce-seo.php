<?php
/**
 * 
 * Woocommerce SEO
 * 
 */

/*===================================================================
=            Métas titre et desciption, image de partage            =
===================================================================*/

add_filter( 'pc_filter_seo_metas', 'pc_woo_edit_seo_metas' );

	function pc_woo_edit_seo_metas( $seo_metas ) {

		if ( is_product() ) {

			$product_id = get_the_id();
			$product_metas = get_post_meta( $product_id );
			$seo_metas = pc_get_post_seo_metas( $seo_metas, $product_id, $product_metas );

			// visuel woo
			if ( isset( $product_metas['_thumbnail_id'] ) && is_object( get_post( $product_metas['_thumbnail_id'][0] ) ) ) {
				$seo_metas['img'] = wp_get_attachment_image_src($product_metas['_thumbnail_id'][0],'share')[0];
			}

		}

		return $seo_metas;

	}


/*=====  FIN Métas titre et desciption, image de partage  =====*/