import React, { Component, Fragment } from 'react';

import '../../../css/admin/modal/custom-field.scss';

import { __wprm } from '../../shared/Translations';
import Header from '../general/Header';
import Footer from '../general/Footer';

import FieldContainer from '../fields/FieldContainer';
import FieldDropdown from '../fields/FieldDropdown';
import FieldText from '../fields/FieldText';
import Api from './Api';

export default class Menu extends Component {
    constructor(props) {
        super(props);

        let field = {
            key: '',
            name: '',
            type: 'text',
        }

        let editing = false;
        if ( props.args.hasOwnProperty( 'field' ) ) {
            editing = true;
            field = JSON.parse( JSON.stringify( props.args.field ) );
        }

        this.state = {
            editing,
            field,
            originalField: JSON.parse( JSON.stringify( field ) ),
            savingChanges: false,
        };

        this.changesMade = this.changesMade.bind(this);
        this.saveChanges = this.saveChanges.bind(this);
    }

    sanitizeSlug(text) {
        text = text.trim();
        text = text.toLowerCase();

        const from = "àáäâèéëêìíïîòóöôùúüûñçěščřžýúůďťň·/-,:;";
        const to   = "aaaaeeeeiiiioooouuuuncescrzyuudtn______";

        for ( let i=0, l=from.length ; i<l ; i++ )
        {
            text = text.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        text = text.replace('.', '-')
            .replace(/[^a-z0-9\s_]/g, '')
            .replace(/\s+/g, '_')
            .replace(/_+/g, '_');

        return text;
    }

    saveChanges() {
        if ( ! this.state.field.key.trim() || ! this.state.field.name.trim() ) {
            alert( __wprm( 'All fields are required.' ) );
        } else {
            this.setState({
                savingChanges: true,
            }, () => {
                Api.saveCustomField( this.state.editing, this.state.field ).then((field) => {
                    if ( field ) {
                        this.setState({
                            originalField: JSON.parse( JSON.stringify( this.state.field ) ),
                            savingChanges: false,
                        },() => {
                            if ( 'function' === typeof this.props.args.saveCallback ) {
                                this.props.args.saveCallback( this.state.field );
                            }
                            this.props.maybeCloseModal();
                        });
                    } else {
                        if ( ! this.state.editing && false === field ) {
                            alert( __wprm( 'Something went wrong. Make sure this key does not exist yet.' ) );
                        }
                        this.setState({
                            savingChanges: false,
                        });
                    }
                });
            })
        }
    }

    allowCloseModal() {
        return ! this.state.savingChanges && ( ! this.changesMade() || confirm( __wprm( 'Are you sure you want to close without saving changes?' ) ) );
    }

    changesMade() {
        return JSON.stringify( this.state.field ) !== JSON.stringify( this.state.originalField );
    }

    render() {
        return (
            <Fragment>
                <Header
                    onCloseModal={ this.props.maybeCloseModal }
                >
                    {
                        this.state.editing
                        ?
                        
                        `${ __wprm( 'Editing Custom Field' ) }${this.state.field.key ? ` - ${this.state.field.key}` : ''}`
                        :
                        `${ __wprm( 'Creating new Custom Field' ) }${this.state.field.key ? ` - ${this.state.field.key}` : ''}`
                    }
                </Header>
                <div className="wprm-admin-modal-custom-field-container">
                    {
                        false === this.state.editing
                        &&
                        <Fragment>
                            <FieldContainer id="type" label={ __wprm( 'Type' ) }>
                                <FieldDropdown
                                    options={ wprm_admin_modal.custom_fields.types }
                                    value={ this.state.field.type }
                                    onChange={ (type) => {
                                        this.setState({
                                            field: {
                                                ...this.state.field,
                                                type,
                                            }
                                        });
                                    }}
                                />
                            </FieldContainer>
                            <FieldContainer id="key" label={ __wprm( 'Key' ) }>
                            <FieldText
                                placeholder={ __wprm( 'my-custom-field' ) }
                                value={ `${this.state.field.key}` }
                                onChange={ (key) => {
                                    this.setState({
                                        field: {
                                            ...this.state.field,
                                            key: this.sanitizeSlug( key ),
                                        }
                                    });
                                }}
                            />
                        </FieldContainer>
                        </Fragment>
                    }
                    <FieldContainer id="name" label={ __wprm( 'Name' ) }>
                        <FieldText
                            placeholder={ __wprm( 'My Custom Field' ) }
                            value={ this.state.field.name }
                            onChange={ (name) => {
                                this.setState({
                                    field: {
                                        ...this.state.field,
                                        name,
                                    }
                                });
                            }}
                        />
                    </FieldContainer>
                </div>
                <Footer
                    savingChanges={ this.state.savingChanges }
                >
                    <button
                        className="button button-primary"
                        onClick={ this.saveChanges }
                        disabled={ ! this.changesMade() }
                    >
                        { __wprm( 'Save' ) }
                    </button>
                </Footer>
            </Fragment>
        );
    }
}