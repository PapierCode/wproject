<?php

acf_register_block_type(array(
	'name'              => 'pc-button',
	'title'             => 'Bouton (CTA)',
	'icon'              => 'button',
	'category'          => 'text',
	'keywords'          => array( 'bouton' ),
	'mode'				=> 'auto',
	'supports'			=> array(
		'align' => array( 'wide' ),
		'anchor' => true
	),
	'render_callback'   => 'pc_acf_block_button',
));

function pc_acf_block_button( $block ) {

	$box_visibility = get_field('afficher-dans-un-encadre');
	$box_title = trim( get_field('titre-de-lencadre') );
	$box_css = array( 'wysi-cta' );
	if ( $box_visibility ) { $box_css[] = 'is-visible'; }

	$txt = get_field('texte-du-bouton');
	$link = get_field('lien-du-bouton');
	$link_attrs[] = 'href="'.$link['url'].'"';
	$link_attrs[] = 'class="wysi-button"';
    if ( $link['target'] ) { $link_attrs[] = 'target="'.$link['target'].'"'; }

	echo '<div class="'.implode( ' ', $box_css ).'">';
		if ( $box_visibility && '' != $box_title ) { echo '<h2 class="wysi-cta-title">'.$box_title.'</h2>'; }
		echo '<a '.implode( ' ', $link_attrs ).'>'.$txt.'</a>';
	echo '</div>';

}