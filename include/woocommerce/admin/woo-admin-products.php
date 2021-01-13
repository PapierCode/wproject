<?php

/*==========================================
=            Liste des produits            =
==========================================*/

/*----------  Vues  ----------*/

add_filter( 'views_edit-product', 'pc_woo_admin_product_view', 99 );

function pc_woo_admin_product_view( $views ) {

	unset($views['byorder']); // tri manuel

	return $views;

}


/*----------  Filtres  ----------*/

add_filter( 'product_type_selector', 'pc_woo_admin_product_type_selector' );

	function pc_woo_admin_product_type_selector( $types )  {

		unset( $types['grouped'] );
		unset( $types['external'] );
		
		return $types;

	}

// supprime les options "Virtuel" et "Téléchargeable"
add_filter( 'woocommerce_products_admin_list_table_filters', 'pc_woo_admin_type_selector_sub' );

	function pc_woo_admin_type_selector_sub( $filters ) {
 
		if( isset( $filters[ 'product_type' ] ) ) {
			$filters[ 'product_type' ] = 'pc_woo_admin_product_type_callback';
		}

		return $filters;
	 
	}
	 
	function pc_woo_admin_product_type_callback(){

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

/*===============================
=            Produit            =
===============================*/

/*----------  Métaboxes  ----------*/

add_action( 'add_meta_boxes', 'pc_woo_admin_product_remove_metaboxes', 999 );

	function pc_woo_admin_product_remove_metaboxes() {

		remove_meta_box( 'woocommerce-product-images','product','side' ); // galerie
		remove_meta_box( 'postcustom', 'product', 'normal' ); // champs personnalisés
		remove_meta_box( 'slugdiv', 'product', 'normal' ); // slug
		remove_meta_box( 'postexcerpt', 'product', 'normal' ); // description

	}


/*----------  Variante de produit simple  ----------*/

add_filter( 'product_type_options', 'pc_woo_admin_product_type_options' );

	function pc_woo_admin_product_type_options( $options )  {

		unset( $options['virtual'] );
		unset( $options['downloadable'] );
		
		return $options;

	}


/*----------  Onglets propriétés  ----------*/

add_filter( 'woocommerce_product_data_tabs', 'pc_woo_admin_data_tabs' );

	function pc_woo_admin_data_tabs( $tabs ) {

		unset( $tabs['shipping'] ); // livraison
		unset( $tabs['advanced'] ); // avancé
		unset( $tabs['linked_product'] ); // produits liés

		$tabs['attribute']['class'][] = 'hide_if_simple';

		return $tabs;

	}
	

add_filter( 'wc_product_weight_enabled', '__return_false' );
add_filter( 'wc_product_dimensions_enabled', '__return_false' );


/*=====  FIN Produit  =====*/