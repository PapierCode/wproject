<?php

/*----------  Pas de hiérarchie par défaut  ----------*/

add_filter( 'woocommerce_taxonomy_args_product_cat', 'pc_woo_admin_product_cat_register_args' );

	function pc_woo_admin_product_cat_register_args( $args ) {

		$args['hierarchical'] = false;

		return $args;

	}


/*----------  Liste des catégories  ----------*/

// colonnes
add_filter( 'manage_edit-product_cat_columns', 'pc_woo_admin_product_cat_columns', 999 );

	function pc_woo_admin_product_cat_columns( $columns ) {

		unset( $columns['thumb'] );
		unset( $columns['description'] );

		return $columns;

	}

// actions	
add_filter( 'product_cat_row_actions', 'pc_woo_admin_product_cat_row_actions', 999, 2 );

	function pc_woo_admin_product_cat_row_actions($actions, $term) {

		unset( $actions['inline hide-if-no-js'] );
		unset( $actions['make_default'] );

		return $actions;
	}


/*----------  Suppression des Champs & messages par défaut  ----------*/
	
add_action( 'admin_init', 'pc_woo_admin_product_cat_remove_default_fields' );

function pc_woo_admin_product_cat_remove_default_fields() {

	$cat_instance = WC_Admin_Taxonomies::get_instance();
	
	remove_action( 'product_cat_add_form_fields', array( $cat_instance, 'add_category_fields' ) );
	remove_action( 'product_cat_edit_form_fields', array( $cat_instance, 'edit_category_fields' ), 10);
	remove_action( 'created_term', array( $cat_instance, 'save_category_fields' ), 10 );
	remove_action( 'edit_term', array( $cat_instance, 'save_category_fields' ), 10);

	// messages
	remove_action( 'product_cat_pre_add_form', array( $cat_instance, 'product_cat_description' ) );
	remove_action( 'after-product_cat-table', array( $cat_instance, 'product_cat_notes' ) );

}


/*----------  Nouveaux Messages  ----------*/

add_action( 'product_cat_pre_add_form', 'pc_woo_admin_product_cat_message' );

	function pc_woo_admin_product_cat_message() {

		echo '<p>Après avoir créer une catégorie, pour accéder à toutes ses propriétés (visuel, description,...), cliquez sur <em>Modifier</em> sous son nom dans le tableau. Pour changer l’ordre des catégories, glisser/déposer les lignes du tableau en cliquant sur l\'icône à la fin d\'une ligne.</p>';
		
	}
	

/*----------  Nouveaux champs  ----------*/

if ( class_exists('PC_add_field_to_tax') ) {

	$product_cat_content_fields_args = array(	
		'title'     => 'Contenu',
		'prefix'    => 'content',
		'fields'    => array(
			array(
				'type'      => 'img',
				'id'        => 'visual',
				'label'     => 'Visuel',
				'options'   => array(
					'btnremove' => true
				)
			),
			array(
				'type'      => 'wysiwyg',
				'id' 		=> 'desc',
				'label'     => 'Description',
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

	$product_cat_seo_fields_args = array(	
		'title'     => 'Référencement (SEO) & réseaux sociaux',
		'prefix'    => 'seo',
		'desc'      => '<p><strong>Optimisez le titre et le résumé pour les moteurs de recherche et les réseaux sociaux.</strong> <br/><em>Si ces champs ne sont pas saisis, le titre de la catégorie et les premiers mots de la description sont utilisés.</em><br/><em>Si la description n\'est pas saisie, la description par défaut est utilisée (cf. Paramètres).</em></p>',
		'fields'    => array(
			array(
				'type'      => 'text',
				'id'        => 'title',
				'label'     => 'Titre',
                'attr'      => 'class="pc-counter" data-counter-max="70"',
				'css'		=> 'width:100%'
			),			
			array(
				'type'      => 'textarea',
				'id'        => 'desc',
				'label'     => 'Description',
                'attr'      => 'class="pc-counter" data-counter-max="200"',
				'css'		=> 'width:100%'
			)					
		)
	);

	$product_cat_seo_fields = new PC_add_field_to_tax(
		'product_cat',
		$product_cat_seo_fields_args
	);


}