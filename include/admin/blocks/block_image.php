<?php
			
acf_register_block_type(array(
	'name'              => 'pc-image',
	'title'             => 'Images',
	'icon'              => 'format-image',
	'category'          => 'media',
	'keywords'          => array( 'image' ),
	'mode'				=> 'auto',
	'supports'			=> array(
		'align' => array( 'wide' ),
		'anchor' => true
	),
	'render_callback'   => 'pc_acf_block_image_render',
));

function pc_acf_block_image_render( $block ) {

	$image_id = get_field('image');
	$caption = wp_get_attachment_caption($image_id);
	$container = ( '' != $caption ) ? 'figure' : 'div';

	$align = get_field('alignement');
	
	echo '<'.$container.' class="wysi-image wysi-image--'.$align.'">';
		echo wp_get_attachment_image( $image_id, 'full' );
		if ( '' != $caption ) {
			echo '<figcaption>'.$caption.'</figcaption>';
		}
	echo '</'.$container.'>';

}
