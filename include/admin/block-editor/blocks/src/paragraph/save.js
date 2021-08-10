import { RichText, useBlockProps } from '@wordpress/block-editor';

export default function save( props ) {

	const { alignment, content } = props.attributes;

	const blockProps = useBlockProps.save({
		className: `text-align-${ alignment }`,
	})

	return (
		<RichText.Content
			tagName="p"
			{ ...blockProps }
			value={ content }
		/>
	);
}