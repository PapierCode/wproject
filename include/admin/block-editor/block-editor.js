( function() {

    wp.domReady( function() {

        /*=========================================
        =            Blocs disponibles            =
        =========================================*/

        var allowed_core_blocks = [
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/quote',
            'core/buttons',
            'core/button',            
            'core/separator',
            'core/spacer',
            'core/columns',
            'core/column',
            'core/media-text',    
            'core/image',
            'core/gallery',
            'core/file',
            'core/embed',

			'papiercode/paragraph'
		];
	 
		wp.blocks.getBlockTypes().forEach( function( block_type ) {
			if ( -1 === allowed_core_blocks.indexOf( block_type.name ) ) {
				wp.blocks.unregisterBlockType( block_type.name );
			}
		} );

		var allowed_embed_blocks = [
            'youtube',
            'dailymotion',
            'vimeo'
		];

		wp.blocks.getBlockVariations('core/embed').forEach( function ( block_type ) {
			if ( -1 === allowed_embed_blocks.indexOf( block_type.name ) ) {
			  wp.blocks.unregisterBlockVariation( 'core/embed', block_type.name );
			}
		});
		
        
		/*=====  FIN Blocs disponibles  =====*/
      
        wp.data.dispatch( 'core/edit-post').removeEditorPanel( 'page-attributes' );
    
    });

} )()


