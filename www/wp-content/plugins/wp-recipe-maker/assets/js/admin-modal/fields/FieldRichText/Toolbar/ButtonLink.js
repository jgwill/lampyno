import React, { Fragment } from 'react';

import Icon from 'Shared/Icon';
import { __wprm } from 'Shared/Translations';

const ButtonLink = (props) => {
	const isActive = props.richText.hasInline('link');
	const { editor } = props.richText;

	return (
		<Fragment>
			{
				isActive
				?
				<span
					className="wprm-admin-modal-toolbar-button wprm-admin-modal-toolbar-button-active"
					onMouseDown={ (event) => {
						event.preventDefault();
						editor.unwrapInline('link');
					}}
				>
					<Icon
						type="unlink"
						title={ __wprm( 'Remove Link' ) }
					/>
				</span>
				:
				<span
					className="wprm-admin-modal-toolbar-button"
					onMouseDown={ (event) => {
						event.preventDefault();

						const href = window.prompt( __wprm( 'Enter the URL of the link:' ) );
						if ( href ) {
							if ( ! editor.value.selection.isExpanded ) {
								editor
									.insertText(href)
									.moveFocusBackward(href.length);
							}

							editor.wrapInline({
								type: 'link',
								data: {
									href,
								},
							});
							editor.moveToEnd();
						}
					}}
				>
					<Icon
						type="link"
						title={ isActive ? __wprm( 'Edit Link' ) : __wprm( 'Add Link' ) }
					/>
				</span>
			}
		</Fragment>
	);
}
export default ButtonLink;