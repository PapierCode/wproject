jQuery(document).ready(function($){

/*=================================
=            Variables            =
=================================*/

var $win 			= $(window),
	$html 			= $('html'),
	$header 		= $('.header'),
	$fs_img			= $('.fs-img'),
	$main_header 	= $('.main-header'),

	win_w, header_h, win_w_old = 0;




/*=====  FIN Variables  =====*/

/*==================================
=            Responsive            =
==================================*/

// fonction executée au chargement de la page et à chaque modification de largeur de la fenêtre
function win_resize() {

	/*----------  Fullscreen  ----------*/	

	if ( $html.hasClass('is-fullscreen') ) {

		win_w = $win.width();

		if ( win_w != win_w_old ) {

			win_h = $win.height();
			header_h = $header.outerHeight();

			$main_header.css( 'height', rem( win_h - header_h ) );
			$fs_img.css( 'height', rem( win_h ) );

			win_w_old = win_w;

		}

	}

} // fin winWidthChange()

win_resize();

$win.resize( win_resize );


/*=====  End of Responsive  ======*/


/*----------  Btn fullscreen  ----------*/

if ( $html.hasClass('is-fullscreen')) {

	var win_h;

	$('.js-button-fullscreen').click(function() {
		$('html, body').animate({ scrollTop:win_h }, 500);
	});

}

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


/*=======================================
=            Message cookies            =
=======================================*/

// cookie es-tu là ?
/* if (getCookie('cookies') === '') {

	// création du message
	$('body').prepend('<p class="cookies-msg is-hidden no-print">En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de <strong>cookies</strong>, <a href="'+cguUrl+'" title="Conditions générales d\'utilisation" class="cookies-msg-link" rel="nofollow">en savoir plus</a>. <button type="button" class="button cookies-msg-btn">J\'accepte</button></p>');

	var $cookiesMsg = $('.cookies-msg');

	// apparition du message
	$cookiesMsg.removeClass('is-hidden');

	// btn de validation des cookies
	$('.btn-alert-cookie').click(function() {

		// création du cookie, valable un an
		setCookie('cookies', 'accepted', 365);
		// disparition du message
		$cookiesMsg.addClass('is-hidden');
		// suppression du message
		setTimeout(function(){ $cookiesMsg.remove(); }, 500); // durée à reporter en css

	});

} */


/*=====  FIN Message cookies  ======*/

/*===========================
=            Map            =
===========================*/

if ( $html.hasClass('is-event') ) {

	var $eventMap = $('#event-map'),
	eventMap = L.map( 'event-map', { 
		center: L.latLng( $eventMap.data('lat'), $eventMap.data('lng') ),
		zoom: 14,
		minZoom : 10,
		maxZoom: 18,
		scrollWheelZoom : false,
		tap : false
	});

	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGFwaWVyY29kZSIsImEiOiJja203a3E5N3kweXplMnhuNjBuOTV2bmQ1In0.UtKowadsitAGdxDUpMv5aA', {
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(eventMap);

	var mapIcon = L.divIcon({
		iconSize: [40,60],
		iconAnchor: [20,60],
		className: 'map-marker'
	});
	var marker = L.marker([$eventMap.data('lat'), $eventMap.data('lng')], {icon: mapIcon}).addTo(eventMap);


}


/*=====  FIN Map  =====*/

});

