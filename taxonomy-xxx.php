<?php

get_header();

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$term_title = $term->name;
$term_metas = get_term_meta( $term->term_id );

pc_display_main_start();

	pc_display_main_header_start();

		echo '<h1><span>'.$term_title.'</span></h1>';

		pc_xxx_display_nav_categories( $term );

	pc_display_main_header_end();

	pc_display_main_content_start();

		if ( isset($term_metas['content-desc']) ) {
			$term_desc = $term_metas['content-desc'][0];
			echo pc_wp_wysiwyg($term_desc);
		} else {
			$term_desc = $settings_project['seo-desc'];
		}

		// données structurées
		$term_schema = array(
			'@context' => 'http://schema.org/',
			'@type'=> 'CollectionPage',
			'name' => $term_title,
			'headline' => $term_title,
			'description' => sanitize_text_field($term_desc),
			'mainEntity' => array(
				'@type' => 'ItemList',
				'itemListElement' => array()
			),
			'isPartOf' => pc_get_schema_website()
		);
		global $st_schema;

		echo '<ul class="st-list st-list--club reset-list">';	

		if ( have_posts() ) : while ( have_posts() ) : the_post(); // Boucle WP (1/2)
		
			pc_display_post_resum( $post->ID, 'st--club', 2 );
			$term_schema['mainEntity']['itemListElement'][] = $post_resum_schema;

		endwhile; endif; // Boucle WP (2/2)

		echo '</ul>';

		// affichage données structurées
		echo '<script type="application/ld+json">'.json_encode($term_schema,JSON_UNESCAPED_SLASHES).'</script>';

	pc_display_main_content_end();

	pc_display_main_footer_start();

		$wp_referer = wp_get_referer();
				
		if ( $wp_referer ) {
			$back_link = $wp_referer;
		} else {
			$back_link = pc_get_page_by_custom_content( XXX_POST_SLUG );
		}

		echo '<a href="'.$back_link.'" class="previous button" title="Page précédente">'.pc_svg('arrow').'<span>Retour</span></a>';

		pc_display_share_links();

	pc_display_main_footer_end();


pc_display_main_end();

get_footer();