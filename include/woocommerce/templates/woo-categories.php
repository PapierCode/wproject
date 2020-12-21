<?php

/*----------  Catégories  ----------*/


add_filter( 'product_cat_class', 'pc_woo_st_css_classes',10, 3 );

	function pc_woo_st_css_classes( $classes, $class, $category ) {

		return array( 'st', 'st--product-cat' );

	}


remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );

remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
add_action( 'woocommerce_shop_loop_subcategory_title', 'pc_woo_category_title', 10 );

	function pc_woo_category_title( $category ) {

		echo '<h2 class="st-title">';
		echo '<a href="'.esc_url( get_term_link( $category, 'product_cat' ) ).'">';
		echo esc_html( $category->name );
		echo '</a>';
		echo '</h2>';

	}

remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
add_action( 'woocommerce_before_subcategory_title', 'pc_woo_category_img', 10 );

	function pc_woo_category_img( $category ) {

		$img_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
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

		echo '<figure class="st-figure">';
			echo $img_tag;
		echo '</figure>';

	}
