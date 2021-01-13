<?php

/*----------  Suppressions métaboxes  ----------*/

add_action( 'add_meta_boxes', 'pc_woo_admin_order_remove_metaboxes', 999 );

	function pc_woo_admin_order_remove_metaboxes() {

		remove_meta_box( 'postcustom', 'shop_order', 'normal' ); // champs personnalisés
		remove_meta_box( 'woocommerce-order-downloads', 'shop_order', 'normal' ); // champs personnalisés

	}