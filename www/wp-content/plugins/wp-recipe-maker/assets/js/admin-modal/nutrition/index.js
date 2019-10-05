import React, { Component, Fragment } from 'react';

import '../../../css/admin/modal/nutrition.scss';

import { __wprm } from '../../shared/Translations';
import Loader from '../../shared/Loader';
import Header from '../general/Header';
import Footer from '../general/Footer';

import FieldText from '../fields/FieldText';
import Api from '../recipe/nutrition-calculation/Api';
import Nutrients from '../recipe/nutrition-calculation/Nutrients';

export default class Menu extends Component {
    constructor(props) {
        super(props);

        let ingredient = {
            id: 0,
            amount: '',
            unit: '',
            name: '',
            facts: {},
        }
        let loadingIngredient = false;

        if ( props.args.hasOwnProperty( 'ingredient' ) ) {
            ingredient = JSON.parse( JSON.stringify( props.args.ingredient ) );
        } else if ( props.args.hasOwnProperty( 'ingredientId' ) ) {
            loadingIngredient = true;
            Api.getCustomIngredient(props.args.ingredientId).then((data) => {
                if ( data ) {
                    const savedIngredient = JSON.parse( JSON.stringify( data.ingredient ) );

                    if ( savedIngredient ) {
                        const ingredient = {
                            id: savedIngredient.id,
                            amount: savedIngredient.nutrition.amount,
                            unit: savedIngredient.nutrition.unit,
                            name: savedIngredient.name,
                            facts: savedIngredient.nutrition.nutrients,
                        }

                        this.setState({
                            ingredient,
                            originalIngredient: JSON.parse( JSON.stringify( ingredient ) ),
                            loadingIngredient: false,
                        });
                    }
                }
            });
        }

        this.state = {
            ingredient,
            originalIngredient: JSON.parse( JSON.stringify( ingredient ) ),
            loadingIngredient,
            savingChanges: false,
        };

        this.changesMade = this.changesMade.bind(this);
        this.saveChanges = this.saveChanges.bind(this);
    }

    saveChanges() {
        if ( '' === this.state.ingredient.name.trim() ) {
            alert( __wprm( 'A name is required for this saved nutrition ingredient.' ) );
        } else {
            this.setState({
                savingChanges: true,
            }, () => {
                Api.saveCustomIngredient(this.state.ingredient.id, this.state.ingredient.amount, this.state.ingredient.unit, this.state.ingredient.name, this.state.ingredient.facts ).then(() => {
                    this.setState({
                        originalIngredient: JSON.parse( JSON.stringify( this.state.ingredient ) ),
                        savingChanges: false,
                    },() => {
                        if ( 'function' === typeof this.props.args.saveCallback ) {
                            this.props.args.saveCallback( this.state.ingredient );
                        }
                        this.props.maybeCloseModal();
                    });
                });
            })
        }
    }

    allowCloseModal() {
        return ! this.state.savingChanges && ( ! this.changesMade() || confirm( __wprm( 'Are you sure you want to close without saving changes?' ) ) );
    }

    changesMade() {
        return JSON.stringify( this.state.ingredient ) !== JSON.stringify( this.state.originalIngredient );
    }

    render() {
        return (
            <Fragment>
                <Header
                    onCloseModal={ this.props.maybeCloseModal }
                >
                    {
                        this.state.loadingIngredient
                        ?
                        __wprm( 'Loading Ingredient...' )
                        :
                        <Fragment>
                            {
                                this.state.ingredient.id
                                ?
                                
                                `${ __wprm( 'Editing Nutrition Ingredient' ) } #${this.state.ingredient.id}${this.state.ingredient.name ? ` - ${this.state.ingredient.name}` : ''}`
                                :
                                `${ __wprm( 'Creating new Nutrition Ingredient' ) }${this.state.ingredient.name ? ` - ${this.state.ingredient.name}` : ''}`
                            }
                        </Fragment>
                    }
                </Header>
                <div className="wprm-admin-modal-nutrition-container">
                    {
                        this.state.loadingIngredient
                        ?
                        <Loader />
                        :
                        <Fragment>
                            <div className="wprm-admin-modal-nutrition-custom-ingredient">
                                <FieldText
                                    type="number"
                                    placeholder={ __wprm( 'Amount' ) }
                                    value={ this.state.ingredient.amount }
                                    onChange={ (amount) => {
                                        this.setState({
                                            ingredient: {
                                                ...this.state.ingredient,
                                                amount,
                                            }
                                        });
                                    }}
                                />
                                <FieldText
                                    placeholder={ __wprm( 'Unit' ) }
                                    value={ this.state.ingredient.unit }
                                    onChange={ (unit) => {
                                        this.setState({
                                            ingredient: {
                                                ...this.state.ingredient,
                                                unit,
                                            }
                                        });
                                    }}
                                />
                                <FieldText
                                    placeholder={ __wprm( 'Name (required)' ) }
                                    value={ this.state.ingredient.name }
                                    onChange={ (name) => {
                                        this.setState({
                                            ingredient: {
                                                ...this.state.ingredient,
                                                name,
                                            }
                                        });
                                    }}
                                />
                            </div>
                            <Nutrients
                                id="modal"
                                facts={ this.state.ingredient.facts }
                                onChange={ (nutrient, value) => {
                                    let facts = { ...this.state.ingredient.facts };
                                    facts[ nutrient ] = value;

                                    this.setState({
                                        ingredient: {
                                            ...this.state.ingredient,
                                            facts,
                                        }
                                    });
                                }}
                            />
                        </Fragment>
                    }
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