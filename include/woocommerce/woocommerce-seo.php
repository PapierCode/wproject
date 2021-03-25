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

			global $post;
			$product_metas = get_post_meta( $post->ID );
			$seo_metas = pc_get_post_seo_metas( $seo_metas, $post, $product_metas );

			// visuel woo
			if ( isset( $product_metas['_thumbnail_id'] ) && is_object( get_post( $product_metas['_thumbnail_id'][0] ) ) ) {
				$seo_metas['img'] = wp_get_attachment_image_src($product_metas['_thumbnail_id'][0],'share')[0];
			}

		} else if ( is_shop() ) {

			global $woo_pages;
			$page_metas = get_post_meta( $woo_pages['shop'] );
			$seo_metas = pc_get_post_seo_metas( $seo_metas, $woo_pages['shop'], $page_metas );

		} else if ( is_product_category() ) {

			$term = get_queried_object();
			$term_metas = get_term_meta( $term->term_id );
			$seo_metas = pc_get_tax_seo_metas( $seo_metas, $term, $term_metas );

		}

		return $seo_metas;

	}


/*=====  FIN Métas titre et desciption, image de partage  =====*/