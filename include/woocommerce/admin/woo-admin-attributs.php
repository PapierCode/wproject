<?php
/**
 * 
 * Woocommerce amdin : attributs
 * 
 ** Liste
 * 
 */

/*=============================
=            Liste            =
=============================*/

/*----------  Message d'aide  ----------*/

add_filter( 'gettext', 'pc_woo_admin_product_attr_message', 10, 3 );

	function pc_woo_admin_product_attr_message( $translation, $text, $domain ) {

		if ( is_admin() && $text == 'Attributes let you define extra product data, such as size or color. You can use these attributes in the shop sidebar using the "layered nav" widgets.' ) {
			$translation = 'Les attributs vous permettent de définir les variations d\'un produit, telles que la taille ou la couleur. Les attributs enregistrés dans cette page peuvent être communs à plusieurs produits.';
		}

		return $translation;

	}


/*----------  Colonnes  ----------*/

$admin_attributes_list = wc_get_attribute_taxonomies();

foreach ( $admin_attributes_list as $attribute ) {

	add_filter( 'manage_edit-pa_'.$attribute->attribute_name.'_columns', 'pc_woo_admin_product_attributes_columns', 999 );
	
}

	function pc_woo_admin_product_attributes_columns( $columns ) {

		unset( $columns['description'] );

		return $columns;

	}



/*=====  FIN Liste  =====*/