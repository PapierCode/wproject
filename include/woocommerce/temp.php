<?php 

/*----------  Si une seule variante  ----------*/

// affiche le prix (doublon)
//add_filter( 'woocommerce_show_variation_price', function() { return TRUE; } );



/*----------  Select variations, affichage disponibilité  ----------*/

// add_filter( 'woocommerce_variation_option_name', 'pc_woo_product_variation_edit_select_text', 10, 4 );

// 	function pc_woo_product_variation_edit_select_text( $name, $term, $attribute, $product ) {

// 		if ( is_product() || is_product_category() ) {

// 			global $msg_out_of_stock, $msg_on_backorder;

// 			$search = ( is_object($term) ) ? $term->slug : $name;

// 			foreach ( $product->get_available_variations() as $variation ) {

// 				if ( $variation['attributes']['attribute_'.$attribute] == $search ){
					
// 					$variation_obj = wc_get_product( $variation['variation_id'] );

// 					if ( ! $variation_obj->is_in_stock() ) {

// 						$name = $name.' ('.$msg_out_of_stock.')';

// 					} else if ( $variation_obj->is_on_backorder() ) {

// 						$name = $name.' ('.$msg_on_backorder.')';

// 					}

// 					break;
// 				}
				
// 			}

// 		}

// 		return $name;

// 	}


/*----------  Select variations, sans stock non sélectionnable  ----------*/

// add_filter( 'woocommerce_variation_is_active', 'pc_woo_product_variation_option_no_stock_disabled', 10, 2 );

// 	function pc_woo_product_variation_option_no_stock_disabled( $active, $variation ) {
		
// 		if ( !$variation->is_in_stock() ) { return false; }
		
// 		return $active;

// 	}
	

// add_filter( 'wc_product_weight_enabled', '__return_false' );



/*----------  "À partir de"  ----------*/

add_filter( 'woocommerce_variable_price_html', 'pc_woo_variation_price_format', 10, 2 );

	function pc_woo_variation_price_format( $price, $product ) {

		$min_price = $product->get_variation_price( 'min', true );
		$max_price = $product->get_variation_price( 'max', true );

		if ( $min_price != $max_price ) {

			return '<span class="price-from">À partir de</span> '.wc_price( $min_price );

		} else {

			return wc_price( $min_price );

		}

	}