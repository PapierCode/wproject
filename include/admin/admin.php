<?php

/*====================================
=            Block Editor            =
====================================*/

/*----------  Dépendances JS & CSS  ----------*/

add_action( 'admin_enqueue_scripts', 'pc_project_admin_enqueue_scripts', 999 );

function pc_project_admin_enqueue_scripts() {

	wp_enqueue_style( 'pc-project-css-admin', get_stylesheet_directory_uri().'/css/admin.css' );

	wp_enqueue_script( 'pc-project-js-admin', get_stylesheet_directory_uri().'/include/admin/admin.js', ['wp-blocks', 'wp-block-library', 'wp-element', 'wp-editor', 'wp-hooks', 'wp-dom-ready', 'wp-edit-post'] );
	
};


/*----------  Suppressions divers  ----------*/

// révisions
add_action( 'init', function() { remove_post_type_support( 'page', 'revisions' ); });
// ??
remove_theme_support( 'block-templates' );
remove_theme_support( 'core-block-patterns' );


/*----------  Blocs ACF  ----------*/

include 'blocks/register-block-type.php';


/*----------  Blocs disponibles  ----------*/

add_filter( 'allowed_block_types_all', 'pc_allowed_block_types_all', 10, 2 );

	function pc_allowed_block_types_all( $block_editor_context, $editor_context ) {

		$block_editor_context = array(
			'core/paragraph',
			'core/heading',
			'core/list',
			'acf/pc-image',
			'acf/pc-gallery',
			'acf/pc-button',
			// 'acf/pc-cols',
			// 'acf/pc-quote'
		);
	
		return $block_editor_context;
		
	}


/*----------  ACF TinyMCE  ----------*/

add_filter( 'acf/fields/wysiwyg/toolbars' , 'pc_project_acf_tinymce_toolbars'  );

	function pc_project_acf_tinymce_toolbars( $toolbars ) {

		// pc_var($toolbars);
		$toolbars['Light'] = array( 
			1 => array(
				'undo',
				'redo',
				'removeformat',
				'|',
				'bold',
				'italic',
				'strikethrough',
				'charmap',
				'|',
				'bullist',
				'numlist',
				'|',
				'alignleft',
				'aligncenter',
				'alignright',
				'|',
				'link'
			)
		);

		return $toolbars;

	}
		
add_action('acf/input/admin_footer', 'fnas_acf_input_admin_footer');

	function fnas_acf_input_admin_footer() { ?>

		<script type="text/javascript">
		acf.add_filter( 'wysiwyg_tinymce_settings', function( mceInit, id ) {
			mceInit.paste_as_text = true;			
			mceInit.wp_autoresize_on = true;			
			return mceInit;			
		} );
		</script>

	<?php }



/*=====  FIN Block Editor  =====*/