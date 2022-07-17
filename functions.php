<?php
/**
 * 
 * Thème enfant de WPréform
 * 
 */


/*----------  Styles  ----------*/

add_action( 'wp_enqueue_scripts', 'pc_enqueue_project_dependencies' );

    function pc_enqueue_project_dependencies() {
		
		wp_enqueue_style( 'project-screen', get_stylesheet_directory_uri().'/css/front.css', null, null, 'screen' );
		wp_enqueue_style( 'project-print', get_stylesheet_directory_uri().'/css/print.css', null, null, 'print' );

	}


/*----------  JS  ----------*/

add_filter( 'pc_filter_js_files', 'pc_enqueue_child_theme_js' );

	function pc_enqueue_child_theme_js( $js_files ) {

		if ( class_exists( 'woocommerce' ) ) {
			$js_files['wpreform'] = get_bloginfo('template_directory').'/scripts/pc-preform.min.js'; // version sans jquery
		}

		$js_files['project'] = get_stylesheet_directory_uri().'/scripts/pc-project.min.js';

		return $js_files;

	}


/*----------  Admin  ----------*/

add_action( 'admin_enqueue_scripts', 'pc_enqueue_admin_project_dependencies' );

	function pc_enqueue_admin_project_dependencies() {

		wp_enqueue_style( 'pc-project-css-admin', get_stylesheet_directory_uri().'/css/admin.css' );
		
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