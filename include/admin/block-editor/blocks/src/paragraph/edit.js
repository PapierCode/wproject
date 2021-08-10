import { 
	useBlockProps,
	RichText,
	AlignmentToolbar,
	BlockControls
} from '@wordpress/block-editor'

import {
	createBlock
} from '@wordpress/blocks'

export default function edit( props ) {
	
	const blockProps = useBlockProps({
		className: `text-align-${ props.attributes.alignment }`,
	})

	//console.log(props);

	return (

		<>

			<BlockControls group="block">
				<AlignmentToolbar
					value={ props.attributes.alignment }
					onChange={ NewAlignment => props.setAttributes( { alignment : NewAlignment } ) }
				/>
			</BlockControls>

			<RichText
				tagName="p"
				placeholder="Nouveau paragraphe..."
				{...blockProps}

				value={ props.attributes.content }
				multiligne={false}
				allowedFormats={ [ 'core/bold', 'core/italic', 'core/link', 'core/strikethrough', 'core/underline', 'core/subscript', 'core/superscript' ] }
				
				onChange={ ( NewContent ) => props.setAttributes( { content: NewContent } ) }
				onReplace= { props.onReplace }
				onRemove= { props.onRemove }
				onSplit={ ( value ) => {
					return createBlock( 'papiercode/paragraph', {
						...props,
						content: value,
					} );
				} }
			/>

		</>
	)
}