<?php

	
add_action( 'enqueue_block_editor_assets', 'pc_project_enqueue_block_editor_assets' );

	function pc_project_enqueue_block_editor_assets() {

		wp_enqueue_script( 'project-block-editor-script',
			get_stylesheet_directory_uri().'/include/admin/block-editor/block-editor.js',
			array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
		);
		wp_enqueue_script( 'project-blocks-script',
			get_stylesheet_directory_uri().'/include/admin/block-editor/blocks/build/index.js',
			array( 'wp-blocks', 'wp-element', 'wp-editor' )
		);

		//wp_enqueue_style( 'papiercode-test-styles', get_stylesheet_directory_uri().'/include/admin/block-editor/build/index.css', null, null );
		
	}
