<?php
/**
 * 
 * Custom post xxx : admin
 * 
 ** Intégration au thème parent
 * 
 */


/*===================================================
=            Intégration au thème parent            =
===================================================*/
 
/*----------  Ajout de l'option dans les pages  ----------*/	
	
add_filter( 'pc_filter_settings_project', 'pc_xxx_admin_edit_page_content_from', 10, 1 );

function pc_xxx_admin_edit_page_content_from( $settings_project ) {

	$settings_project['page-content-from'][XXX_POST_SLUG] = array(
		'xxx',
		get_stylesheet_directory().'/include/xxx/template_archive.php'
	);

	return $settings_project;
	
}

// sauf si déjà publié
add_filter( 'pc_filter_page_metabox_select_content_from', 'pc_xxx_admin_edit_page_content_from_one_time', 10, 2 );

function pc_xxx_admin_edit_page_content_from_one_time( $content_from, $post ) {

	$page_with_products = pc_get_page_by_custom_content( XXX_POST_SLUG, 'object' );

	if( is_object( $page_with_products ) && $page_with_products->ID != $post->ID ) {

		unset( $content_from[XXX_POST_SLUG] );

	}

	return $content_from;

}


/*----------  Liste  ----------*/

// reprise de fonctions utilisées dans le thème parent pour afficher une vignette
add_action( 'manage_'.XXX_POST_SLUG.'_posts_columns', 'pc_page_edit_manage_posts_columns', 10, 2);
add_action( 'manage_'.XXX_POST_SLUG.'_posts_custom_column', 'pc_page_manage_posts_custom_column', 10, 2);


/*=====  FIN Intégration au thème parent  =====*/