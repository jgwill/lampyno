import React, { Component, Fragment } from 'react';

import FieldText from '../../fields/FieldText';
import  { formatQuantity } from '../../../../../../wp-recipe-maker-premium/assets/js/shared/quantities';
import { __wprm } from '../../../shared/Translations';

import Api from './Api';
import Nutrients from './Nutrients';
import StepCustomIngredient from './StepCustomIngredient';

export default class StepCustom extends Component {
    constructor(props) {
        super(props);

        this.state = {
            amount: '',
            unit: '',
            name: '',
            facts: {},
            savedIngredient: false,
            savedAmount: false,
        }

        // Bind functions.
        this.initCustomIngredient = this.initCustomIngredient.bind(this);
        this.getSavedFacts = this.getSavedFacts.bind(this);
        this.useCustomFacts = this.useCustomFacts.bind(this);
        this.useSavedFacts = this.useSavedFacts.bind(this);
        this.useFacts = this.useFacts.bind(this);
    }

    componentDidMount() {
        this.initCustomIngredient();
    }

    componentDidUpdate( prevProps ) {
        if ( this.props.index !== prevProps.index ) {
            this.initCustomIngredient();
        }
    }

    initCustomIngredient() {
        const { ingredient } = this.props;
        const amount = ingredient && ingredient.nutrition ? ingredient.nutrition.amount : '';
        const unit = ingredient && ingredient.nutrition ? ingredient.nutrition.unit : '';
        const name = ingredient ? ingredient.name : '';

        this.setState({
            amount,
            unit,
            name,
            facts: {},
            savedIngredient: false,
            savedAmount: false,
        });
    }

    getSavedFacts() {
        let facts = {};
    
        if ( this.state.savedIngredient && this.state.savedIngredient.nutrition ) {
            // Get modifier.
            let modifier = 1.0;

            if ( this.state.savedAmount && parseFloat( this.state.savedAmount ) ) {
                const originalAmount = this.state.savedIngredient.nutrition.amount ? parseFloat( this.state.savedIngredient.nutrition.amount ) : 1.0;
                modifier = parseFloat( this.state.savedAmount ) / originalAmount;
            }

            // Loop over nutrients.
            Object.keys( this.state.savedIngredient.nutrition.nutrients ).map((nutrient, index) => {
                const value = this.state.savedIngredient.nutrition.nutrients[ nutrient ];

                if ( value ) {
                    facts[ nutrient ] = formatQuantity( modifier * value, 1 );
                }
            });
        }

        return facts;
    }

    useCustomFacts( save = false ) {
        if ( save ) {
            if ( '' === this.state.name.trim() ) {
                alert( __wprm( 'A name is required for this saved nutrition ingredient.' ) );
            } else {
                Api.saveCustomIngredient( 0, this.state.amount, this.state.unit, this.state.name, this.state.facts );
                this.useFacts( this.state.facts );
            }
        } else {
            this.useFacts( this.state.facts );
        }
    }

    useSavedFacts() {
        this.useFacts( this.getSavedFacts() );
    }

    useFacts(facts) {
        this.props.onFactsChange( facts );
    }

    render() {
        const { ingredient } = this.props;

        if ( ! ingredient ) {
            return null;
        }

        let ingredientName = ingredient.nutrition && ingredient.nutrition.amount ? `${ingredient.nutrition.amount} ` : '';
        ingredientName += ingredient.nutrition && ingredient.nutrition.unit ? `${ingredient.nutrition.unit} ` : '';
        ingredientName += ingredient.name ? ingredient.name : '';
    
        return (
            <div className="wprm-admin-modal-recipe-nutrition-calculation-custom">
                <h2>{ __wprm( 'Save a new Custom Ingredient' ) }</h2>                
                <div className="wprm-admin-modal-recipe-nutrition-calculation-custom-ingredient">
                    <FieldText
                        type="number"
                        placeholder={ __wprm( 'Amount' ) }
                        value={ this.state.amount }
                        onChange={ (amount) => {
                            this.setState({
                                amount,
                            });
                        }}
                    />
                    <FieldText
                        placeholder={ __wprm( 'Unit' ) }
                        value={ this.state.unit }
                        onChange={ (unit) => {
                            this.setState({
                                unit,
                            });
                        }}
                    />
                    <FieldText
                        placeholder={ __wprm( 'Name (required)' ) }
                        value={ this.state.name }
                        onChange={ (name) => {
                            this.setState({
                                name
                            });
                        }}
                    />
                </div>
                <Nutrients
                    id="custom-ingredient"
                    facts={ this.state.facts }
                    onChange={ (nutrient, value) => {
                        let facts = { ...this.state.facts };
                        facts[ nutrient ] = value;

                        this.setState({
                            facts,
                        });
                    }}
                />
                <button
                    className="button button-primary"
                    onClick={() => {
                        this.useCustomFacts( true );
                    }}
                >{ __wprm( 'Save for Later & Use' ) }</button>
                <button
                    className="button button-primary"
                    onClick={() => {
                        this.useCustomFacts( false );
                    }}
                >{ __wprm( 'Use' ) }</button>
                <h2>{ __wprm( 'Select a saved ingredient' ) }</h2>
                <StepCustomIngredient
                    value={false}
                    onValueChange={(savedIngredient) => {
                        // Change saved amount if same unit.
                        let savedAmount = savedIngredient.nutrition.amount;

                        if ( savedIngredient.nutrition && ingredient.nutrition && savedIngredient.nutrition.unit === ingredient.nutrition.unit ) {
                            savedAmount = ingredient.nutrition.amount;
                        }

                        this.setState({
                            savedIngredient,
                            savedAmount,
                        });
                    }}
                    defaultSearch={ this.props.ingredient.name }
                    key={ this.props.ingredient.id }
                />
                {
                    this.state.savedIngredient
                    ?
                    <Fragment>
                        <div className="wprm-admin-modal-recipe-nutrition-calculation-custom-saved-ingredient">
                            <strong>{ __wprm( 'Match this equation to get the correct amounts:' ) }</strong>
                            <div className="wprm-admin-modal-recipe-nutrition-calculation-custom-saved-ingredient-match">
                                { ingredientName } = <FieldText
                                    type="number"
                                    value={ this.state.savedAmount }
                                    onChange={ (savedAmount) => {
                                        this.setState({
                                            savedAmount,
                                        });
                                    }}
                                /> { this.state.savedIngredient.nutrition.unit } { this.state.savedIngredient.text }
                            </div>
                        </div>
                        <Nutrients
                            id="saved-ingredient"
                            facts={ this.getSavedFacts() }
                        />
                    </Fragment>
                    :
                    null
                }
                <button
                    className="button button-primary"
                    onClick={this.useSavedFacts}
                    disabled={ ! this.state.savedIngredient }
                >{ __wprm( 'Use' ) }</button>
            </div>
        )
    }
}
