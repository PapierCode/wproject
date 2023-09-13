<?php
/**
 * 
 * Thème enfant de WPréform
 * 
 */


/*----------  Styles  ----------*/

add_action( 'wp_enqueue_scripts', 'pc_enqueue_project_dependencies' );

    function pc_enqueue_project_dependencies() {
		
		$css_front_path = '/css/front.css';
		wp_enqueue_style( 'project-screen', get_stylesheet_directory_uri().$css_front_path, null, filemtime(get_stylesheet_directory().$css_front_path), 'screen' );
		$css_print_path = '/css/print.css';
		wp_enqueue_style( 'project-print', get_stylesheet_directory_uri().$css_print_path, null, filemtime(get_stylesheet_directory().$css_print_path), 'print' );

	}


/*----------  JS  ----------*/

add_filter( 'pc_filter_js_files', 'pc_enqueue_child_theme_js' );

	function pc_enqueue_child_theme_js( $js_files ) {

		if ( class_exists( 'woocommerce' ) ) {
			$js_project_woo_path = '/scripts/pc-preform.min.js';
			$js_files['wpreform'] = get_template_directory_uri().$js_project_woo_path.'?ver='.filemtime(get_template_directory().$js_project_woo_path); // version sans jquery
		}

		$js_project_path = '/scripts/pc-project.min.js';
		$js_files['project'] = get_stylesheet_directory_uri().$js_project_path.'?ver='.filemtime(get_stylesheet_directory().$js_project_path);

		return $js_files;

	}


/*----------  Admin  ----------*/

add_action( 'admin_enqueue_scripts', 'pc_enqueue_admin_project_dependencies' );

	function pc_enqueue_admin_project_dependencies() {

		wp_enqueue_style( 'pc-project-css-admin', get_stylesheet_directory_uri().'/css/admin.css', null, filemtime(get_stylesheet_directory().'/css/admin.css'), 'screen' );
		
	}	


/*===============================
=            Include            =
===============================*/	

if ( class_exists( 'woocommerce' ) ) {

	add_theme_support( 'woocommerce' );
	include 'woocommerce/_project/woocommerce.php';	

}

// include 'include/admin/admin.php';

include 'include/medias.php';
include 'include/form-contact.php';
include 'include/init.php';


/*----------  Custom post  ----------*/

// RELECTURE !

// define( 'XXX_POST_SLUG', 'xxxpost');
// define( 'XXX_TAX_SLUG', 'xxxtax');
// include 'include/xxx/register.php';
// include 'include/xxx/fields.php';
// include 'include/xxx/admin.php';
// include 'include/xxx/template_tax.php';
// include 'include/xxx/template_card.php';
// include 'include/xxx/template_single.php';


/*=====  FIN Include  =====*/