import React from 'react';

import { __wprm } from 'Shared/Translations';

import ModalToolbar from '../../../general/toolbar';
import ButtonAction from './ButtonAction';
import ButtonCharacter from './ButtonCharacter';
import ButtonCode from './ButtonCode';
import ButtonLink from './ButtonLink';
import ButtonMark from './ButtonMark';
import Spacer from './Spacer';
import ToolbarLink from './ToolbarLink';
import ToolbarSuggest from './ToolbarSuggest';

const Toolbar = (props) => {
	const hidden = {
		visibility: 'hidden'
	};

	let hideStyling = false;
	let hideLink = false;

	switch( props.type ) {
		case 'no-styling':
			hideStyling = true;
			break;
		case 'no-link':
			hideLink = true;
			break;
		case 'equipment':
		case 'ingredient':
			hideLink = true;
			break;
	}

	return (
		<ModalToolbar>
			{
				props.richText.hasInline('link')
				&&
				<ToolbarLink
					richText={ props.richText }
				/>
			}
			{
				( 'ingredient' === props.type || 'equipment' === props.type )
				&&
				<ToolbarSuggest
					type={ props.type }
					richText={ props.richText }
					value={ props.value }
				/>
			}
			<div className="wprm-admin-modal-toolbar-buttons">
				<span
					style={ hideStyling ? hidden : null }
				>
					<ButtonMark richText={ props.richText } type="bold" title={ __wprm( 'Bold' ) } />
					<ButtonMark richText={ props.richText } type="italic" title={ __wprm( 'Italic' ) } />
					<ButtonMark richText={ props.richText } type="underline" title={ __wprm( 'Underline' ) } />
					<Spacer />
					<ButtonMark richText={ props.richText } type="subscript" title={ __wprm( 'Subscript' ) } />
					<ButtonMark richText={ props.richText } type="superscript" title={ __wprm( 'Superscript' ) } />
				</span>
				<Spacer />
				<span
					style={ hideLink ? hidden : null }
				>
					<ButtonLink richText={ props.richText } />
				</span>
				<Spacer />
				<ButtonCode richText={ props.richText } />
				<ButtonAction
					type="adjustable"
					title={ __wprm( 'Adjustable Shortcode' ) }
					action={() => {
						props.richText.editor.wrapText( '[adjustable]', '[/adjustable]' );
						props.richText.editor.moveToEnd();
					}}
				/>
				<ButtonAction
					type="clock"
					title={ __wprm( 'Timer Shortcode' ) }
					action={() => {
						props.richText.editor.wrapText( '[timer minutes=0]', '[/timer]' );
						props.richText.editor.moveToEnd();
					}}
				/>
				<Spacer />
				<ButtonCharacter richText={ props.richText } character="½" />
				<ButtonCharacter richText={ props.richText } character="⅓" />
				<ButtonCharacter richText={ props.richText } character="⅔" />
				<ButtonCharacter richText={ props.richText } character="¼" />
				<ButtonCharacter richText={ props.richText } character="¾" />
				<ButtonCharacter richText={ props.richText } character="⅕" />
				<ButtonCharacter richText={ props.richText } character="⅙" />
				<ButtonCharacter richText={ props.richText } character="⅐" />
				<ButtonCharacter richText={ props.richText } character="⅛" />
				<Spacer />
				<ButtonCharacter richText={ props.richText } character="°" />
			</div>
		</ModalToolbar>
	);
}
export default Toolbar;