<?php
/**
 * 
 * Woocommerce : produit
 * 
 ** Hooks (suppressions)
 ** Hooks (ajouts)
 ** CSS classes
 ** Entête
 ** Layout
 ** Catégories
 ** Galerie
 ** Propriété
 ** Wysiwyg
 ** Pied de page
 * 
 */


/*============================================
=            Hooks (suppressions)            =
============================================*/

// messages (content-single-product.php)
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );

// ---------

// vente flash (content-single-product.php)
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
// images (content-single-product.php)
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

// ---------

// titre (content-single-product.php)
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
// notes (content-single-product.php)
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
// résumé (content-single-product.php)
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
// métas (content-single-product.php)
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// partage (content-single-product.php)
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

// ---------

// onglets (content-single-product.php)
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
// produits recommandés (content-single-product.php)
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
// produits liés (content-single-product.php)
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


/*=====  FIN Hooks (suppressions)  =====*/

/*======================================
=            Hooks (ajouts)            =
======================================*/

// (content-single-product.php)
add_action( 'woocommerce_before_single_product', 'pc_woo_display_product_single_header', 10 );

// ---------

// div.main-content-inner start (content-single-product.php)
add_action( 'woocommerce_before_single_product_summary', 'pc_woo_display_product_single_main_content_inner_start', 10 );
// messages (content-single-product.php)
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_output_all_notices', 20 );
// images (content-single-product.php)
add_action( 'woocommerce_before_single_product_summary', 'pc_woo_display_product_single_gallery', 30 );

// ---------

// Container prix & ajout au panier start (content-single-product.php)
add_action( 'woocommerce_single_product_summary', 'pc_woo_display_product_single_cart_wrapper_start', 5 );
// Container prix & ajout au panier end (content-single-product.php)
add_action( 'woocommerce_single_product_summary', 'pc_woo_display_product_single_cart_wrapper_end', 40 );
// propriétés (content-single-product.php)
add_action( 'woocommerce_single_product_summary', 'pc_woo_display_product_single_properties', 50 );

// ---------

// description (content-single-product.php)
add_action( 'woocommerce_after_single_product_summary', 'pc_woo_display_product_single_wysiwyg', 10 );
// div.main-content-inner end (content-single-product.php)
add_action( 'woocommerce_after_single_product_summary', 'pc_woo_display_product_single_main_content_inner_end', 20 );


/*=====  FIN Hooks (ajouts)  =====*/

/*===================================
=            CSS classes            =
===================================*/

add_filter( 'woocommerce_post_class', 'pc_woo_edit_single_product_css_classes', 10 ,2 );

	function pc_woo_edit_single_product_css_classes( $classes, $product ) {

		if ( is_product() ) {
			$classes[] = 'main-content';
		}
		
		return $classes;

	}


/*=====  FIN CSS classes  =====*/

/*==================================
=            Catégories            =
==================================*/

