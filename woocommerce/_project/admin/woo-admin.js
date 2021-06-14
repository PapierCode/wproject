jQuery(document).ready(function($){

/*=============================
=            Admin            =
=============================*/

// produit variable
// pas de gestion de stock au niveau produit

var $product_type_select = $('#product-type'),
	$stock_checkbox = $('._manage_stock_field');

if ( 'variable' == $product_type_select.val() ) { $stock_checkbox.hide(); }

$product_type_select.change( function() {
	if( 'variable' == $(this).val() ) { $stock_checkbox.hide(); }
	else { $stock_checkbox.show();}
});


/*=====  FIN Admin  =====*/

});