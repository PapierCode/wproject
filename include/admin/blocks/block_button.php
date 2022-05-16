<?php
$cta = pc_get_acf_block_cta_html( 
	get_field('_bloc_cta_box'), // cadre ?
	get_field('_bloc_cta_title'), // titre si encadré
	get_field('_bloc_cta_button_txt'), // texte du bouton
	get_field('_bloc_cta_button_link'), // href du bouton
	get_field('_bloc_space_v'), // espacement vertical
	get_field('_bloc_size') // largeur du bloc
);

if ( $cta ) {
	
	echo $cta;

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Bouton (CTA)</em> : saisissez au moins le texte et le lien du bouton.</p>';

}