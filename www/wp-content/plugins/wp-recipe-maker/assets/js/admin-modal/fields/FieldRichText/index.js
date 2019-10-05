import React, { Component, Fragment } from 'react';

import { Editor, getEventTransfer, cloneFragment } from 'slate-react';
import { IS_IE } from 'slate-dev-environment'
import Html from 'slate-html-serializer';

import { isKeyHotkey } from 'is-hotkey';

const isEnterKey = isKeyHotkey('enter');
const isBoldHotkey = isKeyHotkey('mod+b');
const isItalicHotkey = isKeyHotkey('mod+i');
const isUnderlinedHotkey = isKeyHotkey('mod+u');

import '../../../../css/admin/modal/general/rich-text.scss';

import Toolbar from './Toolbar';
import rules from './rules';
const html = new Html({ rules })

export default class FieldRichText extends Component {
    constructor(props) {
        super(props);

        this.state = {
            value: this.getValueFromHtml( props.value ),
        };

        if ( props.singleLine ) {
            this.schema = {
                document: {
                    nodes: [
                        {
                            match: { type: 'paragraph' },
                            min: 1,
                            max: 1,
                        },
                    ],
                },
            }
        } else {
            this.schema = null;
        }

        this.getValueFromHtml = this.getValueFromHtml.bind(this);
        this.onChange = this.onChange.bind(this);
        this.onCopy = this.onCopy.bind(this);
        this.onCut = this.onCut.bind(this);
        this.onPaste = this.onPaste.bind(this);
        this.onKeyDown = this.onKeyDown.bind(this);
        this.renderBlock = this.renderBlock.bind(this);
        this.renderInline = this.renderInline.bind(this);
        this.renderMark = this.renderMark.bind(this);
        this.hasMark = this.hasMark.bind(this);
        this.hasInline = this.hasInline.bind(this);
    }

    getValueFromHtml( htmlString ) {
        return html.deserialize( htmlString );
    }

    getHtmlFromValue( value ) {
        let htmlString = html.serialize( value );

        if ( this.props.singleLine ) {
            // Strip surrounding paragraph tags if present.
            htmlString = htmlString.replace(/^<p>(.*)<\/p>$/gm, '$1');
        }

        return htmlString;
    }

    onChange( { value } ) {
        const oldHtmlString = this.getHtmlFromValue( this.state.value );
        const newHtmlString = this.getHtmlFromValue( value );

        if ( oldHtmlString !== newHtmlString ) {
            this.props.onChange(newHtmlString);
        }

        this.setState({ value })
    }

    onCopy( event, editor, next ) {
        cloneFragment(event, editor, () => {
            if (event.clipboardData && event.clipboardData.setData && !IS_IE) {
                const htmlToCopy = this.getHtmlFromValue( editor.value );
                event.clipboardData.setData('text/html', htmlToCopy);
            }
        });
    }

    onCut( event, editor, next ) {
        cloneFragment(event, editor, () => {
            if (event.clipboardData && event.clipboardData.setData && !IS_IE) {
                const htmlToCopy = this.getHtmlFromValue( editor.value );
                event.clipboardData.setData('text/html', htmlToCopy);
            }

            // Need to remove cut text.
            // https://github.com/ianstormtaylor/slate/blob/d21cb09a12c35453d9053acb45f51ae5645d0ca7/packages/slate-react/src/plugins/dom/after.js
            const { value } = editor
            const { document, selection } = value
            const { end, isCollapsed } = selection
            let voidPath

            if (isCollapsed) {
                for (const [node, path] of document.ancestors(end.path)) {
                if (editor.isVoid(node)) {
                    voidPath = path
                    break
                }
                }
            }

            if (voidPath) {
                editor.removeNodeByKey(voidPath)
            } else {
                editor.delete()
            }
        });
    }

    onPaste( event, editor, next ) {
        const transfer = getEventTransfer(event);
        if (transfer.type !== 'html') return next();
        const { document } = html.deserialize(transfer.html);
        editor.insertFragment(document);
    }

    onKeyDown(event, editor, next) {
        // Pass along key down.
        if ( this.props.onKeyDown ) {
            this.props.onKeyDown(event);
        }

        // Prevent ENTER key in singleLine mode.
        if ( this.props.singleLine && isEnterKey(event) ) {
            event.preventDefault();
            return;
        }

        // Check for mark shortcuts.
        let mark;
    
        if (isBoldHotkey(event)) {
            mark = 'bold';
        } else if (isItalicHotkey(event)) {
            mark = 'italic';
        } else if (isUnderlinedHotkey(event)) {
            mark = 'underline';
        } else {
            return next();
        }
    
        event.preventDefault();
        editor.toggleMark(mark);
    }

    render() {
        const toolbarType = this.props.toolbar ? this.props.toolbar : 'all';

        return (
            <Fragment>
                {
                    this.state.value.selection.isFocused
                    &&
                    <Toolbar
                        richText={ this }
                        value={ this.state.value }
                        type={ toolbarType }
                    />
                }
                <Editor
                    spellCheck
                    className={ `wprm-admin-modal-field-richtext${ this.props.className ? ` ${ this.props.className }` : ''}`}
                    value={this.state.value}
                    placeholder={this.props.placeholder}
                    onChange={this.onChange}
                    onPaste={this.onPaste}
                    onCopy={this.onCopy}
                    onCut={this.onCut}
                    renderBlock={this.renderBlock}
                    renderInline={this.renderInline}
                    renderMark={this.renderMark}
                    onKeyDown={this.onKeyDown}
                    tabIndex={ 0 }
                    ref={ (editor) => this.editor = editor }
                    schema={this.schema}
                />
            </Fragment>
        );
    }

    renderBlock( props, editor, next ) {
        switch (props.node.type) {
            case 'paragraph':
                if ( this.props.singleLine ) {
                    return (
                        <div className="wprm-admin-modal-field-richtext-singleline">
                            { props.children }
                        </div>
                    );
                }

                return (
                    <p {...props.attributes} className={props.node.data.get('className')}>
                        {props.children}
                    </p>
                )
            default:
                return next()
        }
    }

    renderInline(props, editor, next) {
        switch (props.node.type) {
            case 'link':
                return (
                    <a
                        {...props.attributes}
                        href={ props.node.data.get('href') }
                        target={ props.node.data.get('newTab') ? '_blank' : null }
						rel={ props.node.data.get('noFollow') ? 'nofollow' : null }
                    >
                        {props.children}
                    </a>
                )
            case 'code':
                return (
                    <span style={{fontFamily: 'monospace'}}>
                        {props.children}
                    </span>
                )
            default:
                return next()
        }
    }
    
    renderMark(props, editor, next) {
        const { mark, attributes } = props;
        switch (mark.type) {
            case 'bold':
                return <strong {...attributes}>{props.children}</strong>
            case 'italic':
                return <em {...attributes}>{props.children}</em>
            case 'underline':
                return <u {...attributes}>{props.children}</u>
            case 'subscript':
                return <sub {...attributes}>{props.children}</sub>
            case 'superscript':
                return <sup {...attributes}>{props.children}</sup>
            default:
                return next()
        }
    }

    hasMark(type) {
        const { value } = this.state;
        return value.activeMarks.some(mark => mark.type === type);
    }

    hasInline(type) {
        const { value } = this.state;
        return value.inlines.some(inline => inline.type === type)
    }
}