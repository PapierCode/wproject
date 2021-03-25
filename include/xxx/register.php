<?php
/**
*
* Custom post xxx
*
** Post
** Taxonomy
*
**/


if ( class_exists( 'PC_Add_Custom_Post' )) {

	/*============================
	=            Post            =
	============================*/

	/*----------  Labels  ----------*/

	$xxx__post_labels = array (
		'name'                  => 'xxx',
		'singular_name'         => 'xxx',
		'menu_name'             => 'xxx',
		'add_new'               => 'Ajouter un xxx',
		'add_new_item'          => 'Ajouter un xxx',
		'new_item'              => 'Ajouter un xxx',
		'edit_item'             => 'Modifier le xxx',
		'all_items'             => 'Tous les xxx',
		'not_found'             => 'Aucun xxx'
	);


	/*----------  Configuration  ----------*/

	$xxx__post_args = array(
		'menu_position'     => 28,
		'menu_icon'         => 'dashicons-xxx',
		'show_in_nav_menus' => false,
		'supports'          => array( 'title', 'editor' ),
		'rewrite'			=> array( 'slug' => 'xxx'),
		'has_archive'		=> false
	);


	/*----------  Déclaration  ----------*/

	$xxx__post_declaration = new PC_Add_Custom_Post( XXX_POST_SLUG, $xxx__post_labels, $xxx__post_args );
	
	
	/*=====  FIN Post  =====*/

	/*================================
	=            Taxonomy            =
	================================*/

	/*----------  Labels  ----------*/

	$xxx_tax_labels = array(
		'name'                          => 'Catégories',
		'singular_name'                 => 'Catégories',
		'menu_name'                     => 'Catégories',
		'all_items'                     => 'Toutes les catégoriess',
		'edit_item'                     => 'Modifier la catégorie',
		'view_item'                     => 'Voir la catégorie',
		'update_item'                   => 'Mettre à jour la catégorie',
		'add_new_item'                  => 'Ajouter une catégorie',
		'new_item_name'                 => 'Ajouter une catégorie',
		'search_items'                  => 'Rechercher une catégorie',
		'popular_items'                 => 'Catégories les plus utilisées',
		'separate_items_with_commas'    => 'Séparer les catégories avec une virgule',
		'add_or_remove_items'           => 'Ajouter/supprimer une catégorie',
		'choose_from_most_used'         => 'Choisir parmis les plus utilisées',
		'not_found'                     => 'Aucune catégorie définie'
	);

	/*----------  Paramètres  ----------*/

	// vide = paramètres par défaut
	$xxx_tax_args = array(
		'rewrite'   => array( 'slug' => 'xxx' ),
		'show_in_nav_menus' => false,
		'hierarchical' => false
	);


	/*----------  Déclaration  ----------*/

	$xxx__post_declaration->add_custom_tax(
		XXX_TAX_SLUG,
		$xxx_tax_labels,
		$xxx_tax_args
	);


	/*=====  FIN Taxonomy  ======*/

} // FIN if class_exists(PC_Add_Custom_Post)
