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

const browsersync 	= require('browser-sync').create();

const sass          = require( 'gulp-sass' )(require('sass')); // scss to css
const postcss 		= require( 'gulp-postcss' ); // package
const cssnano 		= require( 'cssnano' ); // minification css
const autoprefixer 	= require( 'autoprefixer' ); // ajout des préfixes
const mqcombine 	= require( 'postcss-sort-media-queries' ); // factorisation des medias queries
const inlinesvg		= require( 'postcss-inline-svg' ); // svg to data:URI
const rename		= require( 'gulp-rename' ); // renommage fichier

const jshint		= require( 'gulp-jshint' ); // recherche d'erreurs js
const concat		= require( 'gulp-concat' ); // empile plusieurs fichiers js en un seul
const terser		= require( 'gulp-terser' ); // minification js  


/*=====  FIN Initialisation  ======*/

/*=================================
=            Tâche CSS            =
=================================*/

sass.compiler = require('sass');

var postCssPlugins = [
	inlinesvg(),
	autoprefixer({ grid: 'false', flexbox: 'false' }),
	mqcombine(),
	cssnano({ preset: ['default', { calc: false }] })
];


/*----------  Fonctions  ----------*/
	
function cssScreen() {
    
    return src( ['css/sass_front/use.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( postCssPlugins ))
		.pipe(rename('front.css'))
        .pipe(dest( './css/' ));

}
	
function cssAdmin() {
    
    return src( ['css/sass_admin/use.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( postCssPlugins ))
		.pipe(rename('admin.css'))
        .pipe(dest( './css/' ));

}


/*=====  FIN Tâche CSS  ======*/

/*================================
=            Tâche JS            =
================================*/

var js_src = [
	'scripts/include/woocommerce.js',
	'scripts/pc-project.js'
];

function jsHint() {

	return src( js_src )
        .pipe(jshint())
        .pipe(jshint.reporter( 'default' ));

}

function js() {

    return src( js_src )
        .pipe(concat( 'pc-project.min.js' ))
        .pipe(terser())
        .pipe(dest( 'scripts/' ));

}


/*=====  FIN Tâche JS  =====*/

/*==================================
=            Monitoring            =
==================================*/

function browserSyncReload( cb ) {
	browsersync.reload();
	cb();
}

exports.watch = function() {

	browsersync.init({
        proxy: 'dev.preform.papier-code.fr',
		notify: false,
		open: false
    });

	watch( 'css/sass/**/*.scss', series( cssScreen, cssAdmin, browserSyncReload ) )
	watch( 'css/sass_front/**/*.scss', series( cssScreen, browserSyncReload ) )
	watch( 'css/sass_admin/**/*.scss', series( cssAdmin, browserSyncReload ) )
	watch( '**/**.php', series( browserSyncReload ) )
	watch( ['scripts/**/*.js','!scripts/pc-project.min.js'], series( jsHint, js, browserSyncReload ) )

};


/*=====  FIN Monitoring  ======*/