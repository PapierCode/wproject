<?php

/**
 * 
 * Woocommerce : customisation de l'admin
 * 
 ** Include
 ** CSS
 ** Renommages divers
 ** Dashboard
 ** Pages
 ** Suppression des étiquettes
 ** Menu admin
 ** Menus
 ** Comptes
 * 
 */


/*===============================
=            Include            =
===============================*/

include 'admin/woo-admin_products.php';
include 'admin/woo-admin_categories.php';
include 'admin/woo-admin_attributs.php';
include 'admin/woo-admin_orders.php';


/*=====  FIN Include  =====*/

/*===========================
=            CSS            =
===========================*/
 
add_action( 'admin_enqueue_scripts', 'pc_woo_admin_enqueue_scripts', 999 );

    function pc_woo_admin_enqueue_scripts() {

		wp_enqueue_style( 'pc-woo-css-admin', get_stylesheet_directory_uri().'/woocommerce/_project/admin/woo-admin.css' );
		wp_enqueue_script( 'pc-woo-js-admin', get_stylesheet_directory_uri().'/woocommerce/_project/admin/woo-admin.js' );
        
    };
 
 
/*=====  FIN CSS  =====*/

/*=========================================
=            Renommages divers            =
=========================================*/

add_filter( 'gettext', 'pc_woo_admin_edit_gettext', 10, 3 );

	function pc_woo_admin_edit_gettext( $translation, $text, $domain ) {

		if ( is_admin() && $text == 'WooCommerce Status' ) {
			$translation = 'E-commerce';
		}

		return $translation;

	}


/*=====  FIN Renommages divers  =====*/

/*=================================
=            Dashboard            =
=================================*/

/*----------  Suppression widget  ----------*/

add_action('wp_dashboard_setup', 'pc_woo_remove_dashboard_widgets', 40);

	function pc_woo_remove_dashboard_widgets() {

		remove_meta_box( 'wc_admin_dashboard_setup', 'dashboard', 'normal');
		
	}


/*=====  FIN Dashboard  =====*/

/*=============================
=            Pages            =
=============================*/

/*----------  Suppression metaboxes pages Woo  ----------*/

add_action( 'add_meta_boxes', 'pc_woo_admin_remove_specific_metaboxes', 999, 2 );

	function pc_woo_admin_remove_specific_metaboxes( $post_type, $post ) {
				
		if ( $post->ID == wc_get_page_id('shop') ) {
			remove_meta_box( 'page-content-sup', 'page', 'normal' ); 
		}

	}

	
/*----------  Masquer les pages panier, mon compte et paiement  ----------*/

add_action( 'pre_get_posts' ,'pc_woo_admin_hide_pages' );

	function pc_woo_admin_hide_pages( $query ) {

		global $pagenow, $current_user_role;

		if( is_admin() && 'administrator' != $current_user_role && 'edit.php' == $pagenow && 'page' == $query->get('post_type') ) {

			$woo_pages = array(
				'cart' => wc_get_page_id('cart'),
				'checkout' => wc_get_page_id('checkout'),
				'myaccount' => wc_get_page_id('myaccount')
			);
			$page_to_hide = array();

			foreach ( $woo_pages as $slug => $id ) {
				$page_to_hide[] = $id;
			}

			$query->set( 'post__not_in', $page_to_hide ); 

		}

	}


/*----------  Ne pas supprimer des pages catalogue & CGV  ----------*/

add_filter( 'map_meta_cap', 'pc_woo_admin_prevent_delete_page', 10, 4 );

	function pc_woo_admin_prevent_delete_page( $caps, $cap, $user_id, $args ) {

		global $current_user_role;

		if ( 'shop_manager' == $current_user_role && 'delete_post' == $cap ) {

			if ( wc_get_page_id('shop') == $args[0] || wc_terms_and_conditions_page_id() == $args[0] ) {
	
				$caps[] = 'do_not_allow';

			}
		}
	
		return $caps;

	}

