document.addEventListener( 'DOMContentLoaded', () => {

const html = document.querySelector( 'html' );

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

/*===================================
=            Content Map            =
===================================*/

if ( html.classList.contains( 'has-map' ) ) {

	const singleMapBox = document.querySelector( '#main-map' );
	const singleMap = L.map( 'main-map', { 
		center: L.latLng( singleMapBox.dataset.lat, singleMapBox.dataset.lng ),
		zoom: 14,
		minZoom : 10,
		maxZoom: 18,
		scrollWheelZoom : false,
		tap : false
	});

	L.tileLayer( 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGFwaWVyY29kZSIsImEiOiJja203a3E5N3kweXplMnhuNjBuOTV2bmQ1In0.UtKowadsitAGdxDUpMv5aA', {
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	} ).addTo( singleMap );

	const mapIcon = L.divIcon( {
		iconSize: [40,60],
		iconAnchor: [20,60],
		className: 'map-marker'
	} );
	const marker = L.marker( [singleMapBox.dataset.lat, singleMapBox.dataset.lng], {icon: mapIcon} ).addTo( singleMap );


}


/*=====  FIN Content Map  =====*/

});

