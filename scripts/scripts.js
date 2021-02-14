jQuery(document).ready(function($){

var $html = $('html');


/*----------  fake post resum  ----------*/

var $st_list = $('.st-list');

if ( $st_list.length > 0 ) {

	var $st_items = $st_list.find('.st'),
	$st_items_fake = 0;

	switch ( $st_items.length ) {
		case 1 :
		case 4 :
			$st_items_fake = 2;
			break;
		case 2 :
		case 3 :
		case 5 :
			$st_items_fake = 1;
			break;
	}

	if ( $html.hasClass('is-home') && $st_items.length == 4 ) { $st_items_fake = 0; }

	for ( i = 0; i < $st_items_fake; i++) {
		
		var tag = $st_items.eq(0).prop('tagName').toLowerCase();

		$st_list.append('<'+tag+' class="st--fake '+$st_items.eq(0).attr('class')+'" aria-hidden="true"></'+tag+'>');

	}

}


});

