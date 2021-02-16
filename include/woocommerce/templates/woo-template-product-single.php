<?php
/**
 * 
 * Woocommerce : produit
 * 
 ** Suppressions
 ** CSS classes
 ** Entête
 ** Layout 2 colonnes
 ** Visuels
 ** Contenu
 * 
 */


/*====================================
=            Suppressions            =
====================================*/

// (content-single-product.php)

// vente flash
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
// titre
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
// notes
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
// résumé
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
// métas (sku, catégories, étiquettes)
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// partage (?)
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
// onglets
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
// produits recommandés
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
// produits liés
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

 
/*=====  FIN Suppressions / déplacements  =====*/

/*===================================
=            CSS classes            =
===================================*/

add_filter( 'woocommerce_post_class', 'pc_woo_single_product_css_classes', 10 ,2 );

	function pc_woo_single_product_css_classes( $classes, $product ) {

		if ( is_product() ) {
			$classes[] = 'main-content single-product';
		}
		
		return $classes;

	}


/*=====  FIN CSS classes  =====*/

/*===============================
=            Visuels            =
===============================*/

// (content-single-product.php)

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

function pc_woo_get_gallery_item( $img_id, $first = false ) {

	global $images_project_sizes;
	$size = ( $first ) ? 'product-single' : 'gl-th';
	$visual_sizes = wp_get_attachment_image_src( $img_id, $size );
	
	if ( $visual_sizes[1] == $images_project_sizes[$size]['width'] && $visual_sizes[2] == $images_project_sizes[$size]['height'] ) {
		
		return array(
			'urls' => array( 
				$size => $visual_sizes[0],
				'gl-m' => wp_get_attachment_image_url( $img_id, 'gl-m' ),
				'gl-l' => wp_get_attachment_image_url( $img_id, 'gl-l' )
			),
			'caption' => wp_get_attachment_caption( $img_id ),
			'alt' => get_post_meta( $img_id, '_wp_attachment_image_alt', true ),
			'thumb' => $size
		);

	} else {

		return false;

	}

}

add_action( 'woocommerce_before_single_product_summary', 'pc_woo_single_product_gallery', 20 );

	function pc_woo_single_product_gallery() {

		global $product, $images_project_sizes;
		$gallery_datas = array();

		if ( $product->get_image_id() && null != get_post( $product->get_image_id() ) ) {

			$gallery_item = pc_woo_get_gallery_item( $product->get_image_id(), true );
			if ( $gallery_item ) { $gallery_datas['visual'] = $gallery_item; }
			
		}

		if ( count( $product->get_gallery_image_ids() ) > 0 ) {

			foreach ( $product->get_gallery_image_ids() as $key => $id ) {
				
				$gallery_item = pc_woo_get_gallery_item( $id );

				if ( $gallery_item ) { $gallery_datas[$key] = $gallery_item; }

			}

		}

		if ( !empty( $gallery_datas ) ) {
				
			echo '<figure class="product-single-gallery"><ul class="wp-gallery reset-list">';

				$post_img = $gallery_datas['visual'];
				echo '<li class="wp-gallery-item">';
				echo '<a class="wp-gallery-link" href="'.$post_img['urls']['gl-l'].'" data-gl-caption="'.$post_img['caption'].'" data-gl-responsive="'.$post_img['urls']['gl-m'].'" title="Afficher l\'image">';
				echo '<img class="wp-gallery-img" src="'.$post_img['urls'][$post_img['thumb']].'" width="'.$images_project_sizes['product-single']['width'].'" height="'.$images_project_sizes['product-single']['height'].'" alt="'.$post_img['alt'].'" loading="lazy"/>';
				echo '<span class="wp-gallery-ico">'.pc_svg('zoom').'</span>';
				echo '</a>';
				echo '</li>';

				unset( $gallery_datas['visual'] );

				foreach ( $gallery_datas as $gallery_item ) {
					
					$post_img = $gallery_item;
					echo '<li class="wp-gallery-item">';
					echo '<a class="wp-gallery-link" href="'.$post_img['urls']['gl-l'].'" data-gl-caption="'.$post_img['caption'].'" data-gl-responsive="'.$post_img['urls']['gl-m'].'" title="Afficher l\'image">';
					echo '<img class="wp-gallery-img" src="'.$post_img['urls'][$post_img['thumb']].'" width="'.$images_project_sizes['gl-th']['width'].'" height="'.$images_project_sizes['gl-th']['height'].'" alt="'.$post_img['alt'].'" loading="lazy"/>';
					echo '<span class="wp-gallery-ico">'.pc_svg('zoom').'</span>';
					echo '</a>';
					echo '</li>';

				}

			echo '</ul></figure>';

		}

	}


