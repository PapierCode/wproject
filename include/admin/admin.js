/*=====================================
=            Blocks Editor            =
=====================================*/

( function() {

    wp.domReady( function() {

		wp.data.dispatch( "core/editor" ).updateEditorSettings({
			autosaveInterval: 99999
		});
      
		/*----------  Page sidebar  ----------*/
		
        wp.data.dispatch( 'core/edit-post').removeEditorPanel( 'page-attributes' );
        wp.data.dispatch( 'core/edit-post').removeEditorPanel( 'page-templates' );


		/*----------  Style de blocs  ----------*/
		
	    wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
	    wp.blocks.unregisterBlockStyle( 'core/button', 'fill' );
		wp.blocks.unregisterBlockStyle( 'core/quote', 'large');
		wp.blocks.unregisterBlockStyle( 'core/quote', 'plain');
		wp.blocks.unregisterBlockStyle( 'core/quote', 'default');
		wp.blocks.unregisterBlockStyle( 'core/image', 'default');
		wp.blocks.unregisterBlockStyle( 'core/image', 'rounded');


			
		wp.blocks.unregisterBlockVariation( 'core/columns', 'one-column-full' );
		wp.blocks.unregisterBlockVariation( 'core/columns', 'three-columns-wider-center' );


		/*----------  Options de texte  ----------*/

		wp.richText.unregisterFormatType( 'core/image' );
		wp.richText.unregisterFormatType( 'core/code' );
		wp.richText.unregisterFormatType( 'core/keyboard' );
		wp.richText.unregisterFormatType( 'core/text-color' );

   
    });

	function removeAlignOptions( settings, name ) {

		if ( name == 'core/heading' ) {
			return lodash.assign( {}, settings, {
				supports: lodash.assign( {}, settings.supports, {
					align: [ 'wide' ],
				} )
			} );
		}
		// if ( name == 'core/column' ) {
			
		// 	console.log(settings);
		// 	return lodash.assign( {}, settings, {
		// 		attributes: lodash.assign( {}, settings.attributes, {
		// 			width: false,
		// 		} )
		// 	} );
		// }
	 
		return settings;
	}
	 
	wp.hooks.addFilter(
		'blocks.registerBlockType',
		'pc/removealignoptions',
		removeAlignOptions
	);

} )()


/*=====  FIN Blocks Editor  =====*/

