<?php
/**
 * 
 * Woocommerce template : produit résumé
 * 
 ** Suppressions
 ** CSS classes
 ** Titre, description et visuel
 ** Ajout au panier (avec quantité)
 * 
 */

 
/*====================================
=            Suppressions            =
====================================*/

// (content-product.php)

// lien 
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
// titre 
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
// visuel 
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );


/*=====  FIN Suppressions  =====*/

/*===================================
=            CSS classes            =
===================================*/

add_filter( 'woocommerce_post_class', 'pc_woo_product_resum_edit_css_classes', 10 ,2 );

	function pc_woo_product_resum_edit_css_classes( $product_css_classes, $product ) {

		if ( is_product_category() ) {

			$product_css_classes[] = 'st';
			$product_css_classes[] = 'st--product';

		}

		return $product_css_classes;

	}


/*=====  FIN CSS classes  =====*/

/*====================================================
=            Titre, description et visuel            =
====================================================*/

// (content-product.php)

add_action( 'woocommerce_shop_loop_item_title', 'pc_woo_product_resum_display_content', 10 );

	function pc_woo_product_resum_display_content() {

		global $product;
		$product_id = $product->get_id();
		$product_link = get_the_permalink();
		$product_title = ( isset( $product_metas['resum-title'] ) ) ? $product_metas['resum-title'][0] : get_the_title();
		$product_metas = get_post_meta( $product_id );


		/*----------  Visuel  ----------*/		

		if ( isset( $product_metas['_thumbnail_id'] ) ) {
			$product_metas['visual-id'] = array( $product_metas['_thumbnail_id'][0] );
		}
		$img_datas = pc_get_post_resum_img_datas( $product->id, $product_metas );

		echo '<figure class="st-figure">';
			echo '<a href="'.$product_link.'">';
				pc_display_post_resum_img_tag( $product->id, $img_datas );
			echo '</a>';
		echo '</figure>';


		/*----------  Titre  ----------*/	

		echo '<h2 class="st-title">';
			echo '<a href="'.$product_link.'">'.$product_title.'</a>';
		echo '</h2>';	

		
		/*----------  Description  ----------*/
		
		$product_desc = pc_get_page_excerpt( $product_id, $product_metas );

		if ( '' != $product_desc ) {
			echo '<p class="st-desc">'.$product_desc.'...</p>';
		}		

	}


/*=====  FIN Titre, description et visuel  =====*/

/*=======================================================
=            Ajout au panier (avec quantité)            =
=======================================================*/

// (content-product.php)

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'woocommerce_after_shop_loop_item', 'pc_woo_product_resum_display_add_to_cart', 10 );

   function pc_woo_product_resum_display_add_to_cart() {

		global $product;

		if( 'simple' == $product->get_type() ) {

			woocommerce_simple_add_to_cart();
		
		}

   }


/*=====  FIN Ajout au panier (avec quantité)  =====*/
