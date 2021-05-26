<?php
/**
 * 
 * Woocommerce : produit
 * 
 ** Layout (Hooks)
 ** Classes CSS
 ** Sous-containeur main
 ** Entête
 ** Ajout au panier
 ** Galerie
 ** Propriétés
 ** Textes
 ** Produits associés
 ** Lien retour
 * 
 */


/*======================================
=            Layout (hooks)            =
======================================*/

// single-product.php : layout produit sans contenu
// content-single-product.php : contenu


/*----------  Suppressions  ----------*/

// messages (content-single-product.php)
remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );

// promotion (content-single-product.php)
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
// images (content-single-product.php)
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

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

// onglets (content-single-product.php)
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
// produits recommandés (content-single-product.php)
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
// produits liés (content-single-product.php)
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


/*----------  Ajouts  ----------*/


// entête (content-single-product.php)
add_action( 'woocommerce_before_single_product', 'pc_woo_display_product_single_header', 10 );

// div.main-content-inner start (content-single-product.php)
add_action( 'woocommerce_before_single_product_summary', 'pc_woo_display_product_single_main_content_inner_start', 10 );
	// messages (content-single-product.php)
	add_action( 'woocommerce_before_single_product_summary', 'woocommerce_output_all_notices', 20 );
	// images (content-single-product.php)
	add_action( 'woocommerce_before_single_product_summary', 'pc_woo_display_product_single_gallery', 30 );
	// json variations (content-single-product.php)
	add_action( 'woocommerce_before_single_product_summary', 'pc_woo_display_product_single_variations_json', 40 );

	// Container prix & ajout au panier start (content-single-product.php)
	add_action( 'woocommerce_single_product_summary', 'pc_woo_display_product_single_cart_wrapper_start', 5 );
	// Container prix & ajout au panier end (content-single-product.php)
	add_action( 'woocommerce_single_product_summary', 'pc_woo_display_product_single_cart_wrapper_end', 40 );
	// propriétés (content-single-product.php)
	add_action( 'woocommerce_single_product_summary', 'pc_woo_display_product_single_properties', 50 );

	// wysiwyg (content-single-product.php)
	add_action( 'woocommerce_after_single_product_summary', 'pc_woo_display_product_single_wysiwyg', 10 );
// div.main-content-inner end (content-single-product.php)
add_action( 'woocommerce_after_single_product_summary', 'pc_woo_display_product_single_main_content_inner_end', 20 );

// produits associés (single-product.php)
add_action( 'woocommerce_after_single_product_summary', 'pc_woo_display_related_products', 30 );

// lien retour (single-product.php)
add_action( 'woocommerce_after_main_content', 'pc_woo_display_product_single_back_link', 20 );


/*=====  FIN Layout (hooks)  =====*/

/*===================================
=            Classes CSS            =
===================================*/

add_filter( 'woocommerce_post_class', 'pc_woo_edit_single_product_css_classes', 10 ,2 );

	function pc_woo_edit_single_product_css_classes( $classes, $product ) {

		if ( is_product() ) {
			$classes[] = 'main-content';
		}
		
		return $classes;

	}


/*=====  FIN Classes CSS  =====*/

/*============================================
=            Sous-containeur main            =
============================================*/

function pc_woo_display_product_single_main_content_inner_start() {

	echo '<div class="main-content-inner">';

}

function pc_woo_display_product_single_main_content_inner_end() {

	echo '</div>';

}


/*=====  FIN Sous-containeur main  =====*/

/*==============================
=            Entête            =
==============================*/

function pc_woo_display_product_single_header() {

	global $product;

	echo '<header class="main-header"><div class="main-header-inner">';

		pc_display_breadcrumb();

		echo '<h1><span>'.$product->get_title().'</span></h1>';

	echo '</div></header>';
	
}


/*=====  FIN Entête  =====*/

/*=======================================
=            Ajout au panier            =
=======================================*/

/*----------  Container, sotck, promotion  ----------*/
	
function pc_woo_display_product_single_cart_wrapper_start() {

	echo '<div class="pc-woo-add-to-cart">';

	global $product;
	echo wc_get_stock_html( $product );
	woocommerce_show_product_loop_sale_flash();

}

function pc_woo_display_product_single_cart_wrapper_end() {

	echo '</div>';

}
   

/*----------  Select variations  ----------*/

add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'pc_woo_dropdown_variation_attribute_options_args', 10 );

	function pc_woo_dropdown_variation_attribute_options_args( $args ) {

		// texte option vide = label
		$args['show_option_none'] = $args['attribute'];
		return $args;

	}

