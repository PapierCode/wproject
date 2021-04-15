<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* [PC] <ul class="products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>"> */

$css_class = 'st-list reset-list';

if ( is_shop() ) {

	$css_class .= ' st-list--categories';

} else if ( is_product_category() ) {

	$term = get_queried_object(); // catégorie courante (object)
	$terms_childrens = get_term_children( $term->term_id, 'product_cat' ); // enfants de la catégorie courante (array)

	if ( count( $terms_childrens ) > 0 ) {

		$css_class .= ' st-list--categories';

	} else {

		$css_class .= ' st-list--products';
	
	}

}

echo '<ul class="'.$css_class.'">';
