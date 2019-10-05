import React, { Fragment } from 'react';
import { Element, Link } from 'react-scroll';
import CopyToClipboard from 'react-copy-to-clipboard';

import Header from '../../general/Header';
import Footer from '../../general/Footer';

import Loader from 'Shared/Loader';
import { __wprm } from 'Shared/Translations';

import FieldGroup from '../../fields/FieldGroup';

import RecipeImport from './RecipeImport';
import RecipeMedia from './RecipeMedia';
import RecipeGeneral from './RecipeGeneral';
import RecipeTimes from './RecipeTimes';
import RecipeCategories from './RecipeCategories';
import RecipeIngredients from './RecipeIngredients';
import RecipeEquipment from './RecipeEquipment';
import RecipeInstructions from './RecipeInstructions';
import RecipeNutrition from './RecipeNutrition';
import RecipeCustomFields from './RecipeCustomFields';
import RecipeNotes from './RecipeNotes';
 
const EditRecipe = (props) => {
    let structure = [
        {
            id: 'import', name: __wprm( 'Import' ),
            elem: (
                <RecipeImport
                    onModeChange={ props.onModeChange }
                    onRecipeChange={ props.onRecipeChange }
                />
            )
        },
        {
            id: 'media', name: __wprm( 'Media' ),
            elem: (
                <RecipeMedia
                    image={{
                        id: props.recipe.image_id,
                        url: props.recipe.image_url,
                    }}
                    pinImage={{
                        id: props.recipe.pin_image_id,
                        url: props.recipe.pin_image_url,
                    }}
                    video={{
                        id: props.recipe.video_id,
                        thumb: props.recipe.video_thumb_url,
                        embed: props.recipe.video_embed,
                    }}
                    onRecipeChange={ props.onRecipeChange }
                />
            )
        },
        {
            id: 'general', name: __wprm( 'General' ),
            elem: (
                <RecipeGeneral
                    type={ props.recipe.type }
                    name={ props.recipe.name }
                    summary={ props.recipe.summary }
                    author={{
                        display: props.recipe.author_display,
                        name: props.recipe.author_name,
                        link: props.recipe.author_link,
                    }}
                    servings={{
                        amount: props.recipe.servings,
                        unit: props.recipe.servings_unit,
                    }}
                    cost={ props.recipe.cost }
                    onRecipeChange={ props.onRecipeChange }
                />
            )
        },
        {
            id: 'times', name: __wprm( 'Times' ),
            elem: (
                <RecipeTimes
                    type={ props.recipe.type }
                    prep={ {
                        time: props.recipe.prep_time,
                        zero: props.recipe.prep_time_zero,
                    } }
                    cook={ {
                        time: props.recipe.cook_time,
                        zero: props.recipe.cook_time_zero,
                    } }
                    custom={ {
                        time: props.recipe.custom_time,
                        zero: props.recipe.custom_time_zero,
                    } }
                    customLabel={ props.recipe.custom_time_label }
                    total={ {
                        time: props.recipe.total_time,
                        zero: false,
                    } }
                    onRecipeChange={ props.onRecipeChange }
                />
            )
        },
        {
            id: 'categories', name: __wprm( 'Categories' ),
            elem: (
                <RecipeCategories
                    tags={ props.recipe.tags }
                    onRecipeChange={ props.onRecipeChange }
                />
            )
        },
        {
            id: 'equipment', name: __wprm( 'Equipment' ),
            elem: (
                <RecipeEquipment
                    type={ props.recipe.type }
                    equipment={ props.recipe.equipment }
                    onRecipeChange={ props.onRecipeChange }
                />
            )
        },
        {
            id: 'ingredients',
            name: 'howto' === props.recipe.type ? __wprm( 'Materials' ) : __wprm( 'Ingredients' ),
            elem: (
                <RecipeIngredients
                    type={ props.recipe.type }
                    ingredients={ props.recipe.ingredients_flat }
                    linkType={ props.recipe.ingredient_links_type }
                    onRecipeChange={ props.onRecipeChange }
                    onModeChange={ props.onModeChange }
                />
            )
        },
        {
            id: 'instructions', name: __wprm( 'Instructions' ),
            elem: (
                <RecipeInstructions
                    instructions={ props.recipe.instructions_flat }
                    onRecipeChange={ props.onRecipeChange }
                />
            )
        }
    ];

    // Only show nutrition for food recipes.
    if ( 'howto' !== props.recipe.type ) {
        structure.push({
            id: 'nutrition', name: __wprm( 'Nutrition' ),
            elem: (
                <RecipeNutrition
                    nutrition={ props.recipe.nutrition }
                    servings={{
                        amount: props.recipe.servings,
                        unit: props.recipe.servings_unit,
                    }}
                    onRecipeChange={ props.onRecipeChange }
                    onModeChange={ props.onModeChange }
                />
            )
        });
    }

    // Only show custom fields when available and at least 1 is set.
    if ( wprm_admin_modal.custom_fields && wprm_admin_modal.custom_fields.fields && 0 < Object.keys( wprm_admin_modal.custom_fields.fields ).length ) {
        structure.push({
            id: 'custom-fields', name: __wprm( 'Custom Fields' ),
            elem: (
                <RecipeCustomFields
                    fields={ props.recipe.custom_fields }
                    onFieldChange={( field, value ) => {
                        let newFields = Object.assign({}, JSON.parse( JSON.stringify( props.recipe.custom_fields ) ) );
                        newFields[ field ] = value;

                        props.onRecipeChange({
                            custom_fields: newFields,
                        });
                    }}
                />
            )
        });
    }

    structure.push({
        id: 'notes', name: __wprm( 'Notes' ),
        elem: (
            <RecipeNotes
                notes={ props.recipe.notes }
                onRecipeChange={ props.onRecipeChange }
            />
        )
    });

    return (
        <Fragment>
            <Header
                onCloseModal={ props.onCloseModal }
            >
                {
                    props.loadingRecipe
                    ?
                    __wprm( 'Loading Recipe...' )
                    :
                    <Fragment>
                        {
                            props.recipe.id
                            ?
                            
                            `${ __wprm( 'Editing Recipe' ) } #${props.recipe.id}${props.recipe.name ? ` - ${props.recipe.name}` : ''}`
                            :
                            `${ __wprm( 'Creating new Recipe' ) }${props.recipe.name ? ` - ${props.recipe.name}` : ''}`
                        }
                    </Fragment>
                }
            </Header>
            <div className="wprm-admin-modal-recipe-quicklinks">
                {
                    structure.map((group, index) => (
                        <Link
                            to={ `wprm-admin-modal-fields-group-${ group.id }` }
                            containerId="wprm-admin-modal-recipe-content"
                            className="wprm-admin-modal-recipe-quicklink"
                            activeClass="active"
                            spy={true}
                            offset={-10}
                            smooth={true}
                            duration={400}
                            key={index}
                        >
                            { group.name }
                        </Link>
                    ))
                }
            </div>
            <Element className="wprm-admin-modal-content" id="wprm-admin-modal-recipe-content">
                {
                    props.loadingRecipe
                    ?
                    <Loader/>
                    :
                    <form className="wprm-admin-modal-recipe-fields">
                        {
                            structure.map((group, index) => (
                                <FieldGroup
                                    header={ group.name }
                                    id={ group.id }
                                    key={ 100 * props.forceRerender + index }
                                >
                                    { group.elem }
                                </FieldGroup>
                            ))
                        }
                    </form>
                }
            </Element>
            <div id="wprm-admin-modal-toolbar-container"></div>
            <Footer
                savingChanges={ props.savingChanges }
            >
                {
                    'failed' === props.saveResult
                    ?
                    <CopyToClipboard
                        text={JSON.stringify( props.recipe )}
                        onCopy={(text, result) => {
                            if ( result ) {
                                alert( __wprm( 'The recipe has been copied and can be used in the "Import from JSON" feature.' ) );
                            } else {
                                alert( __wprm( 'Something went wrong. Please contact support.' ) );
                            }
                        }}
                    >
                        <a href="#" onClick={ (e) => { e.preventDefault(); } }>
                            { __wprm( 'Copy JSON to Clipboard' ) }
                        </a>
                    </CopyToClipboard>
                    :
                    null
                }
                {
                    'ok' === props.saveResult
                    ?
                    <span>{ __wprm( 'Saved successfully' ) }</span>
                    :
                    null
                }
                <button
                    className="button button-primary"
                    onClick={ () => { props.saveRecipe( false ) } }
                    disabled={ ! props.changesMade }
                >
                    { __wprm( 'Save' ) }
                </button>
                <button
                    className="button button-primary"
                    onClick={ () => {
                        if ( props.changesMade ) {
                            props.saveRecipe( true );
                        } else {
                            props.onCloseModal();
                        }
                    } }
                >
                    { props.changesMade ? __wprm( 'Save & Close' ) : __wprm( 'Close' ) }
                </button>
            </Footer>
        </Fragment>
    );
}
export default EditRecipe;