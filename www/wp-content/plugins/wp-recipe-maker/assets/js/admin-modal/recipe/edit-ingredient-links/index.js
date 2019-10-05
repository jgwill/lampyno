import React, { Component, Fragment } from 'react';

import '../../../../css/admin/modal/recipe/ingredient-links.scss';

import Header from '../../general/Header';
import Footer from '../../general/Footer';
import { __wprm } from '../../../shared/Translations';

import Api from '../edit/RecipeIngredients/IngredientLinks/Api';
import IngredientLink from '../edit/RecipeIngredients/IngredientLinks/IngredientLink';

export default class EditIngredientLinks extends Component {
    constructor(props) {
        super(props);

        this.state = {
            isSaving: false,
            ingredients: JSON.parse( JSON.stringify( this.props.ingredients ) ),
        };

        this.saveLinks = this.saveLinks.bind(this);
    }

    saveLinks() {
        const ingredientsToSave = this.state.ingredients.filter( (ingredient, index) => false !== ingredient.globalLink && JSON.stringify( ingredient ) !== JSON.stringify( this.props.ingredients[ index ] ) );
        const linksToSave = ingredientsToSave.map((ingredient) => ({
            name: ingredient.name,
            url: ingredient.globalLink.url,
            nofollow: ingredient.globalLink.nofollow,
        }));
        
        this.setState({
            isSaving: true,
        }, () => {
            Api.saveGlobalLinks( linksToSave ).then((data) => {
                if ( data ) {
                    // Update ingredient and state.
                    this.props.onIngredientsChange(this.state.ingredients);
                } else {
                    this.setState({
                        isSaving: false,
                    });
                }
            });
        });
    }

    render() {
        const changesMade = JSON.stringify( this.props.ingredients ) !== JSON.stringify( this.state.ingredients );        

        return (
            <Fragment>
                <Header
                    onCloseModal={ this.props.onCloseModal }
                >
                    { __wprm( 'Editing Global Ingredient Links' ) }
                </Header>
                <div className="wprm-admin-modal-field-ingredient-links-container wprm-admin-modal-field-ingredient-links-edit-container">
                    <div className="wprm-admin-modal-field-ingredient-links">
                    {
                        this.state.ingredients.map((field, index) => {
                            if ( 'group' === field.type || ! field.name ) {
                                return null;
                            }
        
                            return (
                                <IngredientLink
                                    ingredient={ field }
                                    onLinkChange={(link) => {
                                        let newIngredients = JSON.parse( JSON.stringify( this.state.ingredients ) );
                                        newIngredients[ index ].globalLink = link;

                                        this.setState({
                                            ingredients: newIngredients,
                                        });
                                    }}
                                    type={ 'edit-global' }
                                    hasChanged={
                                        JSON.stringify( field ) !== JSON.stringify( this.props.ingredients[ index ] )
                                    }
                                    isUpdating={ false }
                                    key={ index }
                                />
                            )
                        })
                    }
                    </div>
                </div>
                <Footer
                    savingChanges={ this.state.isSaving }
                >
                    <button
                        className="button"
                        onClick={ this.props.onCancel }
                    >
                        { __wprm( 'Cancel' ) }
                    </button>
                    <button
                        className="button button-primary"
                        onClick={ this.saveLinks }
                        disabled={ ! changesMade }
                    >
                        { __wprm( 'Save Changes' ) }
                    </button>
                </Footer>
            </Fragment>
        );
    }
}