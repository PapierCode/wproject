<?php
/**
 * 
 * Woocommerce template : boutique (accueil) & liste de catégories
 * 
 ** Layout (hooks)
 ** Entête
 ** Contenu
 ** Pied de page
 * 
 */


/*======================================
=            Layout (hooks)            =
======================================*/

// archive-product.php : accueil boutique et liste de catégories


/*----------  Suppressions  ----------*/

// titre (archive-product.php)
add_filter( 'woocommerce_show_page_title', function() { return false; } );

// description (archive-product.php)
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 ); // accueil boutique
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );	// catégorie

// messages (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
// nombre de résultats (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
// classement (archive-product.php)
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// pager (archive-product.php)
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );


/*----------  Ajouts  ----------*/

// cf. Layout dans woo_templates.php

// fil d'ariane (archive-product.php)
add_action( 'woocommerce_archive_description', 'pc_woo_display_shop_and_category_breadcrumb', 10 );
// titre (archive-product.php)
add_action( 'woocommerce_archive_description', 'pc_woo_display_shop_and_category_title', 20 );

// div.main-content start (archive-product.php)
add_action( 'woocommerce_before_shop_loop', 'pc_display_main_content_start', 10 ); // fonction wpreform
	// messages (archive-product.php)
	add_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 20 );
	// description (archive-product.php)
	add_action( 'woocommerce_before_shop_loop', 'pc_woo_display_shop_and_category_description', 30 );
	
// div.main-content end (archive-product.php)
add_action( 'woocommerce_after_shop_loop', 'pc_display_main_content_end', 10 ); // fonction wpreform

// pagination shop (archive-product.php)
add_action( 'woocommerce_after_main_content', 'pc_woo_display_shop_pager', 20 );
// catégorie footer (archive-product.php)
add_action( 'woocommerce_after_main_content', 'pc_woo_display_category_single_footer', 30 );


/*=====  FIN Layout (hooks)  =====*/

/*==============================
=            Entête            =
==============================*/

/*----------  Accueil boutique : fil d'ariane  ----------*/
/*----------  Liste de catégorie : fil d'ariane  ----------*/

function pc_woo_display_shop_and_category_breadcrumb() {

	pc_display_breadcrumb();

}


/*----------  Accueil boutique : titre  ----------*/
/*----------  Liste de catégorie : titre  ----------*/

function pc_woo_display_shop_and_category_title() {
	
	echo '<h1><span>'.woocommerce_page_title( false ).'</span></h1>';

}


/*=====  FIN Entête  =====*/

/*===============================
=            Contenu            =
===============================*/

/*----------  Accueil boutique : description  ----------*/
/*----------  Liste de catégorie : description  ----------*/

function pc_woo_display_shop_and_category_description() {

	if ( !get_query_var( 'catpaged' ) ) {

		if ( is_shop() ) {

			$description = get_post_field( 'post_content', wc_get_page_id('shop') );

		} else if ( is_product_category() ) {

			global $pc_term;
			$metas = $pc_term->metas;
			$description = ( isset( $metas['content-desc'] ) ) ? $metas['content-desc'] : '';

		}		
		
		if ( '' != $description ) {
			echo pc_wp_wysiwyg( $description );
		}

	}

}


/*----------  Liste de catégories  ----------*/

add_filter( 'woocommerce_product_subcategories_hide_empty', '__return_false' );

add_filter( 'woocommerce_product_subcategories_args', 'pc_woo_edit_categories_per_page' );

	function pc_woo_edit_categories_per_page( $args ) {

		$current_page_number = ( get_query_var( 'catpaged' ) ) ? get_query_var( 'catpaged' ) : 1;
		$args['number'] = get_option( 'posts_per_page' );
		$args['hide_empty'] = true;

		if ( $current_page_number > 1 ) {
			$args['offset'] = ($current_page_number - 1) * $args['number'];
		}

		return $args;

	}


/*=====  FIN Contenu  =====*/

/*====================================
=            Pied de page            =
====================================*/

/*----------  Accueil boutique : pagination  ----------*/

function pc_woo_display_shop_pager() {

	if ( is_shop() ) { 
		
		$terms = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'parent' => 0
		) );
		$fake_query = (object) array( 'max_num_pages' => ceil( count( $terms ) / get_option( 'posts_per_page' ) ) );
		$current_page_number = ( get_query_var( 'catpaged' ) ) ? get_query_var( 'catpaged' ) : 1;
		
		pc_get_pager( $fake_query, $current_page_number, array( 'format' => '?catpaged=%#%#main') );

	}

}


/*----------  Liste de catégories : lien retour et pagination  ----------*/

function pc_woo_display_category_single_footer() {

	if ( is_product_category() ) {
		
		global $pc_term;
		$terms_childrens = $pc_term->childrens; // enfants de la catégorie courante (array)
		$terms_per_page = get_option( 'posts_per_page' ); // nombre de posts par page (int, cf. Paramètre WP)

		// pour les catégories enfant
		$fake_query = null;
		$current_page_number = null;
		$pager_args = array();


		/*----------  Lien retour  ----------*/
		
		// si c'est une catégorie enfant
		if ( $pc_term->parent > 0 ) {

			$term_parent = get_term( $pc_term->parent );
			$back_link_url = get_term_link( $term_parent->term_id, 'product_cat' );
			$back_link_text = $term_parent->name;

		// si ce n'est pas une catégorie enfant
		} else {

			global $shop_name;
			$back_link_url = get_the_permalink( wc_get_page_id('shop') );
			$back_link_text = $shop_name;

		}

		// affichage
		echo '<div class="main-footer-prev"><a href="'.$back_link_url.'" class="button" title="Retour '.$back_link_text.'">'.pc_svg('arrow',null,'svg_block').'<span>'.$back_link_text.'</span></a></div>';		


		/*----------  Pagination  ----------*/
		
		// si la catégorie courante a un nombre d'enfants supérieur au nombre de posts par page
		if ( count( $terms_childrens ) > $terms_per_page ) {

			$fake_query = (object) array( 'max_num_pages' => ceil( count( $terms_childrens ) / (int) $terms_per_page ) );
			$current_page_number = ( get_query_var( 'catpaged' ) ) ? get_query_var( 'catpaged' ) : 1;
			$pager_args = array( 'format' => '?catpaged=%#%#main');

		}

		// affichage pager
		pc_get_pager( $fake_query, $current_page_number, $pager_args );

	}

}


/*=====  FIN Pied de page  =====*/
