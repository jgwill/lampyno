import React, { Component } from 'react';

import '../../../../../css/admin/modal/recipe/fields/ingredients.scss';

import EditMode from '../../../general/EditMode';
import { __wprm } from 'Shared/Translations';
const { hooks } = WPRecipeMaker.shared;

import IngredientsEdit from './IngredientsEdit';
import IngredientsPreview from './IngredientsPreview';

export default class RecipeIngredients extends Component {
    constructor(props) {
        super(props);

        this.state = {
            mode: 'edit',
        }
    }

    shouldComponentUpdate(nextProps, nextState) {
        return this.state.mode !== nextState.mode
                || this.props.type !== nextProps.type
                || this.props.linkType !== nextProps.linkType
                || JSON.stringify( this.props.ingredients ) !== JSON.stringify( nextProps.ingredients );
    }
  
    render() {
        let modes = {
            edit: {
                label: 'howto' === this.props.type ? __wprm( 'Edit Materials' ) : __wprm( 'Edit Ingredients' ),
                block: IngredientsEdit,
            },
            'ingredient-links': {
                label: 'howto' === this.props.type ? __wprm( 'Material Links' ) : __wprm( 'Ingredient Links' ),
                block: () => ( <p>{ __wprm( 'This feature is only available in' ) } <a href="https://bootstrapped.ventures/wp-recipe-maker/get-the-plugin/" target="_blank">WP Recipe Maker Premium</a>.</p> ),
            },
            'unit-conversion': {
                label: __wprm( 'Unit Conversion' ),
                block: () => ( <p>{ __wprm( 'This feature is only available in' ) } <a href="https://bootstrapped.ventures/wp-recipe-maker/get-the-plugin/" target="_blank">WP Recipe Maker Pro Bundle</a>.</p> ),
            },
        };

        const allModes = hooks.applyFilters( 'modalRecipeIngredients', modes );
        const Content = allModes.hasOwnProperty(this.state.mode) ? allModes[this.state.mode].block : false;

        if ( ! Content ) {
            return null;
        }

        let mode = null;
        switch ( this.state.mode ) {
            case 'unit-conversion':
                mode = (
                    <Content
                        ingredients={ this.props.ingredients }
                        onIngredientsChange={ ( ingredients_flat ) => {                            
                            this.props.onRecipeChange({
                                ingredients_flat,
                            });
                        }}
                    />
                );
                break;
            case 'ingredient-links':
                mode = (
                    <Content
                        ingredients={ this.props.ingredients }
                        onIngredientsChange={ ( ingredients_flat ) => {                            
                            this.props.onRecipeChange({
                                ingredients_flat,
                            });
                        }}
                        type={ this.props.linkType }
                        onTypeChange={ ( ingredient_links_type ) => {
                            this.props.onRecipeChange({
                                ingredient_links_type,
                            });
                        } }
                        onModeChange={ this.props.onModeChange }
                    />
                );
                break;
            case 'preview':
                mode = (
                    <Content
                        ingredients={ this.props.ingredients }
                    />
                );
                break;
            default:
                mode = (
                    <Content
                        type={ this.props.type }
                        ingredients={ this.props.ingredients }
                        onRecipeChange={ this.props.onRecipeChange }
                    />
                );
        }

        return (
            <div className="wprm-admin-modal-field-ingredient-container">
                <EditMode
                    modes={ modes }
                    mode={ this.state.mode }
                    onModeChange={(mode) => {
                        this.setState({
                            mode,
                        })
                    }}
                />
                { mode }
            </div>
        );
    }
}
