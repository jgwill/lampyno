import React, { Component, Fragment } from 'react';

import '../../../../css/admin/modal/recipe/nutrition-calculation.scss';

import Header from '../../general/Header';
import Footer from '../../general/Footer';

import Api from './Api';
import StepSource from './StepSource';
import StepMatch from './StepMatch';
import StepCustom from './StepCustom';
import StepSummary from './StepSummary';

import  { parseQuantity, formatQuantity } from '../../../../../../wp-recipe-maker-premium/assets/js/shared/quantities';
import { __wprm } from '../../../shared/Translations';
import Loader from '../../../shared/Loader';

export default class NutritionCalculation extends Component {
    constructor(props) {
        super(props);

        // Remove ingredient groups and ingredients without a name
        let ingredients = props.ingredients.filter( ( ingredient ) => ingredient.type === 'ingredient' && ingredient.name );

        // Parse quantities.
        ingredients = ingredients.map( ( ingredient ) => {
            // Strip HTML and shortcodes from unit.
            let unit = ingredient.unit;
            unit = unit.replace( /(<([^>]+)>)/ig, '' );
	        unit = unit.replace( /(\[([^\]]+)\])/ig, '' );

            ingredient.nutrition = {
                amount: parseQuantity( ingredient.amount ),
                unit,
            }

            return ingredient;
        });

        Api.getMatches(ingredients).then((data) => {
            if ( data ) {
                this.setState({
                    ingredients: data.ingredients,
                    calculating: false,
                });
            } else {
                this.setState({
                    calculating: false,
                });
            }
        });

        this.state = {
            step: 'source',
            stepArgs: {},
            ingredients: [],
            apiIngredients: [],
            customIngredients: [],
            calculating: true,
        };

