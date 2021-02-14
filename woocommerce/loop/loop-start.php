<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