function pc_woo_display_product_single_categories() {

	global $product;
	$terms = get_the_terms( $product->get_id(), 'product_cat' );

	if ( count( $terms ) > 0 ) {

		// suppression des catégories avec enfant(s)
		foreach ( $terms as $key => $term ) {
			$term_childrens = get_term_children( $term->term_id, 'product_cat' );
			if ( count( $term_childrens ) > 0 ) {
				unset( $terms[$key] );
			}
		}

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
	
}


/*=====  FIN Catégories  =====*/

/*==============================
=            Entête            =
==============================*/

function pc_woo_display_product_single_header() {

	global $product;

	echo '<header class="main-header"><div class="main-header-inner">';

		pc_woo_display_product_single_categories();

		echo '<h1><span>'.$product->get_title().'</span></h1>';

	echo '</div></header>';
	
}


/*=====  FIN Entête  =====*/

/*==============================
=            Layout            =
==============================*/

/*----------  Main content inner  ----------*/

function pc_woo_display_product_single_main_content_inner_start() {

	echo '<div class="main-content-inner">';

}

function pc_woo_display_product_single_main_content_inner_end() {

	echo '</div>';

}


/*----------  Container Prix & Ajout au panier  ----------*/
	
function pc_woo_display_product_single_cart_wrapper_start() {

	echo '<div class="pc-woo-add-to-cart">';

	global $product;
	echo wc_get_stock_html( $product );
	woocommerce_show_product_loop_sale_flash();

}

function pc_woo_display_product_single_cart_wrapper_end() {

	echo '</div>';

}


/*=====  FIN Layout  =====*/

/*===============================
=            Galerie            =
===============================*/

function pc_woo_get_gallery_item_datas( $img_id, $size = 'product-single-s' ) {
		
	$datas = array(
		'urls' => array( 
			$size => wp_get_attachment_image_url( $img_id ,$size ),
			'gl-m' => wp_get_attachment_image_url( $img_id, 'gl-m' ),
			'gl-l' => wp_get_attachment_image_url( $img_id, 'gl-l' )
		),
		'caption' => wp_get_attachment_caption( $img_id ),
		'alt' => get_post_meta( $img_id, '_wp_attachment_image_alt', true ),
		'thumb' => $size,
	);

	if ( $size == 'product-single-s' ) {
		$datas['urls']['product-single-l'] = wp_get_attachment_image_url( $img_id, 'product-single-l' );
	}

	return $datas;

}

function pc_woo_display_gallery_item( $item_datas ) {

	global $images_sizes;

	echo '<li class="wp-gallery-item">';
		echo '<a class="wp-gallery-link" href="'.$item_datas['urls']['gl-l'].'" data-gl-caption="'.$item_datas['caption'].'" data-gl-responsive="'.$item_datas['urls']['gl-m'].'" title="Afficher l\'image">';

			if ( isset($item_datas['urls']['product-single-s']) ) {

				$img_tag_srcset = $item_datas['urls']['product-single-s'].' 400w, '.$item_datas['urls']['product-single-l'].' 700w';
				$img_tag_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:700px) 700px, 400px';

				echo '<img class="wp-gallery-img" src="'.$item_datas['urls']['product-single-l'].'" alt="'.$item_datas['alt'].'" srcset="'.$img_tag_srcset.'" sizes="'.$img_tag_sizes.'" loading="lazy" />';

			} else {

				echo '<img class="wp-gallery-img" src="'.$item_datas['urls'][$item_datas['thumb']].'" width="'.$images_sizes[$item_datas['thumb']]['width'].'" height="'.$images_sizes[$item_datas['thumb']]['height'].'" alt="'.$item_datas['alt'].'" loading="lazy"/>';

			}

		echo '<span class="wp-gallery-ico">'.pc_svg('zoom').'</span>';
		echo '</a>';
	echo '</li>';

}

function pc_woo_display_product_single_gallery() {

	global $product;

	echo '<figure class="product-single-gallery"><ul class="wp-gallery reset-list">';

		// visuel principal
		if ( $product->get_image_id() && is_object( get_post( $product->get_image_id() ) ) ) {

			$image_datas = pc_woo_get_gallery_item_datas( $product->get_image_id() );
			pc_woo_display_gallery_item( $image_datas );				

		} else {

			echo '<li class="wp-gallery-item"><img class="wp-gallery-img" src="'.get_bloginfo( 'template_directory' ).'/images/square-default.jpg" alt="" loading="lazy" /></li>';

		}

		// visuels supplémentaires
		if ( count( $product->get_gallery_image_ids() ) > 0 ) {

			foreach ( $product->get_gallery_image_ids() as $key => $id ) {

				if ( is_object( get_post( $id ) ) ) {
				
					$gallery_item_datas = pc_woo_get_gallery_item_datas( $id, 'gl-th' );
					pc_woo_display_gallery_item( $gallery_item_datas );

				}

			}

		}

	echo '</ul></figure>';

}


/*=====  FIN Galerie  =====*/

/*==================================
=            Propriétés            =
==================================*/

function pc_woo_display_product_single_properties() {

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


/*=====  FIN Propriétés  =====*/

/*===============================
=            Wysiwyg            =
===============================*/

function pc_woo_display_product_single_wysiwyg() {

	echo the_content();
		
}


/*=====  FIN Description  =====*/

/*====================================
=            Pied de page            =
====================================*/
	
/*----------  Lien retour  ----------*/

function pc_woo_display_product_single_back_link() {

	if ( is_product() ) {	

		global $woo_pages, $shop_name;

		echo '<div class="main-footer-prev"><a href="'.get_the_permalink( $woo_pages['shop'] ).'" class="button" title="Retour vers la boutique">'.pc_svg('arrow',null,'svg_block').'<span>'.$shop_name.'</span></a></div>';

	}

}


/*=====  FIN Pied de page  =====*/