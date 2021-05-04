<?php
/**
 * 
 * Custom post xxx : archive
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

	global $pc_post;

	// données structurées
	$xxx_schema = array(
		'@context' => 'http://schema.org/',
		'@type'=> 'CollectionPage',
		'name' => $pc_post->get_seo_meta_title(),
		'headline' => $pc_post->get_seo_meta_title(),
		'description' => $pc_post->get_seo_meta_description(),
		'mainEntity' => array(
			'@type' => 'ItemList',
			'itemListElement' => array()
		),
		'isPartOf' => pc_get_schema_website()
	);
	// compteur position itemListElement
	$xxx_list_item_key = 1;

	echo '<ul class="st-list st-list--xxx reset-list">';

	// affichage des actus
    while ( $xxx_query->have_posts() ) { $xxx_query->the_post();
		
		// début d'élément
		echo '<li class="st st--xxx">';

			$xxx_post = new PC_Post( $xxx_query->post );
			
			// affichage résumé
			$xxx_post->display_card();
			// données structurées
			$xxx_schema['mainEntity']['itemListElement'][] = $xxx_post->get_schema_list_item( $xxx_list_item_key );
			$xxx_list_item_key++;
		
		// fin d'élément
		echo '</li>';

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