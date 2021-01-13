<?php

/**
 * 
 * Woocommerce : customisation de l'admin
 * 
 ** Include
 ** CSS
 ** Suppression du visuel dans les pages
 ** Suppression des étiquettes
 ** Renommage menu admin
 ** Navigation
 * 
 */


/*===============================
=            Include            =
===============================*/

include 'woo-admin-products.php';
include 'woo-admin-categories.php';
include 'woo-admin-attributs.php';
include 'woo-admin-orders.php';
include 'woo-admin-editor-caps.php';


/*=====  FIN Include  =====*/

/*===========================
=            CSS            =
===========================*/
 
add_action( 'admin_enqueue_scripts', 'pc_woo_admin_enqueue_scripts', 999 );

    function pc_woo_admin_enqueue_scripts() {

        wp_enqueue_style( 'pc-woo-css-admin', get_stylesheet_directory_uri().'/include/woocommerce/admin/woo-admin.css' );
        
    };
 
 
/*=====  FIN CSS  =====*/

/*============================================================
=            Suppression du visuel dans les pages            =
============================================================*/

// activé par Woo...

add_action( 'init', 'pc_woo_remove_page_thumbnail_support', 999 );

	function pc_woo_remove_page_thumbnail_support() {

		remove_post_type_support( 'page', 'thumbnail' );

	}


/*=====  FIN Suppression du visuel dans les pages  =====*/ 

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

/*==================================
=            Navigation            =
==================================*/

add_filter( 'manage_nav-menus_columns', 'pc_woo_admin_navigation_remove_metaboxes' );

	function pc_woo_admin_navigation_remove_metaboxes( $columns ) {

		remove_meta_box('add-post-type-product', 'nav-menus', 'side');
		remove_meta_box('add-product_cat', 'nav-menus', 'side');
		remove_meta_box('woocommerce_endpoints_nav_link', 'nav-menus', 'side');

		return $columns;

	}


/*=====  FIN Navigation  =====*/
