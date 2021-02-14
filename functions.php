<?php
/**
 * 
 * Thème enfant de WPréform
 * 
 */


/*----------  Styles  ----------*/

add_action( 'wp_enqueue_scripts', 'pc_enqueue_child_theme_style', 30 );

    function pc_enqueue_child_theme_style() {
		
		wp_enqueue_style( 'project-styles', get_stylesheet_directory_uri().'/project.css', null, null, 'screen' );

	}


/*----------  JS  ----------*/


add_filter( 'pc_filter_js_files', 'pc_enqueuechild_theme_js' );

	function pc_enqueuechild_theme_js( $js_files ) {

		// $js_files['wpreform'] = get_bloginfo('template_directory').'/scripts/scripts.min.js'; // version sans jquery
		$js_files['project'] = get_stylesheet_directory_uri().'/scripts/scripts.min.js';

		return $js_files;

	}
	
	
	

/*----------  WooCommerce  ----------*/

if ( class_exists( 'woocommerce' ) ) {

	add_theme_support( 'woocommerce' );
	include 'include/woocommerce/woocommerce.php';	

}


/*----------  Logo  ----------*/

// add_filter( 'pc_filter_header_logo', 'pc_project_header_logo' );

//     function pc_project_header_logo( $logoDatas ) {

//         $logoDatas['url'] = get_stylesheet_directory_uri().'/images/logo.svg';
//         return $logoDatas;

//     }

// add_filter( 'pc_filter_settings_project_fields', 'test_social' );

// function test_social( $settings ) {
// 	$settings[2]['fields'][] = array(
// 		'type'      => 'url',
// 		'label_for' => 'truc',
// 		'label'     => 'Truc',
// 		'css'       => 'width:100%'
// 	);
// 	return $settings;
// }
