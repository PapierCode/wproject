<?php
/**
 * 
 * Woocommerce admin : catégories
 * 
 ** Suppressions
 ** Liste
 ** Nouveaux champs
 * 
 */


/*====================================
=            Suppressions            =
====================================*/

/*----------  Hiérarchie  ----------*/

//add_filter( 'woocommerce_taxonomy_args_product_cat', 'pc_woo_admin_product_cat_register_args' );

	// function pc_woo_admin_product_cat_register_args( $args ) {

	// 	$args['hierarchical'] = false;

	// 	return $args;

	// }
	

/*----------  Champs & messages  ----------*/
	
add_action( 'admin_init', 'pc_woo_admin_product_cat_remove_default_fields' );

function pc_woo_admin_product_cat_remove_default_fields() {

	$cat_instance = WC_Admin_Taxonomies::get_instance();
	
	// type d'affichage et miniature
	remove_action( 'product_cat_add_form_fields', array( $cat_instance, 'add_category_fields' ) );
	remove_action( 'product_cat_edit_form_fields', array( $cat_instance, 'edit_category_fields' ), 10);
	remove_action( 'created_term', array( $cat_instance, 'save_category_fields' ), 10 );
	remove_action( 'edit_term', array( $cat_instance, 'save_category_fields' ), 10);

	// messages
	remove_action( 'product_cat_pre_add_form', array( $cat_instance, 'product_cat_description' ) );
	remove_action( 'after-product_cat-table', array( $cat_instance, 'product_cat_notes' ) );

}


/*=====  FIN Suppressions  =====*/

/*=============================
=            Liste            =
=============================*/

/*----------  Message d'aide  ----------*/

add_action( 'product_cat_pre_add_form', 'pc_woo_admin_product_cat_message' );

	function pc_woo_admin_product_cat_message() {

		echo '<p>Après avoir créer une catégorie, pour accéder à toutes ses propriétés (visuel, description,...), cliquez sur <em>Modifier</em> sous son nom dans le tableau. Pour changer l’ordre des catégories, glisser/déposer les lignes du tableau en cliquant sur l\'icône à la fin d\'une ligne.</p>';
		
	}


/*----------  Colonnes  ----------*/

add_filter( 'manage_edit-product_cat_columns', 'pc_woo_admin_product_cat_columns', 999 );

	function pc_woo_admin_product_cat_columns( $columns ) {

		unset( $columns['thumb'] );
		unset( $columns['description'] );

		return $columns;

	}


/*----------  Actions individuelles  ----------*/
	
add_filter( 'product_cat_row_actions', 'pc_woo_admin_product_cat_row_actions', 999, 2 );

	function pc_woo_admin_product_cat_row_actions($actions, $term) {

		unset( $actions['inline hide-if-no-js'] ); // modification rapide
		unset( $actions['make_default'] ); // Utiliser par défaut

		return $actions;
	}


/*=====  FIN Liste  =====*/

/*=======================================
=            Nouveaux champs            =
=======================================*/

if ( class_exists('PC_add_field_to_tax') ) {


	/*----------  Visuel  ----------*/

	$product_cat_image_fields_args = array(	
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

	$product_cat_image_fields = new PC_add_field_to_tax(
		'product_cat',
		$product_cat_image_fields_args
	);


	/*----------  Contenu  ----------*/
	
	$product_cat_content_fields_args = array(	
		'title'     => 'Contenu',
		'prefix'    => 'content',
		'fields'    => array(
			array(
				'type'      => 'wysiwyg',
				'id' 		=> 'desc',
				'label'     => 'Introduction',
				'options'	=> array(
					'media_buttons' => false,
					'tinymce' => array(
						'toolbar1' => 'undo,redo,removeformat,|,bullist,numlist,|,bold,italic,strikethrough,superscript,charmap,|,link,unlink'
					)
				)
			)					
		)
	);

	$product_cat_content_fields = new PC_add_field_to_tax(
		'product_cat',
		$product_cat_content_fields_args
	);


	/*----------  Affichage dans la page d'accueil  ----------*/
		
	$product_cat_home_fields_args = array(	
		'title'     => 'Page d\'accueil',
		'prefix'    => 'home',
		'fields'    => array(
			array(
				'type'      => 'checkbox',
				'id'        => 'active',
				'label'     => 'Afficher dans l\'accueil'
			)					
		)
	);
	
	$product_cat_home_fields = new PC_add_field_to_tax(
		'product_cat',
		$product_cat_home_fields_args
	);


	/*----------  Résumé  ----------*/

	$product_cat_card_fields_args = array(	
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

	$product_cat_card_fields = new PC_add_field_to_tax(
		'product_cat',
		$product_cat_card_fields_args
	);


	/*----------  SEO  ----------*/
	
	$product_cat_seo_fields_args = array(	
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

	$product_cat_seo_fields = new PC_add_field_to_tax(
		'product_cat',
		$product_cat_seo_fields_args
	);


} // FIN if class_exists('PC_add_field_to_tax')

/*=====  FIN Nouveaux champs  =====*/