add_filter( 'woocommerce_attribute_label', 'pc_woo_attribute_label', 10 );

	function pc_woo_attribute_label( $label ) {

		if ( !is_admin() && is_product() ) {

			return 'Option';

		} else {

			return $label;
			
		}

	}

	
add_filter( 'woocommerce_reset_variations_link', 'pc_woo_reset_variations_link' );

	function pc_woo_reset_variations_link() {

		// suppression lien reset
		return '';

	}


/*=====  FIN Ajout au panier  =====*/

/*===============================
=            Galerie            =
===============================*/

/*----------  Image datas  ----------*/

function pc_woo_get_gallery_item_datas( $img_id, $size = 'woocommerce_thumbnail' ) {
		
	$datas = array(
		'id' => $img_id,
		'urls' => array( 
			$size => wp_get_attachment_image_url( $img_id, $size ),
			'gl-m' => wp_get_attachment_image_url( $img_id, 'gl-m' ),
			'gl-l' => wp_get_attachment_image_url( $img_id, 'gl-l' )
		),
		'caption' => wp_get_attachment_caption( $img_id ),
		'alt' => get_post_meta( $img_id, '_wp_attachment_image_alt', true )
	);

	if ( $size == 'woocommerce_thumbnail' ) {
		$datas['urls']['woocommerce_single'] = wp_get_attachment_image_url( $img_id, 'woocommerce_single' );
	}
	
	return $datas;

}


/*----------  Affichage item liste  ----------*/

function pc_woo_get_gallery_item_html( $datas, $variation = false ) {

	global $images_sizes, $product_single_images_sizes;

	$item_class = 'wp-gallery-item';
	if ( $variation ) { $item_class .= ' wp-gallery-item--variation'; }

	$item = '<li class="'.$item_class.'" data-id="'.$datas['id'].'">';
	$item .= '<a class="wp-gallery-link" href="'.$datas['urls']['gl-l'].'" data-gl-caption="'.$datas['caption'].'" data-gl-responsive="'.$datas['urls']['gl-m'].'" title="Afficher l\'image">';

	if ( isset($datas['urls']['woocommerce_thumbnail']) ) {

		$size_s = $product_single_images_sizes['s'];
		$size_l = $product_single_images_sizes['l'];

		$srcset = $datas['urls']['woocommerce_thumbnail'].' '.$size_s.'w, '.$datas['urls']['woocommerce_single'].' '.$size_l.'w';
		$sizes = '(max-width:'.$size_s.'px) '.$size_s.'px, (min-width:'.($size_s+1).'px) and (max-width:'.$size_l.'px) '.$size_l.'px, '.$size_s.'px';

		$item .= '<img class="wp-gallery-img" src="'.$datas['urls']['woocommerce_single'].'" alt="'.$datas['alt'].'" width="'.$size_l.'" height="'.$size_l.'" srcset="'.$srcset.'" sizes="'.$sizes.'" loading="lazy" />';

	} else {

		$size_th = $product_single_images_sizes['th'];

		$item .= '<img class="wp-gallery-img" src="'.$datas['urls']['woocommerce_gallery_thumbnail'].'" width="'.$size_th.'" height="'.$size_th.'" alt="'.$datas['alt'].'" loading="lazy"/>';

	}

	// icône
	$item .= '<span class="wp-gallery-ico">'.pc_svg('zoom').'</span>';

	$item .= '</a>';
	$item .= '</li>';

	return $item;

}


/*----------  Affichage galerie  ----------*/

function pc_woo_display_product_single_gallery() {

	global $product;

	echo '<figure class="product-single-gallery"><ul class="wp-gallery reset-list">';

		// visuel principal
		if ( $product->get_image_id() && is_object( get_post( $product->get_image_id() ) ) ) {

			$image_datas = pc_woo_get_gallery_item_datas( $product->get_image_id() );
			echo pc_woo_get_gallery_item_html( $image_datas );	

			// visuels supplémentaires
			if ( count( $product->get_gallery_image_ids() ) > 0 ) {
	
				foreach ( $product->get_gallery_image_ids() as $id ) {
	
					if ( is_object( get_post( $id ) ) ) {
					
						$gallery_item_datas = pc_woo_get_gallery_item_datas( $id, 'woocommerce_gallery_thumbnail' );
						echo pc_woo_get_gallery_item_html( $gallery_item_datas );
	
					}
	
				}
	
			}			

		// visuel par défaut
		} else {

			echo '<li class="wp-gallery-item"><img class="wp-gallery-img" src="'.get_bloginfo( 'template_directory' ).'/images/square-default.jpg" width="700" height="700" alt="" loading="lazy" /></li>';

		}

	echo '</ul></figure>';

}