add_filter( 'wp_list_table_show_post_checkbox', 'pc_woo_checkbox', 10, 2 );

	function pc_woo_checkbox( $show, $post ) {

		global $current_user_role;

		if ( 'editor' == $current_user_role || 'shop_manager' == $current_user_role ) {

			if ( $post->ID == wc_get_page_id('shop') || $post->ID == wc_terms_and_conditions_page_id() ) {

				$show = false;

			}

		}

		return $show;

	}


/*----------  Ne pas modififer le status des pages catalogue & CGV  ----------*/

add_filter( 'wp_insert_post_data', 'pc_woo_prevent_update_status', 10, 4 );

	function pc_woo_prevent_update_status( $data, $postarr, $unsanitized_postarr, $update ) {
		
		// force le status
		if ( $update && ( 'page' == $data['post_type'] && ( wc_get_page_id('shop') == $postarr['ID'] || wc_terms_and_conditions_page_id() == $postarr['ID'] ) ) ) {
			$data['post_status'] = 'publish';
			$data['post_password'] = '';
		}

		return $data;
		
	}


/*----------  Suppression des pages Woo dans la liste des sous-pages  ----------*/
	
add_filter( 'pc_filter_page_metabox_subpages_args', 'pc_woo_remove_pages_from_subpages_list', 10, 2 );

	function pc_woo_remove_pages_from_subpages_list( $all_subpages_args, $post ) {

		$woo_pages = array(
			'shop' => wc_get_page_id('shop'),
			'cart' => wc_get_page_id('cart'),
			'checkout' => wc_get_page_id('checkout'),
			'myaccount' => wc_get_page_id('myaccount')
		);

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

/*==================================
=            Menu admin            =
==================================*/

add_action( 'admin_menu', 'pc_woo_rename_admin_menu', 999 );

	function pc_woo_rename_admin_menu() {

		global $menu, $submenu, $current_user_role;

		if ( 'shop_manager' == $current_user_role ) {

			// WooCommerce : déplacer l'accueil pour le masquer...
			$woo_home = $submenu['woocommerce'][0];
			unset( $submenu['woocommerce'][0]);
			$submenu['woocommerce'][] = $woo_home;

			// WooCommerce
			remove_submenu_page( 'woocommerce', 'wc-reports' ); // ancienne version
			remove_submenu_page( 'woocommerce', 'wc-settings' ); // réglages
			remove_submenu_page( 'woocommerce', 'wc-status' ); // état
			remove_submenu_page( 'woocommerce', 'wc-addons' ); // extensions
			remove_submenu_page( 'woocommerce', 'wpo_wcpdf_options_page' ); // plugin pdf facture et bon de livraison

			// Marketing, supprimer l'accueil 
			remove_submenu_page( 'woocommerce-marketing', 'admin.php?page=wc-admin&path=/marketing' );

			// Icône & renommage
			foreach ($menu as $key => $args) {
				if ( in_array( $args[0], array( 'WooCommerce', 'Produits', 'Marketing', 'Statistiques' ) ) ) {
					$menu[$key][6] = 'dashicons-store';
				}
				if ( 'WooCommerce' == $args[0] ) {
					$menu[$key][0] = 'Commandes';
				}
			}

		}

	}


/*----------  Sous-menus statistiques  ----------*/

add_filter( 'woocommerce_analytics_report_menu_items', 'pc_woo_edit_analytics_report_menu_items' );

	function pc_woo_edit_analytics_report_menu_items( $report_pages ) {

		global $current_user_role;

		if ( 'shop_manager' == $current_user_role ) {

			$items_to_remove = array(
				'woocommerce-analytics-taxes',
				'woocommerce-analytics-downloads',
				'woocommerce-analytics-settings'
			);

			foreach ($report_pages as $key => $page) {			
				if ( isset( $page['id'] ) && in_array( $page['id'], $items_to_remove ) ) {
					unset( $report_pages[$key] );				
				}
			}

		}

		return $report_pages;

	}

/*=====  FIN Menu admin  =====*/

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

/*===============================
=            Comptes            =
===============================*/

add_filter( 'user_row_actions', 'pc_woo_admin_user_row_actions' );

	function pc_woo_admin_user_row_actions( $actions ) {

		unset( $actions['view'] );
		return $actions;

	}


/*=====  FIN Comptes  =====*/
