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
		
		global $pc_term;
		$terms_childrens = $pc_term->childrens; // enfants de la catégorie courante (array)
		$terms_per_page = get_option( 'posts_per_page' ); // nombre de posts par page (int, cf. Paramètre WP)

		// pour les catégories enfant
		$fake_query = null;
		$current_page_number = null;
		$pager_args = array();


		/*----------  Pagination  ----------*/
		
		// si la catégorie courante a un nombre d'enfants supérieur au nombre de posts par page
		if ( count( $terms_childrens ) > $terms_per_page ) {

			$fake_query = (object) array( 'max_num_pages' => ceil( count( $terms_childrens ) / (int) $terms_per_page ) );
			$current_page_number = ( get_query_var( 'catpaged' ) ) ? get_query_var( 'catpaged' ) : 1;
			$pager_args = array( 'format' => '?catpaged=%#%#main');

		}

		// affichage pager
		pc_get_pager( $fake_query, $current_page_number, $pager_args );


		/*----------  Lien retour  ----------*/
		
		// si c'est une catégorie enfant
		if ( $pc_term->parent > 0 ) {

			$term_parent = get_term( $pc_term->parent );
			$back_link_url = get_term_link( $term_parent->term_id, 'product_cat' );
			$back_link_text = $term_parent->name;

		// si ce n'est pas une catégorie enfant
		} else {

			global $woo_pages, $shop_name;
			$back_link_url = get_the_permalink( $woo_pages['shop'] );
			$back_link_text = $shop_name;

		}

		// affichage
		echo '<a href="'.$back_link_url.'" class="previous button" title="Retour '.$back_link_text.'">'.pc_svg('arrow',null,'svg_block').'<span>'.$back_link_text.'</span></a>';

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

function pc_woo_display_category_resum_content( $term ) {

	$pc_term = new PC_Term( $term );
	$pc_term->display_card();

}


/*=====  FIN Résumé  =====*/
