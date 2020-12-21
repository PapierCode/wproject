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
	

/*----------  WooCommerce  ----------*/

include 'include/woocommerce/woocommerce.php';	


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
