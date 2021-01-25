jQuery(document).ready(function($){

	var $win 			= $(window),
		$html 			= $('html'),
		$header 		= $('.header'),
		$fs_img			= $('.fs-img'),
		$main_header 	= $('.main-header'),
		
		win_h, win_w, header_h, win_w_old = 0;

	function win_change_fullscreen() {
		
		if ( $html.hasClass('is-fullscreen') ) {
	
			win_h = $win.height();
			win_w = $win.width();
			header_h = $header.outerHeight();
	
			if ( win_w != win_w_old ) {
				$main_header.css( 'height', rem( win_h - header_h ) );
				$fs_img.css( 'height', rem( win_h ) );
				win_w_old = win_w;
			}
	
		}
		
	
	
	} 

	win_change_fullscreen();
	$win.resize( win_change_fullscreen );
	
	if ( $html.hasClass('th-f')) {

		$('.fs-more-btn').click(function() {
			$('html, body').animate({ scrollTop:win_h }, 500);
		});

	}

});