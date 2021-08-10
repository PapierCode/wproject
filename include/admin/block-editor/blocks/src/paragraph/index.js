import { 
	useBlockProps,
	RichText,
	AlignmentToolbar,
	BlockControls
} from '@wordpress/block-editor'

import {
	registerBlockType,
	createBlock
} from '@wordpress/blocks'

import metadata from './block.json';

registerBlockType( metadata, {

	edit : ( props ) => {

		const blockProps = useBlockProps( {
			className: 'text-align-' + props.attributes.alignment
		} )
	
		return (
	
			<>
	
				<BlockControls group='block'>
					<AlignmentToolbar
						value = { props.attributes.alignment }
						onChange = { NewAlignment => props.setAttributes( { alignment : NewAlignment } ) }
					/>
				</BlockControls>
	
				<RichText
					tagName = 'p'
					placeholde = 'Nouveau paragraphe...'
					value = { props.attributes.content }
					
					{ ...blockProps }	
					multiligne = { false }
					allowedFormats = { [ 'core/bold', 'core/italic', 'core/link', 'core/strikethrough', 'core/underline', 'core/subscript', 'core/superscript' ] }
					
					onChange = { ( NewContent ) => props.setAttributes( { content: NewContent } ) }
					onReplace = { props.onReplace }
					onRemove = { props.onRemove }
					onSplit ={ ( value ) => {
						return createBlock( 'papiercode/paragraph', {
							...props,
							content: value,
						} );
					} }
				/>
	
			</>

		) // FIN return 

	}, // FIN edit()

	save : ( props ) => {

		const blockProps = useBlockProps.save( {
			className: 'text-align-' + props.attributes.alignment
		} )
	
		return (

			<RichText.Content
				tagName = 'p'
				{ ...blockProps }
				value = { props.attributes.content }
			/>

		); // FIN return

	} // FIN save()

} ) // FIN registerBlockType()
