<?php
/**
 * 
 * Woocommerce template : catégories
 * 
 ** Hooks (suppressions)
 ** Hooks (ajouts)
 ** Liste
 ** Résumé
 * 
 */


/*===========================================
=            Hooks (suppression)            =
===========================================*/

// lien start (content-product-cat.php)
remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );

// ---------

// visual (content-product-cat.php)
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );

// ---------

// titre (content-product-cat.php)
remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );

// ---------

// lien end (content-product-cat.php)
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );


/*=====  FIN Hooks (suppression)  =====*/

/*======================================
=            Hooks (ajouts)            =
======================================*/

// résumé article start (content-product-cat.php)
add_action( 'woocommerce_before_subcategory', 'pc_woo_display_article_tag_start', 10 );

// ---------

// résumé contenu (content-product-cat.php)
add_action( 'woocommerce_shop_loop_subcategory_title', 'pc_woo_display_category_resum_content', 10 );

// ---------

// résumé article end (content-product-cat.php)
add_action( 'woocommerce_after_subcategory', 'pc_woo_display_article_tag_end', 10 );


/*=====  FIN Hooks (ajouts)  =====*/

/*=============================
=            Liste            =
=============================*/

/*----------  Nombre de catégories par page  ----------*/

add_filter( 'woocommerce_product_subcategories_args', 'pc_woo_edit_categories_per_page' );

	function pc_woo_edit_categories_per_page( $args ) {

		$current_page_number = ( get_query_var( 'catpaged' ) ) ? get_query_var( 'catpaged' ) : 1;

		$args['number'] = get_option( 'posts_per_page' );

		if ( $current_page_number > 1 ) {
			$args['offset'] = ($current_page_number - 1) * $args['number'];
		}

		return $args;

	}


/*----------  Footer  ----------*/
	
function pc_woo_display_category_single_footer() {

	if ( is_product_category() ) {
		
		$term = get_queried_object(); // catégorie courante (object)
		$terms_per_page = get_option( 'posts_per_page' ); // nombre de posts par page (int, cf. Paramètre WP)
		$terms_childrens = get_term_children( $term->term_id, 'product_cat' ); // enfants de la catégorie courante (array)

		// pour les catégories enfant
		$fake_query = null;
		$current_page_number = null;
		$pager_args = array();


		/*----------  Lien retour  ----------*/
		
		// si c'est une catégorie enfant
		if ( $term->parent > 0 ) {

			$term_parent = get_term( $term->parent );
			$back_link_url = get_term_link( $term_parent->term_id, 'product_cat' );
			$back_link_url_inner = $term_parent->name;

		// si ce n'est pas une catégorie enfant
		} else {

			global $woo_pages, $shop_name;
			$back_link_url = get_the_permalink( $woo_pages['shop'] );
			$back_link_url_inner = $shop_name;

		}

		// affichage
		echo '<nav class="main-footer-nav"><a href="'.$back_link_url.'" class="button" title="Retour '.$back_link_url_inner.'">'.pc_svg('arrow',null,'svg_block').'<span>'.$back_link_url_inner.'</span></a></nav>';


		/*----------  Pagination  ----------*/
		
		// si la catégorie courante a un nombre d'enfants au nombre de posts par page
		if ( count( $terms_childrens ) > $terms_per_page ) {

			$fake_query = (object) array( 'max_num_pages' => ceil( count( $terms_childrens ) / (int) $terms_per_page ) );
			$current_page_number = ( get_query_var( 'catpaged' ) ) ? get_query_var( 'catpaged' ) : 1;
			$pager_args = array( 'format' => '?catpaged=%#%#main');

		}

		// affichage pager
		pc_get_pager( $fake_query, $current_page_number, $pager_args );

	}

}


/*=====  FIN Liste  =====*/

/*==============================
=            Résumé            =
==============================*/

/*----------  CSS classes  ----------*/

add_filter( 'product_cat_class', 'pc_woo_edit_category_resum_css_classes', 10, 3 );

function pc_woo_edit_category_resum_css_classes( $classes, $class, $term ) {

	return array( 'st', 'st--product-cat' );

}


/*----------  Contenu  ----------*/

function pc_woo_display_category_resum_content( $term, $hn = 2 ) {

	// métas
	$term_metas = get_term_meta( $term->term_id );
	//titre
	$term_title = ( isset( $term_metas['resum-title'] ) ) ? $term_metas['resum-title'][0] : $term->name;
	// permalien
	$term_link = get_term_link( $term, 'product_cat' );
	$term_link_title = 'Voir les produits de la catégorie '.$term_title;
	// visuel
	$term_img_datas = pc_get_post_resum_img_datas( $term->term_id, $term_metas );
	// description
	if ( isset( $term_metas['resum-desc'] ) ) {
		$term_desc = $term_metas['resum-desc'][0];
	} else if ( isset( $term_metas['content-desc'] ) ) {
		$term_desc = wp_strip_all_tags( $term_metas['content-desc'][0] );
	} else {
		$term_desc = '';
	}


	/*----------  Affichage  ----------*/		

	echo '<div class="st-figure" aria-hidden="true">';
		pc_display_post_resum_img_tag( $term->term_id, $term_img_datas );
	echo '</div>';	

	echo '<h'.$hn.' class="st-title"><a href="'.$term_link.'" class="st-link" title="'.$term_link_title.'">'.$term_title.'</a></h'.$hn.'>';
	
	if ( '' != $term_desc ) {
		global $texts_lengths;
		echo '<p class="st-desc">';
			echo pc_words_limit( $term_desc, $texts_lengths['resum-desc'] ).'&hellip;';
			$post_ico_more = apply_filters( 'pc_filter_post_resum_ico_more', pc_svg('more-16') );
			$st_desc_ico_more_display = apply_filters( 'pc_st_desc_ico_more_display', true );
			if ( $st_desc_ico_more_display ) { echo ' <span class="st-desc-ico">'.$post_ico_more.'</span>';	}	
		echo '</p>';
	}
			
	$st_read_more_display = apply_filters( 'pc_st_read_more_display', false );
	if ( $st_read_more_display ) {
		echo '<div class="st-read-more" aria-hidden="true"><span class="st-read-more-ico">'.$post_ico_more.'</span> <span class="st-read-more-txt">Lire la suite</span></a></div>';
	}

}


/*=====  FIN Résumé  =====*/
