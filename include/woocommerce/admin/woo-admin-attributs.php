<?php

/*----------  Nouveaux messages  ----------*/

add_filter( 'gettext', 'pc_woo_admin_product_attr_message', 10, 3 );

	function pc_woo_admin_product_attr_message( $translation, $text, $domain ) {

		if ( is_admin() && $text == 'Attributes let you define extra product data, such as size or color. You can use these attributes in the shop sidebar using the "layered nav" widgets.' ) {
			$translation = 'Les attributs vous permettent de définir les variations d\'un produit, telles que la taille ou la couleur. Les attributs enregistrés dans cette page peuvent être communs à plusieurs produits.';
		}

		return $translation;

	}