/*=====  FIN Visuels  =====*/

/*==============================
=            Entête            =
==============================*/

// (content-single-product.php)

add_action( 'woocommerce_before_single_product', 'pc_woo_single_product_display_header', 20 );

	function pc_woo_single_product_display_header() {

		global $product;
		$terms = get_the_terms( $product->get_id(), 'product_cat' );

		echo '<header class="main-header"><div class="main-header-inner">';

			echo '<h1><span>'.$product->get_title().'</span></h1>';

			if ( count( $terms ) > 0 ) {

				$prefix = ( count( $terms ) > 1 ) ? 'Catégories' : 'Catégorie';
				echo '<dl class="related-product-cat"><dt class="related-product-cat-title">'.$prefix.'&nbsp;: </dt>';
					foreach ( $terms as $key => $term ) {
						echo '<dd class="related-product-cat-item">';
							echo '<a href="'.get_term_link( $term, 'product_cat' ).'" class="related-product-cat-link" title="Voir la catégorie '.$term->name.'">'.$term->name.'</a>';
							if ( $key + 1 != count( $terms ) ) { echo ', '; } else { echo '.'; }
						echo '</dd>';
					}
				echo '</dl>';

			}

		echo '</div></header>';
		
	}


/*=====  FIN Entête  =====*/

/*==============================
=            Layout            =
==============================*/

// (content-single-product.php)

add_action( 'woocommerce_before_single_product_summary', 'pc_woo_single_product_display_inner_start', 1 );

	function pc_woo_single_product_display_inner_start() {

		echo '<div class="main-content-inner">';

	}

	add_action( 'woocommerce_before_single_product_summary', 'pc_woo_single_product_display_layout_start', 2 );

		function pc_woo_single_product_display_layout_start() {

			echo '<div class="single-product-2cols">';

		}

	add_action( 'woocommerce_after_single_product_summary', 'pc_woo_single_product_display_layout_end', 10 );

		function pc_woo_single_product_display_layout_end() {

			echo '</div>';

		}

add_action( 'woocommerce_after_single_product_summary', 'pc_woo_single_product_display_inner_end', 99 );

	function pc_woo_single_product_display_inner_end() {

		echo '</div>';

	}


/*=====  FIN Layout  =====*/

/*===============================
=            Contenu            =
===============================*/

// (content-single-product.php)
add_action( 'woocommerce_single_product_summary', 'pc_woo_single_product_datas', 5 );

	function pc_woo_single_product_datas() {

		global $product;

		/*----------  Poids  ----------*/	
		
		$weight_unit = get_option( 'woocommerce_weight_unit' );
		$weight = $product->get_weight();
		
		if ( '' != $weight ) {
			
			echo '<ul class="single-product-datas reset-list">';

			if ( '' != $weight ) {
				echo '<li class="single-product-datas-item"><strong>Poids : </strong>'.$weight.'&nbsp'.$weight_unit.'</li>';
			}

			echo '</ul>';

		}

	}


/*----------  Description  ----------*/

// (content-single-product.php)
add_action( 'woocommerce_single_product_summary', 'pc_woo_single_product_display_description', 99 );

	function pc_woo_single_product_display_description() {

		echo pc_wp_wysiwyg( get_the_content() );
			
	}


/*=====  FIN Contenu  =====*/

/*==============================
=            Footer            =
==============================*/

// (single-product.php)

add_action( 'woocommerce_after_main_content', 'pc_woo_single_product_display_prev_link', 20 );
	
	function pc_woo_single_product_display_prev_link() {

		if ( is_product() ) {	

			global $shop_name;

			echo '<nav class="main-footer-nav"><a href="'.get_the_permalink( wc_get_page_id( 'shop' ) ).'" class="button" title="Retour vers la boutique">'.pc_svg('arrow',null,'svg_block').'<span>'.$shop_name.'</span></a></nav>';

		}

	}


/*=====  FIN Footer  =====*/