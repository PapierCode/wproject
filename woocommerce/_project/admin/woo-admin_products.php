<?php
/**
 * 
 * Woocommerce admin : produits
 * 
 ** Type de produits désactivés
 ** Liste des produits
 ** Données produit Woo
 ** Métaboxes Wpréform
 * 
 */

/*===================================================
=            Type de produits désactivés            =
===================================================*/

add_filter( 'product_type_selector', 'pc_woo_admin_product_type_selector' );

	function pc_woo_admin_product_type_selector( $types )  {

		unset( $types['grouped'] );
		unset( $types['external'] );
		//unset( $types['variable'] );
		
		return $types;

	}


/*=====  FIN Type de produits désactivés  =====*/

/*==========================================
=            Liste des produits            =
==========================================*/

/*----------  Filtre par type  ----------*/

add_filter( 'woocommerce_products_admin_list_table_filters', 'pc_woo_admin_type_selector_sub' );

	function pc_woo_admin_type_selector_sub( $filters ) {
 
		if( isset( $filters[ 'product_type' ] ) ) {
			$filters[ 'product_type' ] = 'pc_woo_admin_product_type_selector_sub_callback';
		}

		return $filters;
	 
	}
	 
	function pc_woo_admin_product_type_selector_sub_callback(){

		$current_product_type = isset( $_REQUEST['product_type'] ) ? wc_clean( wp_unslash( $_REQUEST['product_type'] ) ) : false;
		$output = '<select name="product_type" id="dropdown_product_type"><option value="">'.esc_html__( 'Filter by product type', 'woocommerce' ).'</option>';
	 
		foreach ( wc_get_product_types() as $value => $label ) {
			$output .= '<option value="' . esc_attr( $value ) . '" ';
			$output .= selected( $value, $current_product_type, false );
			$output .= '>' . esc_html( $label ) . '</option>';
		}
	 
		$output .= '</select>';
		echo $output;

	}


/*----------  Colonnes  ----------*/

add_filter( 'manage_product_posts_columns', 'pc_woo_admin_product_list_columns', 999 );

	function pc_woo_admin_product_list_columns( $columns ) {
		
		unset($columns['product_tag']); // étiquettes
		unset($columns['featured']); // étoile

		$columns['thumb'] = 'Visuel'; // renomme

		return $columns;

	};


/*=====  FIN Liste des produits  =====*/

/*===========================================
=            Données produit Woo            =
===========================================*/

/*----------  Métaboxes désactivées  ----------*/

add_action( 'add_meta_boxes', 'pc_woo_admin_product_remove_metaboxes', 999 );

	function pc_woo_admin_product_remove_metaboxes() {	

		remove_meta_box( 'postcustom', 'product', 'normal' ); // champs personnalisés
		remove_meta_box( 'slugdiv', 'product', 'normal' ); // slug
		remove_meta_box( 'postexcerpt', 'product', 'normal' ); // description

	}


/*----------  Suppression options virtuel et téléchargeable  ----------*/

add_filter( 'product_type_options', 'pc_woo_admin_product_type_options' );

	function pc_woo_admin_product_type_options( $options )  {

		unset( $options['virtual'] );
		unset( $options['downloadable'] );
		
		return $options;

	}


/*----------  Onglets  ----------*/

add_filter( 'woocommerce_product_data_tabs', 'pc_woo_admin_data_tabs' );

	function pc_woo_admin_data_tabs( $tabs ) {

		unset( $tabs['advanced'] ); // avancé
		// produits liés unset( $tabs['linked_product'] ); 

		// Général devient Tarifs
		$tabs['general']['label'] = 'Tarifs';
		$tabs['shipping']['label'] = 'Propriétés';

		// Attributs masqué pour les produits simples
		$tabs['attribute']['class'][] = 'hide_if_simple';

		return $tabs;

	}
	

/*----------  Suppression des champs dimensions  ----------*/

// add_filter( 'wc_product_dimensions_enabled', '__return_false' );


/*=====  FIN Données produit Woo  =====*/

/*==========================================
=            Métaboxes Wpréform            =
==========================================*/

/*----------  WPreform, Résumé & SEO  ----------*/

add_filter( 'pc_filter_metabox_card_for', 'pc_woo_product_metabox_wpreform' );
add_filter( 'pc_filter_metabox_seo_for', 'pc_woo_product_metabox_wpreform' );

	function pc_woo_product_metabox_wpreform( $metabox_img_for ) {

		$metabox_img_for[] = 'product';
		return $metabox_img_for;

	}


/*=====  FIN Métaboxes Wpréform  =====*/