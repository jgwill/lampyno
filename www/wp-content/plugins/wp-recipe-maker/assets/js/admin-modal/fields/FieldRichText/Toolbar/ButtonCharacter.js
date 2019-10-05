import React from 'react';

import Tooltip from 'Shared/Tooltip';

const ButtonCharacter = (props) => {
	return (
		<span
			className="wprm-admin-modal-toolbar-button"
			onMouseDown={ (event) => {
				event.preventDefault();
				props.richText.editor.insertText( props.character );
			}}
		>
			<Tooltip
				content={ props.title }
			>
				<span className="wprm-admin-modal-toolbar-button-character">{ props.character }</span>
			</Tooltip>
		</span>
	);
}
export default ButtonCharacter;