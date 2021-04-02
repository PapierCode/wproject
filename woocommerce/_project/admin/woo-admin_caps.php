<?php
/**
 * 
 * Woocommerce : droits des éditeurs
 * 
 */


// plus de cap ?
// wp_get_current_user();
// pc_var($current_user,true);

add_action( 'admin_init', 'pc_woo_editor_caps');

function pc_woo_editor_caps() {

	$editor = get_role( 'editor' );

	// produits
	$editor->add_cap('edit_product' );
	$editor->add_cap('read_product' );
	$editor->add_cap('delete_product' );
	$editor->add_cap('edit_products' );
	$editor->add_cap('edit_others_products' );
	$editor->add_cap('publish_products' );
	$editor->add_cap('read_private_products' );
	$editor->add_cap('delete_products' );
	$editor->add_cap('delete_private_products' );
	$editor->add_cap('delete_published_products' );
	$editor->add_cap('delete_others_products' );
	$editor->add_cap('edit_private_products' );
	$editor->add_cap('edit_published_products' );

	// catégories
	$editor->add_cap('manage_product_terms');
	$editor->add_cap('edit_product_terms');
	$editor->add_cap('delete_product_terms');
	$editor->add_cap('assign_product_terms');

	// commandes
	$editor->add_cap('edit_shop_orders');
	$editor->add_cap('edit_others_shop_orders');
	$editor->add_cap('publish_shop_orders');
	$editor->add_cap('read_private_shop_orders');
	$editor->add_cap('delete_shop_orders');
	$editor->add_cap('delete_private_shop_orders');
	$editor->add_cap('delete_published_shop_orders');
	$editor->add_cap('delete_others_shop_orders');
	$editor->add_cap('edit_private_shop_orders');
	$editor->add_cap('edit_published_shop_orders');

}
