import React from 'react';

import Icon from 'Shared/Icon';
import { __wprm } from 'Shared/Translations';

const ButtonCode = (props) => {
	const isActive = props.richText.hasInline('code');
	const { editor } = props.richText;

	return (
		<span
			className={ `wprm-admin-modal-toolbar-button${ isActive ? ' wprm-admin-modal-toolbar-button-active' : ''}` }
			onMouseDown={ (event) => {
				event.preventDefault();

				if ( isActive ) {
					editor.unwrapInline('code');
				} else {
					if ( ! editor.value.selection.isExpanded ) {
						const code = window.prompt( __wprm( 'HTML or Shortcode:' ) );

						if ( code ) {
							editor
								.insertText(code)
								.moveFocusBackward(code.length);
						}

					}
					editor.wrapInline({
						type: 'code',
					});
					editor.moveToEnd();
				}
			}}
		>
			<Icon
				type="code"
				title={ isActive ? __wprm( 'Remove HTML or Shortcode' ) : __wprm( 'Insert HTML or Shortcode' ) }
			/>
		</span>
	);
}
export default ButtonCode;