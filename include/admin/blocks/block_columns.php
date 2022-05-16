<?php
$columns = array();
			
// if ( have_rows ('_bloc_columns') ) { while ( have_rows('_bloc_columns') ) { the_row();

// 	if ( have_rows('_bloc_col_content') ) { while ( have_rows('_bloc_col_content') ) { the_row();

// 		switch ( get_row_layout() ) {
// 			case '_col_bloc_txt':
// 				$txt = get_sub_field('_col_bloc_txt_wysi');
// 				if ( $txt ) { $columns[] = pc_wp_wysiwyg( $txt ); }
// 				break;
// 			case '_col_bloc_image':
// 				$image = pc_get_acf_block_image_html( 
// 					get_sub_field('_bloc_img_id'), 
// 					get_sub_field('_bloc_img_align'),
// 					'large',
// 					$block['align']
// 				);
// 				if ( $image ) { $columns[] = $image; }
// 				break;
// 			case '_col_bloc_cta':
// 				$cta = pc_get_acf_block_cta_html( 
// 					get_sub_field('_bloc_cta_box'), 
// 					get_sub_field('_bloc_cta_title'), 
// 					get_sub_field('_bloc_cta_button_txt'), 
// 					get_sub_field('_bloc_cta_button_link')
// 				);
// 				if ( $cta ) { $columns[] = $cta; }
// 				break;
// 		}

// 	} }

// } }

// if ( !empty($columns) && count($columns) > 1 ) {

// 	$columns_css = array( 'bloc-columns', 'bloc-columns--'.count($columns), 'bloc-space--'.get_field('_bloc_space_v') );
// 	if ( 'wide' == $block['align'] ) { $columns_css[] = 'bloc-wide'; }

// 	echo '<div class="'.implode(' ',$columns_css).'">';
// 		foreach ( $columns as $column ) {
// 			echo $column;
// 		}
// 	echo '</div>';

// } else if ( $is_preview ) {

// 	echo '<p class="editor-error">Erreur bloc <em>Colonnes</em> : 2 colonnes minimum avec des blocs configurés.</p>';

// }
