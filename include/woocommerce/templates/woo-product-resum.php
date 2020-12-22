<?php
/**
 * 
 * Woocommerce : produit résumé
 * 
 ** Suppressions
 ** CSS classes
 ** Titre
 ** Visuel
 ** Ajout au panier (avec quantité)
 * 
 */

/*====================================
=            Suppressions            =
====================================*/

// lien (container)
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );


/*=====  FIN Suppressions  =====*/

/*===================================
=            CSS classes            =
===================================*/

add_filter( 'woocommerce_post_class', 'pc_woo_product_resum_css_classes', 10 ,2 );

	function pc_woo_product_resum_css_classes( $classes, $product ) {

		if ( is_product_category() ) {
			$classes[] = 'st';
			$classes[] = 'st--product';
		}

		return $classes;

	}


/*=====  FIN CSS classes  =====*/

/*=============================
=            Titre            =
=============================*/

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'pc_woo_product_resum_title', 10 );

	function pc_woo_product_resum_title() {

		echo '<h2 class="st-title">';
			echo '<a href="'.get_the_permalink().'">';
				echo get_the_title();
			echo '</a>';
		echo '</h2>';

	}


/*=====  FIN Titre  =====*/

/*==============================
=            Visuel            =
==============================*/

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'pc_woo_product_resum_image', 10 );

	function pc_woo_product_resum_image() {

		global $product;
		$img_id = get_post_thumbnail_id($product->id);
		$img_post = get_post( $img_id );

		if ( $img_id && is_object( $img_post ) ) {

			$img_urls = array(
				wp_get_attachment_image_src( $img_id,'st-400' )[0],
				wp_get_attachment_image_src( $img_id,'st-500' )[0],
				wp_get_attachment_image_src( $img_id,'st-700' )[0]
			);
			$img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);	

		} else {

			$img_urls = array(
				get_bloginfo('template_directory').'/images/st-default-400.jpg',
				get_bloginfo('template_directory').'/images/st-default-500.jpg',
				get_bloginfo('template_directory').'/images/st-default-700.jpg'
			);
			$img_alt = '';

		}

		$img_tag_srcset = $img_urls[0].' 400w, '.$img_urls[1].' 500w, '.$img_urls[2].' 700w';
		$img_tag_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 700px, (min-width:760px) 500px';
		$img_tag = '<img src="'.$img_urls[2].'" alt="'.$img_alt.'" srcset="'.$img_tag_srcset.'" sizes="'.$img_tag_sizes.'" loading="lazy" />';

		echo $img_tag;

	}


/*=====  FIN Visuel  =====*/

/*=======================================================
=            Ajout au panier (avec quantité)            =
=======================================================*/

// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
// add_action( 'woocommerce_after_shop_loop_item', 'pc_woo_st_add_to_cart', 20 );

//    function pc_woo_st_add_to_cart() {

// 		 global $product;

//          if($product->get_type() == 'variable'){
//             if ( !$product->is_on_backorder() ) { woocommerce_variable_add_to_cart(); }
//          } else {
//             woocommerce_simple_add_to_cart();
//          }

//    }


/*=====  FIN Ajout au panier (avec quantité)  =====*/
