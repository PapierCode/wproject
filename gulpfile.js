/**
*
* Gulp pour Papier Codé
*
** dépendance : package.json
** installation : commande "npm install"
*
**/


/*======================================
=            Initialisation            =
======================================*/

// Chargement des plugins

const { src, dest, watch, series }          = require( 'gulp' ); // base

const sass          = require( 'gulp-sass' ); // scss to css
const postcss 		= require( 'gulp-postcss' ); // package
const cssnano 		= require( 'cssnano' ); // minification css
const autoprefixer 	= require( 'autoprefixer' ); // ajout des préfixes
const mqpacker 		= require( 'css-mqpacker' ); // factorisation des medias queries
const inlinesvg		= require( 'postcss-inline-svg' ); // svg to data:URI
const banner		= require( 'gulp-banner' ); // commentaire css pour wordpress

    
/*=====  FIN Initialisation  ======*/

/*=================================
=            Tâche CSS            =
=================================*/

// plugins CSS
var plugins = [
	inlinesvg(),
	autoprefixer({ grid: 'false' }),
	mqpacker({ sort: true }),
	cssnano()
];

// commentaire WP
var theme_name 	    = 'WProject',
	theme_author 	= 'www.papier-code.fr'
	theme_desc 		= 'WPreform\'s child theme',
	wp_comment 		= '/* \nTheme Name: '+theme_name+'\nTemplate: wpreform \nAuthor: '+theme_author+' \nDescription: '+theme_desc+' \n*/\n\n';


/*----------  Fonctions  ----------*/
	
function css() {
    
    return src( ['css/style.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(banner( wp_comment ))
        .pipe(dest( './' ));

}


/*=====  FIN Tâche CSS  ======*/

/*==================================
=            Monitoring            =
==================================*/

exports.watch = function() {
	watch( 'css/**/*.scss', series(css) )
};


/*=====  FIN Monitoring  ======*/