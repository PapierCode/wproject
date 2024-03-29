<?php
/**
 * 
 * Custom post & taxonomy xxx : champs
 * 
 */

/*===================================
=            Champs post            =
===================================*/

/*----------  Reprise de métaboxes du thème parent ----------*/

add_filter( 'pc_filter_metabox_image_for', 'pc_xxx_admin_edit_metabox_for', 20, 1 );
add_filter( 'pc_filter_metabox_card_for', 'pc_xxx_admin_edit_metabox_for', 20, 1 );
add_filter( 'pc_filter_metabox_seo_for', 'pc_xxx_admin_edit_metabox_for', 20, 1 );

	function pc_xxx_admin_edit_metabox_for( $for ) {

		$for[] = XXX_POST_SLUG;
		return $for;
		
	}
	

/*----------  Champs spécifiques  ----------*/


if ( class_exists('PC_Add_Metabox') ) {

$xxx_post_args_coord = array(
    'prefix'    => 'xxx_prefix',
    'fields'    => array(
        array(
            'type'      => 'text',
            'id'        => 'xxx_id',
            'label'     => 'xxx_label',
            'required'  => true,
			'css'		=> 'width:100%'
		),
	)
);

$xxx_post_metabox_coord = new PC_Add_Metabox(
    XXX_POST_SLUG, 
    'xxx',
    'xxx',
    $xxx_post_args_coord
);


} // FIN if class_exists('PC_Add_Metabox')


/*=====  FIN Champs post  =====*/

/*========================================
=            Champs taxonomie            =
========================================*/

if ( class_exists('PC_add_field_to_tax') ) {

	$xxx_tax_img_fields_args = array(	
		'title'     => 'Visuel',
		'prefix'    => 'visual',
		'fields'    => array(
			array(
				'type'      => 'img',
				'id'        => 'id',
				'label'     => 'Image',
				'options'   => array(
					'btnremove' => true
				)
			)					
		)
	);

	$xxx_tax_img_fields = new PC_add_field_to_tax(
		XXX_TAX_SLUG,
		$xxx_tax_img_fields_args
	);

	$xxx_tax_content_fields_args = array(	
		'title'     => 'Contenu',
		'prefix'    => 'content',
		'fields'    => array(
			array(
				'type'      => 'wysiwyg',
				'id' 		=> 'desc', 
				'label'     => 'Introduction',
				'options'   => array(
					'media_buttons'	=> false,
					'tinymce'	=> array (
						'toolbar1'	=> 'fullscreen,undo,redo,removeformat,|,bold,italic,strikethrough,superscript,charmap,|,link,unlink',
					)
				)
			)
		)
	);

	$xxx_tax_content_fields = new PC_add_field_to_tax(
		XXX_TAX_SLUG,
		$xxx_tax_content_fields_args
	);

	$xxx_tax_card_fields_args = array(	
		'title'     => 'Résumé',
		'prefix'    => 'resum',
		'fields'    => array(
			array(
				'type'      => 'text',
				'id'        => 'title',
				'label'     => 'Titre',
				'attr'      => 'class="pc-counter" data-counter-max="40"',
				'css'		=> 'width:100%',
				'desc' 		=> 'Si ce champ n\'est pas saisi, le nom de la catégorie est utilisé.'
			),			
			array(
				'type'      => 'textarea',
				'id'        => 'desc',
				'label'     => 'Description',
				'attr'      => 'class="pc-counter" data-counter-max="150"',
				'css'		=> 'width:100%',
				'desc' 		=> 'Si ce champ n\'est pas saisi, les premiers mots de l\'introduction sont utilisés.<br/>Si l\'introduction n\'est pas saisie, aucune description n\'est affichée.'
			)						
		)
	);

	$xxx_tax_card_fields = new PC_add_field_to_tax(
		XXX_TAX_SLUG,
		$xxx_tax_card_fields_args
	);

	$xxx_tax_seo_fields_args = array(	
		'title'     => 'Référencement (SEO) & réseaux sociaux',
		'prefix'    => 'seo',
		'fields'    => array(
			array(
				'type'      => 'text',
				'id'        => 'title',
				'label'     => 'Titre',
				'attr'      => 'class="pc-counter" data-counter-max="70"',
				'css'		=> 'width:100%',
				'desc' 		=> 'Si ce champ n\'est pas saisi, le titre du résumé est utilisé.<br/>Si le titre du résumé n\'est pas saisi, le nom de la catégorie est utilisé.'
			),			
			array(
				'type'      => 'textarea',
				'id'        => 'desc',
				'label'     => 'Description',
				'attr'      => 'class="pc-counter" data-counter-max="200"',
				'css'		=> 'width:100%',
				'desc' 		=> 'Si ce champ n\'est pas saisi, la description du résumé est utilisée.<br/>Si la description du résumé n\'est pas saisie, les premiers mots de l\'introduction sont utilisés.<br/>Si l\'introduction n\'est pas saisie, la description par défaut est utilisée (cf. Paramètres).'
			)						
		)
	);

	$xxx_tax_seo_fields = new PC_add_field_to_tax(
		XXX_TAX_SLUG,
		$xxx_tax_seo_fields_args
	);


} // FIN if class_exists('PC_add_field_to_tax')

/*=====  FIN Champs taxonomie  =====*/