<?php

/*====================================
=            Block Editor            =
====================================*/

add_action( 'init', function() {
	remove_post_type_support( 'page', 'revisions' );
});

remove_theme_support(  'block-templates' );
remove_theme_support( 'core-block-patterns' );


/*----------  Blocs ACF  ----------*/

add_action('acf/init', 'pc_acf_init_block_types');

	function pc_acf_init_block_types() {
	
		if ( function_exists( 'acf_register_block_type' ) ) {
	
			// Image
			include 'blocks/block_image.php';
			// Galerie
			include 'blocks/block_gallery.php';
			// Bouton
			include 'blocks/block_button.php';
			// Colonnes
			include 'blocks/block_columns.php';
	
		}
	
	}


/*----------  Blocs disponibles  ----------*/

add_filter( 'allowed_block_types_all', 'pc_allowed_block_types_all', 10, 2 );

	function pc_allowed_block_types_all ( $block_editor_context, $editor_context ) {

		$block_editor_context = array(
			'core/paragraph',
			'core/heading',
			'core/list',
			'core/quote',
			//'core/columns',
			'acf/pc-image',
			'acf/pc-gallery',
			'acf/pc-button'
		);
	
		return $block_editor_context;
		
	}


/*----------  Dépendances JS & CSS  ----------*/

add_action( 'admin_enqueue_scripts', 'pc_project_admin_enqueue_scripts', 999 );

    function pc_project_admin_enqueue_scripts() {

		wp_enqueue_style( 'pc-project-css-admin', get_stylesheet_directory_uri().'/css/admin.css' );

        wp_enqueue_script( 'pc-project-js-admin', get_stylesheet_directory_uri().'/include/admin/admin.js', ['wp-blocks', 'wp-block-library', 'wp-element', 'wp-editor', 'wp-hooks', 'wp-dom-ready', 'wp-edit-post'] );
        
    };



/*=====  FIN Block Editor  =====*/
