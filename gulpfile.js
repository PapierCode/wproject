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
	
function css() {
    
    return src( ['css/style.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(dest( './' ));

}

function classic_css() {
    
    return src( ['css/v-classic.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(dest( './' ));

}

function fullscreen_css() {
    
    return src( ['css/v-fullscreen.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(dest( './' ));

}



/*=====  FIN Tâche CSS  ======*/

/*==================================
=            Monitoring            =
==================================*/

exports.watch = function() {
	watch( 'css/**/*.scss', series(css,classic_css,fullscreen_css) )
};


/*=====  FIN Monitoring  ======*/