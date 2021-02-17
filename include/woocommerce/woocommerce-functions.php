<?php 

/*====================================================
=            Résumé : catégorie & produit            =
====================================================*/

/*----------  Article  ----------*/

function pc_woo_article_tag_start() {

	echo '<article>';

}

function pc_woo_article_tag_end() {

	echo '</article>';

}


/*---------- Lien  ----------*/

function pc_woo_resum_get_link_tag_start( $type, $class, $href, $title ) {

	switch ( $type ) {
		case 'category':
			$title = 'Voir les produits de la catégorie '.$title;
			break;
		case 'product':
			$title = 'En savoir plus sur le produit '.$title;
			break;
	}

	return '<a href="'.$href.'" class="'.$class.'" title="'.$title.'">';

}


/*=====  FIN Résumé : catégorie & produit  =====*/