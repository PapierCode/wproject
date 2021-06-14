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
			$js_files['wpreform'] = get_bloginfo('template_directory').'/scripts/pc-preform.min.js'; // version sans jquery
		}

		$js_files['project'] = get_stylesheet_directory_uri().'/scripts/pc-project.min.js';

		return $js_files;

	}
		

/*----------  WooCommerce  ----------*/

if ( class_exists( 'woocommerce' ) ) {

	add_theme_support( 'woocommerce' );
	include 'woocommerce/_project/woocommerce.php';	

}

/*===============================
=            Include            =
===============================*/

include 'include/images.php';


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


add_filter( 'pc_filter_post_contact_fields', 'pc_contact_test' );

	function pc_contact_test( $post_contact_fields ) {

		$post_contact_fields['fields'][] = array(
			'type'      		=> 'text',
			'id'        		=> 'truc',
			'label'     		=> 'Truc',
			'attr'				=> 'readonly',
			'css'       		=> 'width:100%',
		);
		return $post_contact_fields;

	}