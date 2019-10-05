import React from 'react';

import Icon from 'Shared/Icon';

const ButtonAction = (props) => {
	return (
		<span
			className="wprm-admin-modal-toolbar-button"
			onMouseDown={ (event) => {
				event.preventDefault();
				props.action();
			}}
		>
			<Icon
				type={ props.type }
				title={ props.title }
			/>
		</span>
	);
}
export default ButtonAction;