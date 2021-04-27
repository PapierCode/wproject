<?php

/**
 * 
 * Woocommerce : customisation de l'admin
 * 
 ** Include
 ** CSS
 ** Pages
 ** Suppression des étiquettes
 ** Renommage menu admin
 ** Menus
 * 
 */


/*===============================
=            Include            =
===============================*/

include 'admin/woo-admin_products.php';
include 'admin/woo-admin_categories.php';
include 'admin/woo-admin_attributs.php';
include 'admin/woo-admin_orders.php';
include 'admin/woo-admin_caps.php';


/*=====  FIN Include  =====*/

/*===========================
=            CSS            =
===========================*/
 
add_action( 'admin_enqueue_scripts', 'pc_woo_admin_enqueue_scripts', 999 );

    function pc_woo_admin_enqueue_scripts() {

		wp_enqueue_style( 'pc-woo-css-admin', get_stylesheet_directory_uri().'/woocommerce/_project/admin/woo-admin.css' );
        
    };
 
 
/*=====  FIN CSS  =====*/

/*=============================
=            Pages            =
=============================*/

/*----------  Suppression metaboxes pages Woo  ----------*/

add_action( 'add_meta_boxes', 'pc_woo_admin_remove_specific_metaboxes', 999, 2 );

	function pc_woo_admin_remove_specific_metaboxes( $post_type, $post ) {
		
		global $woo_pages;
		
		if ( $post->ID == $woo_pages['shop'] ) {
			remove_meta_box( 'page-content-sup', 'page', 'normal' ); 
		}

	}

	
/*----------  Masquer les pages panier, mon compte et paiement  ----------*/

add_action( 'pre_get_posts' ,'pc_woo_admin_hide_pages' );

	function pc_woo_admin_hide_pages( $query ) {

		global $pagenow, $current_user_role;

		if( is_admin() && 'administrator' != $current_user_role && 'edit.php' == $pagenow && 'page' == $query->get('post_type') ) {

			global $woo_pages;
			$page_to_hide = array();

			foreach ( $woo_pages as $slug => $id ) {
				if ( 'shop' != $slug ) { $page_to_hide[] = $id; }
			}

			$query->set( 'post__not_in', $page_to_hide ); 

		}

	}


/*----------  Ne pas supprimer la page catalogue & CGV  ----------*/

add_filter( 'map_meta_cap', 'pc_woo_admin_prevent_delete_shop_page', 10, 4 );

	function pc_woo_admin_prevent_delete_shop_page( $caps, $cap, $user_id, $args ) {

		global $current_user_role;

		if ( 'editor' == $current_user_role && 'delete_post' == $cap ) {

			if ( wc_get_page_id('shop') == $args[0] || wc_terms_and_conditions_page_id() == $args[0] ) {
	
				$caps[] = 'do_not_allow';

			}
		}
	
		return $caps;

	}


/*----------  Suppression des pages Woo dans la liste des sous-pages  ----------*/
	
add_filter( 'pc_filter_page_metabox_subpages_args', 'pc_woo_remove_pages_from_subpages_list', 10, 2 );

	function pc_woo_remove_pages_from_subpages_list( $all_subpages_args, $post ) {

		global $woo_pages;

		foreach ( $woo_pages as $slug => $id ) {
			$all_subpages_args['post__not_in'][] = $id;
		}

		return $all_subpages_args;

	}


/*----------  Suppression du visuel dans les pages  ----------*/

// activé par Woo...

add_action( 'init', 'pc_woo_remove_page_thumbnail_support', 999 );

	function pc_woo_remove_page_thumbnail_support() {

		remove_post_type_support( 'page', 'thumbnail' );

	}


/*=====  FIN Pages  =====*/ 

/*==================================================
=            Suppression des étiquettes            =
==================================================*/

// modifier l'affichage plutôt que que désactiver qui provoque toute une série de message d'erreur

add_action('init', 'pc_woo_disable_product_tag', 999 );

	function pc_woo_disable_product_tag() {
		register_taxonomy(
			'product_tag',
			'product', [
				'public'            => false,
				'show_ui'           => false,
				'show_admin_column' => false,
				'show_in_nav_menus' => false,
				'show_tagcloud'     => false,
			]
		);
	};


/*=====  FIN Suppression des étiquettes  =====*/

/*============================================
=            Renommage menu admin            =
============================================*/


add_action( 'admin_menu', 'pc_woo_rename_admin_menu' );

	function pc_woo_rename_admin_menu() {

		global $menu;
		foreach ($menu as $key => $args) {
			if ( $args[0] == 'WooCommerce' ) {
				$menu[$key][0] = 'E-commerce';
				$menu[$key][6] = 'dashicons-products'; // + woo-admin.css
			}
		}

	}


/*=====  FIN Renommage menu admin  =====*/

/*=============================
=            Menus            =
=============================*/

/*----------  Suppressions métaboxes  ----------*/

add_filter( 'manage_nav-menus_columns', 'pc_woo_admin_navigation_remove_metaboxes' );

	function pc_woo_admin_navigation_remove_metaboxes( $columns ) {

		remove_meta_box('add-post-type-product', 'nav-menus', 'side');
		remove_meta_box('woocommerce_endpoints_nav_link', 'nav-menus', 'side');

		return $columns;

	}


/*----------  Suppressions pages Woo  ----------*/

add_filter( 'nav_menu_items_page_recent', 'pc_woo_admin_navigation_remove_pages', 10, 1 );
add_filter( 'nav_menu_items_page', 'pc_woo_admin_navigation_remove_pages', 10, 1 );

	function pc_woo_admin_navigation_remove_pages( $posts ) {

		$woo_pages = array(
			wc_get_page_id( 'cart' ), // panier
			wc_get_page_id( 'checkout' ), // validation
			wc_get_page_id( 'myaccount' ), // compte
		);

		foreach ($posts as $key => $post) {
			if ( in_array( $post->ID, $woo_pages ) ) { unset( $posts[$key] ); }
		};

		return $posts;

	}


/*=====  FIN Menus  =====*/
