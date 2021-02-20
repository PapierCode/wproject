<?php
/**
 * 
 * Thème enfant de WPréform
 * 
 */


/*----------  Styles  ----------*/

add_action( 'wp_enqueue_scripts', 'pc_enqueue_child_theme_style', 30 );

    function pc_enqueue_child_theme_style() {
		
		wp_enqueue_style( 'project-screen-styles', get_stylesheet_directory_uri().'/project.css', null, null, 'screen' );
		wp_enqueue_style( 'project-print-styles', get_stylesheet_directory_uri().'/print.css', null, null, 'print' );

	}


/*----------  JS  ----------*/


add_filter( 'pc_filter_js_files', 'pc_enqueuechild_theme_js' );

	function pc_enqueuechild_theme_js( $js_files ) {

		if ( class_exists( 'woocommerce' ) ) {
			$js_files['wpreform'] = get_bloginfo('template_directory').'/scripts/scripts.min.js'; // version sans jquery
		}

		$js_files['project'] = get_stylesheet_directory_uri().'/scripts/scripts.min.js';

		return $js_files;

	}
		

/*----------  WooCommerce  ----------*/

if ( class_exists( 'woocommerce' ) ) {

	add_theme_support( 'woocommerce' );
	include 'include/woocommerce/woocommerce.php';	

}

/*===============================
=            Include            =
===============================*/

include 'include/images.php';


/*=====  FIN Include  =====*/