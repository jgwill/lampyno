import React from 'react';

import Icon from 'Shared/Icon';

const ButtonMark = (props) => {
	const isActive = props.richText.hasMark( props.type );

	return (
		<span
			className={ `wprm-admin-modal-toolbar-button${isActive ? ' wprm-admin-modal-toolbar-button-active' : ''}` }
			onMouseDown={ (event) => {
				event.preventDefault();
				props.richText.editor.toggleMark( props.type );
			}}
		>
			<Icon
				type={ props.type }
				title={ props.title }
			/>
		</span>
	);
}
export default ButtonMark;