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
const mqcombine 	= require( 'postcss-sort-media-queries' ); // factorisation des medias queries
const inlinesvg		= require( 'postcss-inline-svg' ); // svg to data:URI
const rename		= require( 'gulp-rename' ); // renommage fichier

    
/*=====  FIN Initialisation  ======*/

/*=================================
=            Tâche CSS            =
=================================*/

sass.compiler = require('sass');

// plugins CSS
var plugins = [
	inlinesvg(),
	autoprefixer({ grid: 'false' }),
	mqcombine(),
	cssnano()
];


/*----------  Fonctions  ----------*/
	
function css_classic() {
    
    return src( ['css/use_classic.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
		.pipe(rename('classic.css'))
        .pipe(dest( './' ));

}

function css_fullscreen() {
    
    return src( ['css/use_fullscreen.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
		.pipe(rename('fullscreen.css'))
        .pipe(dest( './' ));

}



/*=====  FIN Tâche CSS  ======*/

/*==================================
=            Monitoring            =
==================================*/

exports.watch = function() {
	watch( 'css/**/*.scss', series(css_classic,css_fullscreen) )
};


/*=====  FIN Monitoring  ======*/