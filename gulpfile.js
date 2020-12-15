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

const { src, dest, watch, series } = require( 'gulp' ); // base

const sass          = require( 'gulp-sass' ); // scss to css
const postcss 		= require( 'gulp-postcss' ); // package
const cssnano 		= require( 'cssnano' ); // minification css
const autoprefixer 	= require( 'autoprefixer' ); // ajout des préfixes
const mqcombine 	= require( 'postcss-sort-media-queries' ); // factorisation des medias queries
const inlinesvg		= require( 'postcss-inline-svg' ); // svg to data:URI
const rename		= require( 'gulp-rename' ); // renommage fichier

// const jshint		= require( 'gulp-jshint' ); // recherche d'erreurs js
// const concat		= require( 'gulp-concat' ); // empile plusieurs fichiers js en un seul
// const terser		= require( 'gulp-terser' ); // minification js

    
/*=====  FIN Initialisation  ======*/

/*=================================
=            Tâche CSS            =
=================================*/

sass.compiler = require('sass');

// plugins CSS
var plugins = [
	inlinesvg(),
	autoprefixer({ grid: 'false', flexbox: 'false' }),
	mqcombine(),
	cssnano()
];


/*----------  Fonctions  ----------*/
	
function css() {
    
    return src( ['css/use.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
		.pipe(rename('project.css'))
        .pipe(dest( './' ));

}


/*=====  FIN Tâche CSS  ======*/

/*================================
=            Tâche JS            =
================================*/

// jshint_src = [
// 	'scripts/scripts.js'
// ],

// js_global_src = [].concat(jshint_src);


/*----------  Fonctions  ----------*/

// function js_hint() {

// 	return src( jshint_src )
//         .pipe(jshint())
//         .pipe(jshint.reporter( 'default' ));

// }

// function js() {

//     return src( js_global_src )
//         .pipe(concat( 'scripts.min.js' ))
//         .pipe(terser())
//         .pipe(dest( 'scripts/' ));

// }


/*=====  FIN Tâche JS  =====*/

/*==================================
=            Monitoring            =
==================================*/

exports.watch = function() {
	watch( 'css/**/*.scss', series(css) )
	// watch( ['scripts/**/*.js', '!scripts/scripts.min.js'], series(js_hint,js) )
};


/*=====  FIN Monitoring  ======*/