        // Bind functions.
        this.onStepChange = this.onStepChange.bind(this);
        this.onIngredientChange = this.onIngredientChange.bind(this);
    }

    componentDidUpdate( prevProps, prevState ) {
        // Get facts for the API ingredients and check if there are any custom ingredients to do.
        if ( 'source' === prevState.step && 'summary' === this.state.step ) {
            const apiIngredients = this.state.ingredients.filter( (ingredient) => 'api' === ingredient.nutrition.source );
            const customIngredients = this.state.ingredients.filter( (ingredient) => 'custom' === ingredient.nutrition.source );

            let calculating = false;
            let step = 'summary';

            if ( 0 < apiIngredients.length ) {
                calculating = true;

                Api.getApiFacts(apiIngredients).then((data) => {
                    if ( data ) {
                        this.setState({
                            calculating: false,
                            apiIngredients: data.ingredients,
                        });
                    } else {
                        this.setState({
                            calculating: false,
                        });
                    }
                });
            }

            if ( 0 < customIngredients.length ) {
                step = 'custom';
            }

            this.setState({
                calculating,
                customIngredients,
                step,
            });
        }

        // Check if there are any custom ingredients left to do.
        if ( 'custom' === this.state.step ) {
            const customIngredientsTodo = this.state.customIngredients.filter( (ingredient) => ! ingredient.nutrition.hasOwnProperty('facts') );

            // No more custom ingredients left, go to summary.
            if ( 0 === customIngredientsTodo.length ) {
                this.setState({
                    step: 'summary',
                });
            }
        }
    }

    onStepChange(step, stepArgs = {} ) {
        this.setState({
            step,
            stepArgs,
        });
    }

    onIngredientChange(index, nutrition) {
        let ingredients = JSON.parse( JSON.stringify( this.state.ingredients ) );

        ingredients[index].nutrition = {
            ...ingredients[index].nutrition,
            ...nutrition,
        }

        this.setState({
            ingredients,
        });
    }

    getRecipeFacts() {
        let nutrients = JSON.parse( JSON.stringify( wprm_admin_modal.nutrition ) );
        delete nutrients.serving_size;

        let facts = {};

        const servings = this.props.servings && parseInt( this.props.servings ) > 0 ? parseInt( this.props.servings ) : 1;

        for ( let field in nutrients ) {
            let value = false;

            for ( let ingredient of this.state.apiIngredients.concat( this.state.customIngredients ) ) {
                if ( ingredient.nutrition.factsUsed && ingredient.nutrition.facts && ingredient.nutrition.facts[ field ] ) {
                    if ( value ) {
                        value += parseFloat( ingredient.nutrition.facts[ field ] );
                    } else {
                        value = parseFloat( ingredient.nutrition.facts[ field ] );
                    }
                }
            }

            if ( value ) {
                value = value / servings;

                // TODO setting to change default rounding?
                value = formatQuantity( value, 0 );
            }

            facts[ field ] = value;
        }

        return facts;
    }

    render() {
        let step = null;
        switch ( this.state.step ) {
            case 'source':
                step = (
                    <StepSource
                        ingredients={ this.state.ingredients }
                        onIngredientChange={ this.onIngredientChange }
                        onStepChange={ this.onStepChange }
                    />
                );
                break;
            case 'match':
                const ingredientIndex = this.state.stepArgs.index;

                step = (
                    <StepMatch
                        ingredient={ this.state.ingredients[ ingredientIndex ] }
                        onMatchChange={ (match) => {
                            this.onIngredientChange( ingredientIndex, {
                                ...match,
                            });
                            this.onStepChange('source');
                        }}
                    />
                );
                break;
            case 'custom':
                // Get the first one that doesn't have nutrition facts.
                const todoIndex = this.state.customIngredients.findIndex( (ingredient) => ! ingredient.nutrition.hasOwnProperty('facts') );

                step = (
                    <StepCustom
                        index={ todoIndex }
                        ingredient={ this.state.customIngredients[ todoIndex ] }
                        onFactsChange={ (facts) => {
                            let customIngredients = JSON.parse( JSON.stringify( this.state.customIngredients ) );
                            customIngredients[ todoIndex ].nutrition.facts = facts;

                            this.setState({
                                customIngredients,
                            });
                        }}
                    />
                );
                break;
            case 'summary':
                step = (
                    <StepSummary
                        servings={ this.props.servings }
                        recipeFactsPreview={ this.getRecipeFacts() }
                        apiIngredients={ this.state.apiIngredients }
                        customIngredients={ this.state.customIngredients }
                        onApiIngredientsChange={ (index, nutrition) => {
                            let ingredients = JSON.parse( JSON.stringify( this.state.apiIngredients ) );

                            ingredients[index].nutrition = {
                                ...ingredients[index].nutrition,
                                ...nutrition,
                            }

                            this.setState({
                                apiIngredients: ingredients,
                            });
                        }}
                        onCustomIngredientsChange={ (index, nutrition) => {
                            let ingredients = JSON.parse( JSON.stringify( this.state.customIngredients ) );

                            ingredients[index].nutrition = {
                                ...ingredients[index].nutrition,
                                ...nutrition,
                            }

                            this.setState({
                                customIngredients: ingredients,
                            });
                        }}
                    />
                );
                break;
        }

        let buttons = null;

        const backButton = (
            <button
                className="button"
                onClick={() => {
                    this.onStepChange( 'source' );
                }}
            >
                { __wprm( 'Go Back' ) }
            </button>
        );

        switch ( this.state.step ) {
            case 'source':
                buttons = (
                    <Fragment>
                        <button
                            className="button"
                            onClick={ this.props.onCancel }
                        >
                            { __wprm( 'Cancel Calculation' ) }
                        </button>
                        <button
                            className="button button-primary"
                            onClick={() => {
                                this.onStepChange( 'summary' );
                            }}
                        >
                            { __wprm( 'Go to Next Step' ) }
                        </button>
                    </Fragment>
                );
                break;
            case 'match':
                buttons = (
                    <Fragment>
                        { backButton }
                    </Fragment>
                );
                break;
            case 'summary':
                buttons = (
                    <Fragment>
                        { backButton }
                        <button
                            className="button button-primary"
                            onClick={() => {
                                const calculated = this.getRecipeFacts();
                                this.props.onNutritionChange( calculated );
                            }}
                        >
                            { __wprm( 'Use These Values' ) }
                        </button>
                    </Fragment>
                );
                break;
        }

        return (
            <Fragment>
                <Header
                    onCloseModal={ this.props.onCloseModal }
                >
                    {
                        this.props.name
                        ?
                        `${this.props.name} - ${ __wprm( 'Nutrition Calculation' ) }`
                        :
                        `${ __wprm( 'Recipe' ) } - ${ __wprm( 'Nutrition Calculation' ) }`
                    }
                </Header>
                <div className="wprm-admin-modal-recipe-nutrition-calculation">
                    {
                        this.state.calculating
                        && 'custom' !== this.state.step
                        ?
                        <Loader />
                        :
                        step
                    }
                </div>
                <Footer
                    savingChanges={ this.state.calculating && 'custom' !== this.state.step }
                >
                    { buttons }
                </Footer>
            </Fragment>
        );
    }
}