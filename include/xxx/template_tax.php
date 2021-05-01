<?php
/**
 * 
 * Custom tax xxx : résumé
 * 
 ** Item actif
 ** Navigation
 * 
 */


/*=============================================
=            Item navigation actif            =
=============================================*/

add_filter( 'wp_nav_menu_objects', 'pc_xxx_nav_active', NULL, 2 );

function pc_xxx_nav_active( $menu_items, $args ) {

	// si menu d'entête
	if ( $args->theme_location == 'nav-header' ) {

		// si page.php
		if ( is_tax( XXX_TAX_SLUG ) ) {
			
			$post = pc_get_page_by_custom_content( XXX_POST_SLUG, 'object' );
			$id_to_search = $post->ID;

		}
		
		// recherche de l'item
		if ( isset($id_to_search) ) {

			foreach ( $menu_items as $object ) {
				if ( $object->object_id == $id_to_search ) {
					// ajout classe WP (remplacée dans le Walker du menu)
					$object->classes[] = 'current-menu-item';
				}
			}

		}

	}

	return $menu_items;

};


/*=====  FIN Item navigation actif  =====*/

/*==================================
=            Navigation            =
==================================*/

function pc_xxx_display_nav_categories( $current_term = null ) {

	$terms = get_terms( array(
		'taxonomy' => XXX_TAX_SLUG,
		'hide_empty' => false,
	) );

	if ( !empty( $terms ) ) {

		echo '<nav class="nav-tax"><ul class="nav-tax-list reset-list">';

		foreach ( $terms as $term ) {
			
			$attr_active =  '';
			$attr_title = $term->name;
			$attr_aria = '';
			if ( $current_term && $term->term_id == $current_term->term_id ) {
				$attr_active =  ' is-active';
				$attr_title = $term->name.' (Page courante)';
				$attr_aria = 'aria-current="page"';
			}

			echo '<li class="nav-tax-item'.$attr_active.'">';
				echo '<a href="'.get_term_link($term,XXX_TAX_SLUG).'" class="nav-tax-link button" '.$attr_aria.' title="'.$attr_title.'">'.$term->name.'</a>';
			echo '</li>';
		}

		echo '</ul></nav>';
	}

}

add_action( 'pc_action_main_header', 'pc_xxx_page_display_nav_categories', 25, 2 );

	function pc_xxx_page_display_nav_categories( $post, $post_metas ) {

		if ( isset($post_metas['content-from']) && XXX_POST_SLUG == $post_metas['content-from'][0] ) {

			pc_xxx_display_nav_categories();

		}

	}


/*=====  FIN Navigation  =====*/