import React, { Component } from 'react';
import { Draggable } from 'react-beautiful-dnd';
import { isKeyHotkey } from 'is-hotkey';

const isTabHotkey = isKeyHotkey('tab');

import Icon from 'Shared/Icon';
import { __wprm } from 'Shared/Translations';

import FieldRichText from './FieldRichText';
import FieldImage from './FieldImage';

const handle = (provided) => (
    <div
        className="wprm-admin-modal-field-instruction-handle"
        {...provided.dragHandleProps}
        tabIndex="-1"
    ><Icon type="drag" /></div>
);

const group = (props, provided) => (
    <div
        className="wprm-admin-modal-field-instruction-group"
        ref={provided.innerRef}
        {...provided.draggableProps}
    >
        <div className="wprm-admin-modal-field-instruction-main-container">
            { handle(provided) }
            <div className="wprm-admin-modal-field-instruction-group-name-container">
                <FieldRichText
                    singleLine
                    toolbar="no-styling"
                    value={ props.name }
                    placeholder={ __wprm( 'Instruction Group Header' ) }
                    onChange={(value) => props.onChangeText(value)}
                    onKeyDown={(event) => {
                        if ( isTabHotkey(event) ) {
                            props.onTab(event);
                        }
                    }}
                />
            </div>
        </div>
        <div className="wprm-admin-modal-field-instruction-after-container">
            <Icon
                type="trash"
                onClick={ props.onDelete }
            />
        </div>
    </div>
);

const instruction = (props, provided) => (
    <div
        className="wprm-admin-modal-field-instruction"
        ref={provided.innerRef}
        {...provided.draggableProps}
    >
        <div className="wprm-admin-modal-field-instruction-main-container">
            { handle(provided) }
            <div className="wprm-admin-modal-field-instruction-text-container">
                <FieldRichText
                    value={ props.text }
                    placeholder={ __wprm( 'This is one step of the instructions.' ) }
                    onChange={(value) => props.onChangeText(value)}
                    onKeyDown={(event) => {
                        if ( isTabHotkey(event) ) {
                            props.onTab(event);
                        }
                    }}
                />
            </div>
        </div>
        <div className="wprm-admin-modal-field-instruction-after-container">
            <Icon
                type="trash"
                onClick={ props.onDelete }
            />
            <FieldImage
                id={ props.image }
                url={ props.image_url }
                onChange={(id, url) => props.onChangeImage(id, url)}
                disableTab={ true }
            />
        </div>
    </div>
);

export default class FieldInstruction extends Component {
    shouldComponentUpdate(nextProps) {
        return JSON.stringify(this.props) !== JSON.stringify(nextProps);
    }

    render() {
        return (
            <Draggable
                draggableId={ `instruction-${this.props.uid}` }
                index={ this.props.index }
            >
                {(provided, snapshot) => {
                    if ( 'group' === this.props.type ) {
                        return group(this.props, provided);
                    } else {
                        return instruction(this.props, provided);
                    }
                }}
            </Draggable>
        );
    }
}