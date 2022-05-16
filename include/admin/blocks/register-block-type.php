<?php

add_action( 'acf/init', 'pc_acf_init_block_types' );

function pc_acf_init_block_types() {

	if ( function_exists( 'acf_register_block_type' ) ) {

		/*----------  Image  ----------*/
		
		acf_register_block_type(array(
			'name'              => 'pc-image',
			'title'             => 'Image',
			'icon'              => 'format-image',
			'category'          => 'media',
			'keywords'          => array( 'image' ),
			'mode'				=> 'auto',
			'supports'			=> array(
				'align' => false,
				'anchor' => true
			),
			'render_template'   => 'include/admin/blocks/block_image.php',
		));

		/*----------  Galerie d'images  ----------*/

		acf_register_block_type(array(
			'name'              => 'pc-gallery',
			'title'             => 'Galerie d\'images',
			'icon'              => 'format-gallery',
			'category'          => 'media',
			'keywords'          => array( 'image', 'galerie' ),
			'mode'				=> 'auto',
			'supports'			=> array(
				'align' => false,
				'anchor' => true
			),
			'render_template'   => 'include/admin/blocks/block_gallery.php',
		));

		/*----------  Colonnes  ----------*/
				
		acf_register_block_type(array(
			'name'              => 'pc-cols',
			'title'             => 'Colonnes',
			'icon'              => 'columns',
			'category'          => 'design',
			'keywords'          => array( 'colonne', 'colonnes' ),
			'mode'				=> 'auto',
			'supports'			=> array(
				'align' => false,
				'anchor' => true
			),
			'render_template'   => 'include/admin/blocks/block_columns.php',
		));

		/*----------  Bouton (CTA)  ----------*/

		acf_register_block_type(array(
			'name'              => 'pc-button',
			'title'             => 'Bouton (CTA)',
			'icon'              => 'button',
			'category'          => 'design',
			'keywords'          => array( 'bouton', 'cta' ),
			'mode'				=> 'auto',
			'supports'			=> array(
				'align' => false,
				'anchor' => true
			),
			'render_template'   => 'include/admin/blocks/block_button.php',
		));

		/*----------  Citation  ----------*/

		acf_register_block_type(array(
			'name'              => 'pc-quote',
			'title'             => 'Citation',
			'icon'              => 'format-quote',
			'category'          => 'design',
			'keywords'          => array( 'citation' ),
			'mode'				=> 'auto',
			'supports'			=> array(
				'align' => false,
				'anchor' => true
			),
			'render_template'   => 'include/admin/blocks/block_quote.php',
		));

	}

}

function pc_get_acf_block_cta_html( $frame, $title, $button_txt, $button_link, $space_v, $size ) {

	if ( '' == trim($button_txt) || !is_array($button_link) ) { return FALSE; }
	
	$block_css = array( 'bloc-cta', 'cta' );
	if ( $frame ) { $block_css[] = 'cta--frame'; }
	if ( 'x1' != $space_v ) { $block_css[] = 'bloc-space--'.$space_v; }
	if ( 'wide' == $size ) { $block_css[] = 'bloc-wide'; }

	$link_attrs[] = 'href="'.trim($button_link['url']).'"';	
	$link_attrs[] = 'class="cta-button"';
	if ( $button_link['target'] ) { $link_attrs[] = 'target="'.$button_link['target'].'"'; }

	$return = '<div class="'.implode( ' ', $block_css ).'">';
		if ( $frame && trim($title) ) { $return .= '<h2 class="cta-title">'.trim($title).'</h2>'; }
		$return .= '<a '.implode( ' ', $link_attrs ).'>'.trim($button_txt).'</a>';
	$return .= '</div>';

	return $return;

}

function pc_get_acf_block_image_html( $img_id, $img_align, $img_size, $space_v, $size ) {

	if ( $img_id ) {

		$caption = wp_get_attachment_caption( $img_id );

		$block_inner_tag = ( $caption ) ? 'figure' : 'div';
		$block_css = array( 'bloc-image', 'bloc-image--'.$img_align );
		if ( 'x1' != $space_v ) { $block_css[] = 'bloc-space--'.$space_v; }
		if ( 'wide' == $size ) { $block_css[] = 'bloc-wide'; }

	
		$return = '<div class="'.implode(' ',$block_css).'"><'.$block_inner_tag.'>';
			$return .= wp_get_attachment_image( $img_id, $size );
			if ( $caption ) {
				$return .= '<figcaption>'.$caption.'</figcaption>';
			}
		$return .= '</'.$block_inner_tag.'></div>';

		return $return;
	
	} else { return FALSE; }

}