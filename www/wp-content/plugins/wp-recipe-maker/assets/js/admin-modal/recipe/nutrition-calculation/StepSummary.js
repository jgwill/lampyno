import React, { Component, Fragment } from 'react';

import { formatQuantity } from '../../../../../../wp-recipe-maker-premium/assets/js/shared/quantities';
import { __wprm } from '../../../shared/Translations';

import Nutrients from './Nutrients';

class IngredientList extends Component {
    constructor(props) {
        super(props);

        this.state = {
            editingIndex: false,
        }
    }

    render() {
        return (
            <div className="wprm-admin-modal-recipe-nutrition-calculation-summary-ingredients">
                { this.props.ingredients.map( (ingredient, index) => {
                    let ingredientName = ingredient.amount ? `${ingredient.amount} ` : '';
                    ingredientName += ingredient.unit ? `${ingredient.unit} ` : '';
                    ingredientName += ingredient.name ? ingredient.name : '';

                    const hasMatch = ! ! ingredient.nutrition.match;

                    // Get name of match with nutrition summary.
                    let matchName = hasMatch && ingredient.nutrition.match.name ? ingredient.nutrition.match.name : __wprm( 'n/a' );

                    let nutritionSummary = [];
                    if ( ingredient.nutrition.facts ) {
                        const summaryNutrients = ['calories', 'carbohydrates', 'fat', 'protein'];

                        for ( let nutrient of summaryNutrients ) {
                            if ( ingredient.nutrition.facts[ nutrient ] ) {
                                const value = formatQuantity( ingredient.nutrition.facts[ nutrient ], 0 );
                                nutritionSummary.push( `${ wprm_admin_modal.nutrition[ nutrient ].label }: ${ value }${ wprm_admin_modal.nutrition[ nutrient ].unit }` );
                            }
                        }
                    }

                    if ( 0 < nutritionSummary.length ) {
                        matchName += ` - ${ nutritionSummary.join(' | ') }`;
                    }

                    return (
                        <div className="wprm-admin-modal-recipe-nutrition-calculation-summary-ingredient-container" key={index}>
                            <div className={`wprm-admin-modal-recipe-nutrition-calculation-summary-ingredient${ ingredient.nutrition.factsUsed ? '' : ' wprm-admin-modal-recipe-nutrition-calculation-summary-ingredient-not-used' }`}>
                                <div className="wprm-admin-modal-recipe-nutrition-calculation-summary-ingredient-select">
                                    <input
                                        id={ `wprm-admin-modal-recipe-nutrition-calculation-summary-ingredient-${index}` }
                                        type="checkbox"
                                        checked={ ingredient.nutrition.factsUsed }
                                        onChange={(e) => {
                                            this.props.onChangeNutrition( index, {
                                                factsUsed: e.target.checked,
                                            })
                                        }}
                                    />
                                    <label
                                        htmlFor={ `wprm-admin-modal-recipe-nutrition-calculation-summary-ingredient-${index}` }
                                    >
                                        { ingredientName }
                                    </label>
                                </div>
                                <a
                                    href="#"
                                    onClick={(e) => {
                                        e.preventDefault();

                                        this.setState({
                                            editingIndex: index === this.state.editingIndex ? false : index,
                                        });
                                    }}
                                    className={ hasMatch ? 'wprm-admin-modal-recipe-nutrition-calculation-summary-ingredient-match' : 'wprm-admin-modal-recipe-nutrition-calculation-summary-ingredient-no-match' }
                                    style={ index === this.state.editingIndex ? { fontWeight: 'bold' } : null }
                                >
                                    { matchName }
                                </a>
                            </div>
                            {
                                index === this.state.editingIndex
                                &&
                                <Nutrients
                                    id={ `${this.props.id}-ingredients` }
                                    facts={ ingredient.nutrition.facts }
                                    onChange={ (nutrient, value) => {
                                        let facts = { ...ingredient.nutrition.facts };
                                        facts[ nutrient ] = value;

                                        this.props.onChangeNutrition( index, { facts } );
                                    }}
                                />
                            }
                        </div>
                    )
                 } ) }
            </div>
        );
    }
}

const StepSummary = (props) => {
    return (
        <div className="wprm-admin-modal-recipe-nutrition-calculation-summary">
            {
                props.servings
                ?
                <p>{ __wprm( 'Values of all the checked ingredients will be added together and' ) } <strong>{ __wprm( 'divided by' ) } { props.servings }</strong>, { __wprm( 'the number of servings for this recipe.' ) }</p>
                :
                <p>{__wprm( 'Values of all the checked ingredients will be added together.' ) }</p>
            }
            {
                0 < props.apiIngredients.length
                &&
                <Fragment>
                    <h2>{ __wprm( 'API Ingredients' ) }</h2>
                    <IngredientList
                        id="api"
                        ingredients={ props.apiIngredients }
                        onChangeNutrition={props.onApiIngredientsChange}
                    />
                </Fragment>
            }
            {
                0 < props.customIngredients.length
                &&
                <Fragment>
                    <h2>{ __wprm( 'Custom Ingredients' ) }</h2>
                    <IngredientList
                        id="custom"
                        ingredients={ props.customIngredients }
                        onChangeNutrition={props.onCustomIngredientsChange}
                    />
                </Fragment>
            }
            <h2>{ __wprm( 'Recipe Nutrition Facts Preview' ) }</h2>
            <p>{ __wprm( 'Changes to these values can be made after confirming with the blue button.' ) }</p>
            <Nutrients
                id="summary-preview"
                facts={ props.recipeFactsPreview }
            />
        </div>
    );
}
export default StepSummary;