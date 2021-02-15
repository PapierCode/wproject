<?php
/**
 * 
 * Woocommerce template : catégories
 * 
 ** Liste
 ** Résumé
 ** Contenu
 * 
 */


/*=============================
=            Liste            =
=============================*/

/*----------  Limite par page  ----------*/

add_filter( 'woocommerce_product_subcategories_args', 'pc_woo_categories_per_page' );

	function pc_woo_categories_per_page( $args ) {

		$current_page_number = ( get_query_var( 'catpaged' ) ) ? get_query_var( 'catpaged' ) : 1;

		$args['number'] = get_option( 'posts_per_page' );

		if ( $current_page_number > 1 ) {
			$args['offset'] = ($current_page_number - 1) * 6;
		}

		return $args;

	}


/*=====  FIN Liste  =====*/

/*==============================
=            Résumé            =
==============================*/

/*----------  Suppression  ----------*/

// lien (content-product-cat.php)
remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );
// visuel (content-product-cat.php)
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );


/*----------  CSS classes  ----------*/

add_filter( 'product_cat_class', 'pc_woo_category_resum_edit_css_classes', 10, 3 );

	function pc_woo_category_resum_edit_css_classes( $classes, $class, $term ) {

		return array( 'st', 'st--product-cat' );

	}


/*----------  Résumé : visuel, titre et description  ----------*/

// (content-product-cat.php)

remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );

add_action( 'woocommerce_shop_loop_subcategory_title', 'pc_woo_category_resum_display_texts', 10 );

	function pc_woo_category_resum_display_texts( $term, $hn = 2 ) {

		$term_metas = get_term_meta( $term->term_id );


		/*----------  Visuel  ----------*/
		
		$term_img_datas = pc_get_post_resum_img_datas( $term->term_id, $term_metas );

		echo '<figure class="st-figure">';
			pc_display_post_resum_img_tag( $term->term_id, $term_img_datas );
		echo '</figure>';


		/*----------  Titre & lien  ----------*/	
		
		$term_title = ( isset( $term_metas['resum-title'] ) ) ? $term_metas['resum-title'][0] : $term->name;
		$term_url = get_term_link( $term, 'product_cat' );

		echo '<h'.$hn.' class="st-title"><a href="'.$term_url.'">'.$term_title.'</a></h'.$hn.'>';

		/*----------  Description  ----------*/
		
		if ( isset( $term_metas['resum-desc'] ) ) {
			$term_desc = $term_metas['resum-desc'][0];
		} else if ( isset( $term_metas['content-desc'] ) ) {
			$term_desc = wp_trim_words( $term_metas['content-desc'][0] );
		} else {
			$term_desc = '';
		}
		
		if ( '' != $term_desc ) {
			echo '<p class="st-desc">'.pc_words_limit( $term_desc, 150 ).'...</p>';
		}

	}




/*=====  FIN Résumé  =====*/

/*===============================
=            Contenu            =
===============================*/

/*----------  Suppressions  ----------*/

// nombre de résultats (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
// classement (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
// pager
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );


/*----------  Description  ----------*/

// (archive-product.php)

remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

add_action( 'woocommerce_archive_description', 'pc_woo_category_details_display_description', 20 );

	function pc_woo_category_details_display_description() {

		if ( is_product_category() && !get_query_var( 'pcpaged' ) ) {

			$term = get_queried_object();
			$description = get_term_meta( $term->term_id, 'content-desc', true );

			if ( '' != $description ) {
				echo pc_wp_wysiwyg( $description );
			}

		}

	}


/*----------  Footer  ----------*/

// (archive-product.php)

add_action( 'woocommerce_after_main_content', 'pc_woo_category_footer' );
	
	function pc_woo_category_footer() {

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


/*=====  FIN Contenu  =====*/
