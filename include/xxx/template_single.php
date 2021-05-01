<?php
/**
 * 
 * Custom post xxx : single
 * 
 ** Redirection vers la template page
 ** Navigation, item actif
 ** Classe CSS
 ** Page précédente
 ** Contenu
 * 
 */


/*=========================================================
=            Redirection vers la template page            =
=========================================================*/

add_filter( 'single_template', 'pc_xxx_single_template', 999, 1 );

	function pc_xxx_single_template( $single_template ) {

		if ( is_singular( XXX_POST_SLUB ) ) {
			$single_template = get_template_directory().'/page.php';
		}

		return $single_template;

	}


/*=====  FIN Redirection vers la template page  =====*/

/*==============================================
=            Navigation, item actif            =
==============================================*/

add_filter( 'wp_nav_menu_objects', 'pc_xxx_nav_parent_active', NULL, 2 );

function pc_xxx_nav_parent_active( $menu_items, $args ) {

	// si menu d'entête
	if ( $args->theme_location == 'nav-header' ) {

		// si c'est une actualité d'afficher
		if ( is_singular( XXX_POST_SLUB ) ) {

			// page qui publie les actus
			$post = pc_get_page_by_custom_content( XXX_POST_SLUB, 'object' );
			if ( $post ) {
				// si la page qui publie les actus a un parent ou pas
				$id_to_search = ( $post->post_parent > 0 ) ? $post->post_parent : $post->ID;
			}

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


/*=====  FIN Navigation, item actif  =====*/

/*==================================
=            Classe CSS            =
==================================*/

add_filter( 'pc_filter_html_css_class', 'pc_xxx_html_css_class' );

function pc_xxx_html_css_class( $css_classes ) {

	if ( get_post_type() == XXX_POST_SLUB ) {
		$css_classes[] = 'is-xxx';
	}
	return $css_classes;

}


/*=====  FIN Classe CSS  =====*/

/*=======================================
=            Page précédente            =
=======================================*/

add_action( 'pc_action_main_footer', 'pc_xxx_back_link', 30, 1 );

function pc_xxx_back_link( $post ) {

	if ( $post->post_type == XXX_POST_SLUB ) {

		$wp_referer = wp_get_referer();
		
		if ( $wp_referer ) {
			$back_link = $wp_referer;
		} else {
			$back_link = pc_get_page_by_custom_content( XXX_POST_SLUB );
		}

		echo '<div class="main-footer-prev"><a href="'.$back_link.'" class="button" title="Page précédente">'.pc_svg('arrow',null,'svg_block').'<span>Retour</span></a></div>';

	}

}


/*=====  FIN Page précédente  =====*/

/*===============================
=            Contenu            =
===============================*/

add_action( 'pc_action_main_content', 'pc_xxx_content', 20, 2 );

	function pc_xxx_content( $post, $post_metas ) {

		if ( is_singular( XXX_POST_SLUB ) ) {

			
			
		}

	}


/*=====  FIN Contenu  =====*/