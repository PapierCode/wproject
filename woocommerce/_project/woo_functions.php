<?php 

/*====================================================
=            Résumé : catégorie & produit            =
====================================================*/

/*----------  Article  ----------*/

function pc_woo_display_article_tag_start() {

	echo '<article>';

}

function pc_woo_display_article_tag_end() {

	echo '</article>';

}


/*=====  FIN Résumé : catégorie & produit  =====*/

/*===================================
=            Fil d'arian            =
===================================*/

function pc_woo_display_breadcrumb() {
	
	woocommerce_breadcrumb(
		array(
			'delimiter'   => '',
			'wrap_before' => '<nav class="breadcrumb"><ol class="breadcrumb-list reset-list">',
			'wrap_after'  => '</ol></nav>',
			'before'      => '<li class="breadcrumb-item">',
			'after'       => '</li>'
		)
	);

}


/*=====  FIN Fil d'arian  =====*/