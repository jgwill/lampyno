import React from 'react';

import { __wprm } from 'Shared/Translations';
import Icon from 'Shared/Icon';
import Spacer from './Spacer';

const getLinkData = (inline) => {
	return {
		href: inline.data.get('href'),
		newTab: inline.data.get('newTab'),
		noFollow: inline.data.get('noFollow'),
	}
}

const editHref = (editor, inline) => {
	let linkData = getLinkData( inline );
	const href = window.prompt( __wprm( 'Enter the URL of the link:' ), linkData.href );
	if ( href ) {
		linkData['href'] = href;
		editor.setNodeByKey(inline.key, {
			data: linkData
		});
	} else if ( '' === href ) {
		editor.unwrapInline('link');
	}
}

const toggleCheckbox = (editor, inline, option) => {
	let linkData = getLinkData( inline );
	
	linkData[ option ] = ! linkData[ option ];
	editor.setNodeByKey(inline.key, {
		data: linkData
	});
}
 
const ToolbarLink = (props) => {
	const { editor } = props.richText;
	const value = props.richText.state.value;
	const inline = value.inlines.find(inline => inline.type === 'link');

	if ( ! inline ) {
		return null;
	}

	const link = getLinkData( inline );

	return (
		<div className="wprm-admin-modal-toolbar-link">
			<Icon
				type="link"
				onClick={() => editHref( editor, inline ) }
			/>
			<span
				className="wprm-admin-modal-toolbar-link-value"
				onMouseDown={ () => editHref( editor, inline ) }
			>
				{ link.href }
			</span>
			<Spacer />
			<Icon
				type={ link.newTab ? 'checkbox-checked' : 'checkbox-empty' }
				onClick={() => toggleCheckbox( editor, inline, 'newTab' ) }
			/>
			<span
				className="wprm-admin-modal-toolbar-link-value"
				onMouseDown={ () => toggleCheckbox( editor, inline, 'newTab' ) }
			>{ __wprm( 'Open in new tab' ) }</span>
			<Spacer />
			<Icon
				type={ link.noFollow ? 'checkbox-checked' : 'checkbox-empty' }
				onClick={() => toggleCheckbox( editor, inline, 'noFollow' ) }
			/>
			<span
				className="wprm-admin-modal-toolbar-link-value"
				onMouseDown={ () => toggleCheckbox( editor, inline, 'noFollow' ) }
			>{ __wprm( 'Use nofollow' ) }</span>
		</div>
	);
}
export default ToolbarLink;