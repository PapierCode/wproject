<?php
/**
 * 
 * Custom post xxx : résumé
 * 
 */


/*===============================
=            Archive            =
===============================*/

/*----------  Données structurées  ----------*/

add_filter ( 'pc_filter_page_schema_article_display', 'pc_xxx_page_schema_article_display', 10, 2 ); 

	function pc_xxx_page_schema_article_display( $display, $pc_post ) {

		$metas = $pc_post->metas;

		if ( isset( $metas['content-from'] ) && $metas['content-from'] == XXX_POST_SLUG ) {

			return false;

		} else { return true; }

	}


/*=====  FIN Archive  =====*/