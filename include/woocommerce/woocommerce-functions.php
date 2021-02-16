<?php 

function pc_woo_get_resum_link_tag_start( $type, $class, $href, $title ) {

	switch ( $type ) {
		case 'category':
			$title = 'Voir les produits de la catégorie '.$title;
			break;
		case 'product':
			$title = 'En savoir plus sur le produit '.$title;
			break;
	}
	return '<a href="'.$href.'" class="'.$class.'" title="'.$title.'">';

}

function pc_woo_category_resum_display_content( $term, $hn = 2 ) {

	// métas
	$term_metas = get_term_meta( $term->term_id );
	//titre
	$term_title = ( isset( $term_metas['resum-title'] ) ) ? $term_metas['resum-title'][0] : $term->name;
	// permalien
	$term_link = get_term_link( $term, 'product_cat' );
	// visuel
	$term_img_datas = pc_get_post_resum_img_datas( $term->term_id, $term_metas );
	// description
	if ( isset( $term_metas['resum-desc'] ) ) {
		$term_desc = $term_metas['resum-desc'][0];
	} else if ( isset( $term_metas['content-desc'] ) ) {
		$term_desc = wp_trim_words( $term_metas['content-desc'][0] );
	} else {
		$term_desc = '';
	}


	/*----------  Affichage  ----------*/		

	echo '<figure class="st-figure">';
		pc_display_post_resum_img_tag( $term->term_id, $term_img_datas );
	echo '</figure>';	

	echo '<h'.$hn.' class="st-title">'.pc_woo_get_resum_link_tag_start( 'category', 'st-title-link', $term_link, $term_title ).$term_title.'</a></h'.$hn.'>';
	
	if ( '' != $term_desc ) {
		global $texts_lengths;
		echo '<p class="st-desc">'.pc_words_limit( $term_desc, $texts_lengths['resum-desc'] ).'...</p>';
	}

	echo pc_woo_get_resum_link_tag_start( 'category', 'st-read-more button', $term_link, $term_title ).'<span class="st-read-more-ico">'.pc_svg('more-16').'</span> <span class="st-read-more-txt">Voir les produits</span><span class="visually-hidden"> de la catégorie '.$term_title.'</span></a>';

}


function pc_woo_product_resum_display_content( $custom_product, $hn = 2 ) {

	if ( is_object( $custom_product ) ) {
		$product = $custom_product;
	} else {
		global $product;
	}

	// id 
	$product_id = $product->get_id();
	// métas
	$product_metas = get_post_meta( $product_id );
	// titre
	$product_title = ( isset( $product_metas['resum-title'] ) ) ? $product_metas['resum-title'][0] : get_the_title();
	// permalien
	$product_link = get_the_permalink();
	// visuel
	if ( isset( $product_metas['_thumbnail_id'] ) ) {
		$product_metas['visual-id'] = array( $product_metas['_thumbnail_id'][0] );
	}
	$img_datas = pc_get_post_resum_img_datas( $product_id, $product_metas );
	// description
	$product_desc = pc_get_page_excerpt( $product_id, $product_metas );


	/*----------  Affichage  ----------*/		

	echo '<figure class="st-figure">';
		pc_display_post_resum_img_tag( $product_id, $img_datas );
	echo '</figure>';

	echo '<h'.$hn.' class="st-title">'.pc_woo_get_resum_link_tag_start( 'product', 'st-title-link', $product_link, $product_title ).$product_title.'</a></h'.$hn.'>';	

	if ( '' != $product_desc ) {
		echo '<p class="st-desc">'.$product_desc.'...</p>';
	}

	echo pc_woo_get_resum_link_tag_start( 'product', 'st-read-more button', $product_link, $product_title ).'<span class="st-read-more-ico">'.pc_svg('more-16').'</span> <span class="st-read-more-txt">En savoir plus</span><span class="visually-hidden"> sur le produit '.$product_title.'</span></a>';

}