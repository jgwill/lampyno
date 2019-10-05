import React, { Component, Fragment } from 'react';

import '../../../css/admin/modal/roundup.scss';

import { __wprm } from 'Shared/Translations';
import Header from '../general/Header';
import Footer from '../general/Footer';

import FieldImage from '../fields/FieldImage';
import FieldRadio from '../fields/FieldRadio';
import FieldText from '../fields/FieldText';
import FieldTextarea from '../fields/FieldTextarea';
import SelectRecipe from '../select/SelectRecipe';

export default class Roundup extends Component {
    constructor(props) {
        super(props);

        let type = 'internal';
        let link = '';
        let nofollow = false;
        let newtab = true;
        let name = '';
        let summary = '';
        let image = {
            id: 0,
            url: '',
        }

        if ( props.args.fields && props.args.fields.roundup ) {
            const roundup = props.args.fields.roundup;

            if ( ! roundup.id && roundup.link ) {
                type = 'external';
                link = roundup.link;
                nofollow = roundup.nofollow ? true : false;
                newtab = roundup.newtab ? true : false;
                name = roundup.name;
                summary = roundup.summary;
                image.id = roundup.image;
            }
        }
    
        this.state = {
            type,
            recipe: false,
            link,
            nofollow,
            newtab,
            name,
            summary,
            image,
        };
    }

    selectionsMade() {
        if ( 'external' === this.state.type ) {
            return '' !== this.state.link;
        } else {
            return false !== this.state.recipe;
        }
    }

    render() {
        return (
            <Fragment>
                <Header
                    onCloseModal={ this.props.maybeCloseModal }
                >
                    { __wprm( 'Select Roundup Recipe' ) }
                </Header>
                <div className={ `wprm-admin-modal-roundup-container wprm-admin-modal-roundup-container-${ this.state.type }` }>
                    <div className="wprm-admin-modal-roundup-field-label">{ __wprm( 'Type' ) }</div>
                    <FieldRadio
                        id="type"
                        options={ [
                            { value: 'internal', label: __wprm( 'Use one of your own recipes' ) },
                            { value: 'external', label: __wprm( 'Use external recipe from a different website' ) },
                        ] }
                        value={ this.state.type }
                        onChange={(type) => {
                            this.setState({ type });
                        }}
                    />
                    {
                        'internal' === this.state.type
                        ?
                        <Fragment>
                            <div className="wprm-admin-modal-roundup-field-label">{ __wprm( 'Recipe' ) }</div>
                            <SelectRecipe
                                options={ [] }
                                value={ this.state.recipe }
                                onValueChange={(recipe) => {
                                    this.setState({ recipe });
                                }}
                            />
                        </Fragment>
                        :
                        <Fragment>
                            <div className="wprm-admin-modal-roundup-field-label">{ __wprm( 'Link' ) }</div>
                            <FieldText
                                name="roundup-link"
                                placeholder="https://demo.wprecipemaker.com/amazing-vegetable-pizza/"
                                type="url"
                                value={ this.state.link }
                                onChange={ (link) => {
                                    this.setState({ link });
                                }}
                            />
                            <div className="wprm-admin-modal-roundup-field-nofollow-container">
                                <input
                                    id="wprm-admin-modal-roundup-field-nofollow"
                                    type="checkbox"
                                    checked={ this.state.nofollow }
                                    onChange={(e) => {
                                        this.setState({ nofollow: e.target.checked });
                                    }}
                                /> <label htmlFor="wprm-admin-modal-roundup-field-nofollow">{ __wprm( 'Add rel="nofollow" to link' ) }</label>
                            </div>
                            <div className="wprm-admin-modal-roundup-field-new-tab-container">
                                <input
                                    id="wprm-admin-modal-roundup-field-new-tab"
                                    type="checkbox"
                                    checked={ this.state.newtab }
                                    onChange={(e) => {
                                        this.setState({ newtab: e.target.checked });
                                    }}
                                /> <label htmlFor="wprm-admin-modal-roundup-field-new-tab">{ __wprm( 'Open link in new tab' ) }</label>
                            </div>
                            <div className="wprm-admin-modal-roundup-field-label">{ __wprm( 'Image' ) }</div>
                            <FieldImage
                                id={ this.state.image.id }
                                url={ this.state.image.url }
                                onChange={ ( id, url ) => {
                                    this.setState( {
                                        image: {
                                            id,
                                            url,
                                        }
                                    });
                                }}
                            />
                            <div className="wprm-admin-modal-roundup-field-label">{ __wprm( 'Name' ) }</div>
                            <FieldText
                                name="recipe-name"
                                placeholder={ __wprm( 'Recipe Name' ) }
                                value={ this.state.name }
                                onChange={ (name) => {
                                    this.setState({ name });
                                }}
                            />
                            <div className="wprm-admin-modal-roundup-field-label">{ __wprm( 'Summary' ) }</div>
                            <FieldTextarea
                                placeholder={ __wprm( 'Short description of this recipe...' ) }
                                value={ this.state.summary }
                                onChange={ (summary) => {
                                    this.setState({ summary });
                                }}
                            />
                        </Fragment>
                    }
                </div>
                <Footer
                    savingChanges={ false }
                >
                    <button
                        className="button button-primary"
                        onClick={ () => {
                            if ( 'function' === typeof this.props.args.insertCallback ) {
                                this.props.args.insertCallback( this.state );
                            }
                            this.props.maybeCloseModal();
                        } }
                        disabled={ ! this.selectionsMade() }
                    >
                        { __wprm( 'Use' ) }
                    </button>
                </Footer>
            </Fragment>
        );
    }
}