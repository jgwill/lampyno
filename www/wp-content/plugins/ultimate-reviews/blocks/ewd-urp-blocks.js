var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	InspectorControls = wp.editor.InspectorControls;

registerBlockType( 'ultimate-reviews/ewd-urp-display-reviews-block', {
	title: 'Display Reviews',
	icon: 'star-filled',
	category: 'ewd-urp-blocks',
	attributes: {
		post_count: { type: 'string' },
		product_name: { type: 'string' },
		include_category: { type: 'string' },
		exclude_category: { type: 'string' },
		include_ids: { type: 'string' },
		exclude_ids: { type: 'string' },
	},

	edit: function( props ) {
		var returnString = [];
		returnString.push(
			el( InspectorControls, {},
				el( TextControl, {
					label: 'Number of Reviews',
					value: props.attributes.post_count,
					onChange: ( value ) => { props.setAttributes( { post_count: value } ); },
				} ),
				el( TextControl, {
					label: 'Product Name',
					value: props.attributes.product_name,
					onChange: ( value ) => { props.setAttributes( { product_name: value } ); },
				} ),
				el( TextControl, {
					label: 'Include Category',
					value: props.attributes.include_category,
					onChange: ( value ) => { props.setAttributes( { include_category: value } ); },
				} ),
				el( TextControl, {
					label: 'Exclude Category',
					value: props.attributes.exclude_category,
					onChange: ( value ) => { props.setAttributes( { exclude_category: value } ); },
				} ),
				el( TextControl, {
					label: 'Include Specific Review IDs',
					value: props.attributes.include_ids,
					onChange: ( value ) => { props.setAttributes( { include_ids: value } ); },
				} ),
				el( TextControl, {
					label: 'Exclude Specific Review IDs',
					value: props.attributes.exclude_ids,
					onChange: ( value ) => { props.setAttributes( { exclude_ids: value } ); },
				} ),
			),
		);
		returnString.push( el( 'div', { class: 'ewd-urp-admin-block ewd-urp-admin-block-display-reviews' }, 'Display Reviews Block' ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );


registerBlockType( 'ultimate-reviews/ewd-urp-submit-review-block', {
	title: 'Submit Review',
	icon: 'star-filled',
	category: 'ewd-urp-blocks',
	attributes: {
		product_name: { type: 'string' },
		redirect_page: { type: 'string' },
	},

	edit: function( props ) {
		var returnString = [];
		returnString.push(
			el( InspectorControls, {},
				el( TextControl, {
					label: 'Product Name',
					value: props.attributes.product_name,
					onChange: ( value ) => { props.setAttributes( { product_name: value } ); },
				} ),
				el( TextControl, {
					label: 'Redirect Page',
					value: props.attributes.redirect_page,
					onChange: ( value ) => { props.setAttributes( { redirect_page: value } ); },
				} ),
			),
		);
		returnString.push( el( 'div', { class: 'ewd-urp-admin-block ewd-urp-admin-block-submit-review' }, 'Submit Review Block' ) );
		return returnString;
	},

	save: function() {
		return null;
	},
} );