/*----------  Affichage json variations  ----------*/

function pc_woo_display_product_single_variations_json() {

	global $product;
	$variations_json = array();

	if ( 'variable' == $product->get_type() ) {

		$variations = $product->get_available_variations(); 

		foreach ( $variations as $variation ) {
			
			$variation_image_id = $variation['image_id'];
			$variation_images = $variation['image'];

			if ( $variation_image_id != $product->get_image_id() && !in_array( $variation_image_id, $product->get_gallery_image_ids() ) ) {

				$variation_image_datas = array(
					'id' => $variation_image_id,
					'urls' => array( 
						'woocommerce_thumbnail' => $variation_images['thumb_src'],
						'woocommerce_single' => $variation_images['src'],
						'gl-m' => wp_get_attachment_image_url( $variation_image_id, 'gl-m' ),
						'gl-l' => wp_get_attachment_image_url( $variation_image_id, 'gl-l' )
					),
					'caption' => $variation_images['caption'],
					'alt' => $variation_images['alt']
				);
				
				$variations_json[$variation_image_id] = pc_woo_get_gallery_item_html( $variation_image_datas, true );

			}

		}
		
		if (count( $variations_json ) > 0 ) {
			echo '<script>var pc_woo_variations = '.json_encode( $variations_json, JSON_UNESCAPED_SLASHES  ).'</script>';
		}

	}

}




/*=====  FIN Galerie  =====*/

/*==============================
=            Textes            =
==============================*/

/*----------  Propriétés  ----------*/

function pc_woo_display_product_single_properties() {

	global $product;

	/*----------  Poids  ----------*/	
	
	$weight_unit = get_option( 'woocommerce_weight_unit' );
	$weight = $product->get_weight();
	
	if ( '' != $weight ) { // temporaire
		
		echo '<ul class="single-product-datas reset-list">';

		if ( '' != $weight ) { // temporaire
			echo '<li class="single-product-datas-item"><strong>Poids : </strong>'.$weight.'&nbsp'.$weight_unit.'</li>';
		}

		echo '</ul>';

	}

}


/*----------  Wysiwyg  ----------*/

function pc_woo_display_product_single_wysiwyg() {

	the_content();
		
}


/*=====  FIN Textes  =====*/

/*=========================================
=            Produits associés            =
=========================================*/

function pc_woo_display_related_products() {

	global $pc_post;
	$metas = $pc_post->metas;

	if ( isset( $metas['_upsell_ids'] ) ) {

		$related_posts = get_posts( array(
			'post_type' => 'product',
			'post__in' => unserialize($metas['_upsell_ids'])
		) );

		if ( count( $related_posts ) > 0 ) {

			echo '<aside class="product-aside">';
			echo '<h2 class="product-aside-title">Produits associés</h2>';
			echo '<ul class="st-list st-list--related reset-list">';

				foreach ( $related_posts as $post ) {
					$pc_related_post = new PC_Post( $post );
					$pc_related_post_classes = wc_get_product_class( '', $pc_related_post->id );
					$pc_related_post_classes = array_diff( $pc_related_post_classes, array( 'main-content') );
					$pc_related_post_classes = implode( ' ', $pc_related_post_classes );
					
					echo '<li class="'.$pc_related_post_classes.' st st--product">';
						$pc_related_post->display_card('3');
					echo '</li>';
				}

			echo '</ul>';
			echo '</aside>';

		}

	}

}


/*=====  FIN Produits associés  =====*/

/*===================================
=            Lien retour            =
===================================*/

function pc_woo_display_product_single_back_link() {

	if ( is_product() ) {	

		$wp_referer = wp_get_referer();
			
		if ( $wp_referer ) {
			$back_link = $wp_referer;
			$back_title = 'Page précédente';
			$back_txt = 'Retour';
		} else {
			global $shop_name;
			$back_link = get_the_permalink( wc_get_page_id('shop') );
			$back_title = 'Page d\'accueil du catalogue';
			$back_txt = $shop_name;
		}

		echo '<div class="main-footer-prev"><a href="'.$back_link.'" class="button" title="'.$back_title.'"><span class="ico">'.pc_svg('arrow').'</span><span class="txt">'.$back_txt.'</span></a></div>';

	}

}


/*=====  FIN Lien retour  =====*/