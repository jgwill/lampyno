import React, { Component } from 'react';

import '../../../../../../css/admin/modal/recipe/ingredient-links.scss';

import FieldContainer from '../../../../fields/FieldContainer';
import FieldRadio from '../../../../fields/FieldRadio';
import { __wprm } from '../../../../../shared/Translations';

import Api from './Api';
import IngredientLink from './IngredientLink';

export default class IngredientLinks extends Component {
    constructor(props) {
        super(props);

        this.state = {
            isUpdating: false,
        }
    }

    componentDidMount() {
        if ( wprm_admin.addons.premium ) {
            this.updateGlobalLinks();
        }
    }

    componentDidUpdate( prevProps ) {
        if ( ! this.state.isUpdating ) {
            // When switching to custom, use global links as defaults.
            if ( 'custom' === this.props.type && 'global' === prevProps.type ) {
                let newIngredients = JSON.parse( JSON.stringify( this.props.ingredients ) );
                let madeChange = false;

                for ( let i = 0; i < newIngredients.length; i++ ) {
                    let ingredient = newIngredients[ i ];

                    if ( 'ingredient' === ingredient.type && ! ingredient.hasOwnProperty( 'link' ) && ingredient.hasOwnProperty( 'globalLink' ) && ingredient.globalLink ) {
                        ingredient.link = {
                            url: ingredient.globalLink.url,
                            nofollow: ingredient.globalLink.nofollow,
                        }
                        madeChange = true;
                    }
                }

                if ( madeChange ) {
                    this.props.onIngredientsChange(newIngredients);
                }
            }
        }
    }

    updateGlobalLinks() {
        let getGlobalLinksFor = {};

        for ( let i = 0; i < this.props.ingredients.length; i++ ) {
            const ingredient = this.props.ingredients[ i ];

            if ( 'ingredient' === ingredient.type && ingredient.name && ( ! ingredient.hasOwnProperty( 'globalLink' ) || false === ingredient.globalLink ) ) {
                getGlobalLinksFor[ i ] = {
                    name: ingredient.name,
                }
            }
        }

        if ( 0 < Object.keys( getGlobalLinksFor ).length ) {
            const updatingIndexes = Object.keys( getGlobalLinksFor ).map( (index) => parseInt( index ) );

            this.setState({
                isUpdating: updatingIndexes,
            }, () => {
                Api.getGlobalLinks( getGlobalLinksFor ).then((data) => {
                    if ( data && data.links ) {
                        let newIngredients = JSON.parse( JSON.stringify( this.props.ingredients ) );
    
                        for ( let index in data.links ) {
                            newIngredients[ parseInt( index ) ].globalLink = data.links[ index ];
                        }
    
                        // Update ingredient and state.
                        this.props.onIngredientsChange(newIngredients);
                    }

                    this.setState({
                        isUpdating: false,
                    });
                });
            });
        }
    }

    render() {
        if ( ! wprm_admin.addons.premium ) {
            return (
                <p>{ __wprm( 'This feature is only available in' ) } <a href="https://bootstrapped.ventures/wp-recipe-maker/get-the-plugin/" target="_blank">WP Recipe Maker Premium</a>.</p>
            );
        }

        const ingredients = this.props.ingredients.filter((field) => 'ingredient' === field.type && field.name );
        if ( ! ingredients.length ) {
            return (
                <p>{ __wprm( 'No ingredients set for this recipe.' ) }</p>
            );
        }

        return (
            <div className="wprm-admin-modal-field-ingredient-links-container">
                <FieldContainer
                    id="link-type"
                    label={ __wprm( 'Ingredient Link Type' ) }
                    help={
                        'global' === this.props.type
                        ?
                        __wprm( 'Global: the same link will be used for every recipe with this ingredient' )
                        :
                        __wprm( 'Custom: these links will only affect the recipe below' )
                    }
                >
                    <FieldRadio
                        id="link-type"
                        options={[
                            { value: 'global', label: __wprm( 'Use Global Links' ) },
                            { value: 'custom', label: __wprm( 'Custom Links for this Recipe only' ) },
                        ]}
                        value={ this.props.type }
                        onChange={this.props.onTypeChange}
                    />
                </FieldContainer>
                <div className="wprm-admin-modal-field-ingredient-links">
                {
                    this.props.ingredients.map((field, index) => {
                        if ( 'group' === field.type || ! field.name ) {
                            return null;
                        }
    
                        return (
                            <IngredientLink
                                ingredient={ field }
                                onLinkChange={(link) => {
                                    // Only custom links can be changed here.
                                    let newIngredients = JSON.parse( JSON.stringify( this.props.ingredients ) );
                                    newIngredients[ index ].link = link;

                                    this.props.onIngredientsChange(newIngredients);
                                }}
                                type={ this.props.type }
                                isUpdating={ this.state.isUpdating && this.state.isUpdating.includes( index ) }
                                key={ index }
                            />
                        )
                    })
                }
                </div>
                {
                    'global' === this.props.type
                    &&
                    <button
                        className="button button-primary"
                        onClick={() => {
                            this.props.onModeChange('ingredient-links');
                        }}
                        disabled={ false !== this.state.isUpdating }
                    >{ __wprm( 'Edit Global Links' ) }</button>
                }
            </div>
        );
    }
}