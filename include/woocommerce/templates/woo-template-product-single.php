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
			$classes[] = 'single-product';
		}
		
		return $classes;

	}


/*=====  FIN CSS classes  =====*/

/*==============================
=            Entête            =
==============================*/

// (content-single-product.php)

add_action( 'woocommerce_before_single_product', 'pc_woo_single_product_display_header', 20 );

	function pc_woo_single_product_display_header() {

		global $product;
		$terms = get_the_terms( $product->get_id(), 'product_cat' );

		echo '<header class="main-header">';

			echo '<h1><span>'.$product->get_title().'</span></h1>';

			$latin_name = get_post_meta( $product->get_id(), 'txts-latin', true );
			if ( '' != $latin_name ) { echo '<p>'.$latin_name.'</p>'; }

			if ( count( $terms ) > 0 ) {

				$prefix = ( count( $terms ) > 1 ) ? 'Catégories' : 'Catégorie';
				echo '<dl class=""><dt>'.$prefix.'</dt>';
					foreach ( $terms as $key => $term ) {
						echo '<dd><a href="'.get_term_link( $term, 'product_cat' ).'" class="button" title="">'.$term->name.'</a></dd>';
					}
				echo '</dl>';

			}

		echo '</header>';
		
	}


/*=====  FIN Entête  =====*/

/*==============================
=            Layout            =
==============================*/

// (content-single-product.php)

add_action( 'woocommerce_before_single_product_summary', 'pc_woo_single_product_display_layout_start', 10 );

	function pc_woo_single_product_display_layout_start() {

		echo '<div class="single-product-layout">';

	}

add_action( 'woocommerce_after_single_product_summary', 'pc_woo_single_product_display_layout_end', 10 );

	function pc_woo_single_product_display_layout_end() {

		echo '</div>';

	}


/*=====  FIN Layout  =====*/

/*===============================
=            Visuels            =
===============================*/

add_filter( 'woocommerce_get_image_size_single', function( $size ) {
	return array(
		'width'  => 500,
		'height' => 500,
		'crop'   => 1,
	);
} );

/*=====  FIN Visuels  =====*/

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
				echo '<li class="single-product-datas-item"><strong>Poids du sachet : </strong>'.$weight.'&nbsp'.$weight_unit.'</li>';
			}

			echo '</ul>';

		}

	}


/*----------  Description  ----------*/

// (content-single-product.php)
add_action( 'woocommerce_after_single_product_summary', 'pc_woo_single_product_display_description', 20 );

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