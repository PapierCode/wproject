<?php
			
acf_register_block_type(array(
	'name'              => 'pc-gallery',
	'title'             => 'Galerie d\'images',
	'icon'              => 'format-gallery',
	'category'          => 'media',
	'keywords'          => array( 'image', 'galerie' ),
	'mode'				=> 'auto',
	'supports'			=> array(
		'align' => array( 'wide' ),
		'anchor' => true
	),
	'render_callback'   => 'pc_acf_block_gallery_render',
));

function pc_acf_block_gallery_render() {

	$gallery = get_field('images');

	if ( is_array( $gallery ) && count( $gallery ) > 0 ) {

		echo '<ul class="wp-gallery reset-list">';

		foreach ( $gallery as $img_id ) {

			$thumbnail_datas = wp_get_attachment_image_src( $img_id, 'gl-th' );

			if ( isset( $thumbnail_datas ) && $thumbnail_datas[3] == 1 ) {

				$medium_datas = wp_get_attachment_image_url( $img_id,'gl-m' );
				$large_datas = wp_get_attachment_image_url( $img_id,'gl-l' );

				$caption = wp_get_attachment_caption($img_id);
				$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true);

				// affichage
				echo '<li class="wp-gallery-item">';
					echo '<a class="wp-gallery-link" href="'.$large_datas.'" data-gl-caption="'.$caption.'" data-gl-responsive="'.$medium_datas.'" title="Afficher l\'image">';
						echo '<img class="wp-gallery-img" src="'.$thumbnail_datas[0].'" width="'.$thumbnail_datas[1].'" height="'.$thumbnail_datas[2].'" alt="'.$alt.'" loading="lazy"/>';
						echo '<span class="wp-gallery-ico">'.pc_svg('zoom').'</span>';
					echo '</a>';
				echo '</li>';

			}

		}

		echo '</ul>';

	}

}
