<?php
/**
 * 
 * Thème enfant du dossier "pc-preform"
 * 
 */


/*----------  Styles  ----------*/

add_action( 'wp_enqueue_scripts', 'pc_enqueue_child_theme_style', 999 );

    function pc_enqueue_child_theme_style() {
    
		wp_enqueue_style( 'preform-child-style', get_stylesheet_directory_uri() . '/style.css',null, null, null, 'screen' );
		
		global $settings_project;
		if ( $settings_project['theme'] == 'fullscreen' ) {
			wp_enqueue_style( 'project-fullscreen-style', get_stylesheet_directory_uri().'/v-fullscreen.css', null, null, 'screen' );
		} else {
			wp_enqueue_style( 'project-classic-style', get_stylesheet_directory_uri().'/v-classic.css', null, null, 'screen' );
		}

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