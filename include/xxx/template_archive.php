<?php
/**
 * 
 * Custom post xxx : page archive
 * 
 */  

 
global $settings_project, $xxx_query, $xxx_page_number;

// page en cours (pager)
$xxx_page_number = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

/*=============================
=            Query            =
=============================*/

$xxx_query_args = array(
    'post_type' => XXX_POST_SLUG,
    'posts_per_page' => get_option( 'posts_per_page' ),
	'paged' => $xxx_page_number
);

$xxx_query = new WP_Query( $xxx_query_args );


/*=====  FIN Query  =====*/

/*=================================
=            Affichage            =
=================================*/

if ( $xxx_query->have_posts() ) {

	$post_title = get_the_title( $post->ID );

	// données structurées
	$xxx_schema = array(
		'@context' => 'http://schema.org/',
		'@type'=> 'CollectionPage',
		'name' => pc_get_post_seo_title( $post, $post_metas ),
		'headline' => pc_get_post_seo_title( $post, $post_metas ),
		'description' => pc_get_post_seo_description( $post, $post_metas ),
		'mainEntity' => array(
			'@type' => 'ItemList',
			'itemListElement' => array()
		),
		'isPartOf' => pc_get_schema_website()
	);
	global $post_resum_schema;

	echo '<ul class="st-list st-list--xxx reset-list">';

	// affichage des actus
    while ( $xxx_query->have_posts() ) { $xxx_query->the_post();

		pc_display_post_resum( $xxx_query->post->ID, 'st--xxx', 2 );
		// données structurées
		$xxx_schema['mainEntity']['itemListElement'][] = $post_resum_schema;

	}
	
	echo '</ul>';

	// affichage données structurées
	echo '<script type="application/ld+json">'.json_encode($xxx_schema,JSON_UNESCAPED_SLASHES).'</script>';
	
	// pagination
	add_action( 'pc_action_page_main_footer', 'pc_xxx_add_pager', 25 );

		function pc_xxx_add_pager() {
			
			global $xxx_query, $xxx_page_number;
			pc_get_pager( $xxx_query, $xxx_page_number );
			
		}
    
}
 
 
 /*=====  FIN Affichage  =====*/
 
 // reset query
 wp_reset_postdata();