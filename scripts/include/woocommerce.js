jQuery(document).ready(function($){

/*========================================
=            Galerie d'images            =
========================================*/

$('.woocommerce-product-gallery--with-images').gallery({
	btnNextInner:sprite.arrow,
	btnPrevInner:sprite.arrow,
	btnCloseInner:sprite.cross,
	moveDuration:500,
	responsiveImg:true
});


/*=====  FIN Galerie d'images  =====*/

/*==============================
=            Panier            =
==============================*/

var $cart = $('.cart'); // add to cart, cart table,...

if ( $cart.length > 0 ) {

	// c'est ça ou 2 templates à modifier...
	$('.single_add_to_cart_button').attr('title', 'Ajouter au panier');
	// reset select variation
	$('.variations_form select').prop('selectedIndex',0);
		
	
	/*----------  Quantité  ----------*/
	
	var pc_enable_btn_update_cart = function( ) {
		
		$btnCartUpdate = $cart.find('button[name=update_cart]');
		$btnCartUpdate.prop('disabled',false);
	
	};
	
	var pc_custom_quantity = function() {
	
		var $quantity = $('.quantity');
	
		$quantity.each(function() {
	
			if ( !$(this).parent().is('td') ) {
				$quantity.find('input').val('1');			
			}
	
			var $qtyInput = $(this).find('input');
	
			if ( $qtyInput.prop('type') == 'number' ) { // sinon hidden
	
				$qtyInput.attr('tabindex','-1');
	
				var qtyMax = ( Number($qtyInput.attr('max')) > 0 ) ? Number($qtyInput.attr('max')) : 999,
				qtyMin = Number($qtyInput.attr('min')),
				qtyStep = Number($qtyInput.attr('step'));	
	
				$qtyInput.parent().before('<div class="pc-qty" aria-hidden="true"><button class="reset-btn pc-qty-btn pc-qty-btn--less button no-print" type="button" title="Supprimer une unité">-</button><div class="pc-qty-counter">'+$qtyInput.val()+'</div><button class="reset-btn pc-qty-btn pc-qty-btn--more button no-print" type="button" title="Ajouter une unité">+</button></div>');
				
				var $qtyCounter = $(this).prev().find('.pc-qty-counter'),
				$qtyBtnLess = $(this).prev().find('.pc-qty-btn--less'),
				$qtyBtnMore = $(this).prev().find('.pc-qty-btn--more');
	
				if ( Number($qtyInput.val()) == 1 ) {
					$qtyBtnLess.prop('disabled',true);
				}
				if ( Number($qtyInput.val()) == qtyMax ) {
					$qtyBtnMore.prop('disabled',true);
				}
	
				$qtyBtnMore.click(function() {
	
					$(this).blur();
	
					var qtyNew = Number($qtyInput.val()) + qtyStep;
	
					if ( qtyNew <= qtyMax ) {
						$qtyCounter.text(qtyNew);
						$qtyInput.val(qtyNew);
						pc_enable_btn_update_cart();
					}
					if ( qtyNew > qtyMin ) {
						$qtyBtnLess.prop('disabled',false);
					}
					if ( qtyNew == qtyMax ) {
						$(this).prop('disabled',true);
					}
				});
	
				$qtyBtnLess.click(function() {
	
					$(this).blur();
	
					var qtyNew = Number($qtyInput.val()) - qtyStep;
	
					if ( qtyNew >= qtyMin ) {
						$qtyCounter.text(qtyNew);
						$qtyInput.val(qtyNew);
						pc_enable_btn_update_cart();
					}
					if ( qtyNew < qtyMax ) {
						$qtyBtnMore.prop('disabled',false);
					}
					if ( qtyNew == qtyMin ) {
						$(this).prop('disabled',true);
					}
				});
	
			} // FIN if $qtyInput.prop('type')
	
		}); // FIN each $quantity
	
	};
	
	pc_custom_quantity();
	
	// mise à jour panier par ajax
	$( document.body ).on( 'updated_cart_totals', function(){
		$cart = $('.cart');
		if ( $('.pc-qty').length < 1 ) {
			pc_custom_quantity();
		}	
	} );
	
	
} // FIN if $cart.length


/*=====  FIN Panier  =====*/

}); // FIN jquery ready