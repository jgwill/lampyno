import React, { Fragment } from 'react';

import FieldDropdown from '../fields/FieldDropdown';
import FieldRadio from '../fields/FieldRadio';
import FieldCategory from '../fields/FieldCategory';
import FieldText from '../fields/FieldText';
import { __wprm } from 'Shared/Translations';
 
const ActionsRecipe = (props) => {
    const selectedAction = props.action ? props.action.type : false;

    let defaultTaxonomy = false;
    let taxonomyOptions = [];
    Object.keys(wprm_admin_manage.taxonomies).map((taxonomy, index) => {
        const key = taxonomy.substr(5);

        if ( ! defaultTaxonomy ) {
            defaultTaxonomy = key;
        }

        taxonomyOptions.push({
            value: key,
            label: wprm_admin_manage.taxonomies[ taxonomy ].name,
        });
    });

    // Set action options.
    let actionOptions = [];
    if ( 0 < taxonomyOptions.length ) {
        actionOptions.push(
            { value: 'add-terms', label: __wprm( 'Add Terms' ), default: { taxonomy: defaultTaxonomy, terms: [] } },
            { value: 'remove-terms', label: __wprm( 'Remove Terms' ), default: { taxonomy: defaultTaxonomy, terms: [] } },
        );
    }
    actionOptions.push(
        { value: 'change-type', label: __wprm( 'Change Recipe Type' ), default: 'food' },
        { value: 'change-author', label: __wprm( 'Change Display Author' ), default: { author: 'default', author_name: '', author_link: '' } },
        { value: 'export', label: __wprm( 'Export Recipes' ), default: false, required: 'premium' },
        { value: 'delete', label: __wprm( 'Delete Recipes' ), default: false },
    )

    return (
        <form>
            <div className="wprm-admin-modal-bulk-edit-label">{ __wprm( 'Select an action to perform:' ) }</div>
            <div className="wprm-admin-modal-bulk-edit-actions">
                {
                    actionOptions.map((option) => (
                        <div className="wprm-admin-modal-bulk-edit-action" key={option.value}>
                            <input
                                type="radio"
                                value={option.value}
                                name={`wprm-admin-radio-bulk-edit-action`}
                                id={`wprm-admin-radio-bulk-edit-action-${option.value}`}
                                checked={selectedAction === option.value}
                                onChange={() => {
                                    let newAction = {
                                        type: option.value,
                                        options: option.default,
                                    }

                                    if ( option.hasOwnProperty( 'required' ) ) {
                                        newAction.required = option.required;
                                    }

                                    props.onActionChange(newAction);
                                }}
                            /><label htmlFor={`wprm-admin-radio-bulk-edit-action-${option.value}`}>{ option.label }</label>
                        </div>
                    ))
                }
            </div>
            {
                selectedAction && false !== props.action.options
                &&
                <Fragment>
                    <div className="wprm-admin-modal-bulk-edit-label">{ __wprm( 'Action options:' ) }</div>
                    <div className="wprm-admin-modal-bulk-edit-options">
                        {
                            'change-type' === selectedAction
                            &&
                            <FieldRadio
                                id="type"
                                options={ [
                                    { value: 'food', label: __wprm( 'Food Recipe' ) },
                                    { value: 'howto', label: __wprm( 'How-to Instructions' ) },
                                    { value: 'other', label: __wprm( 'Other (no metadata)' ) },
                                ] }
                                value={props.action.options}
                                onChange={(value) => {
                                    const newAction = {
                                        ...props.action,
                                        options: value,
                                    }
                
                                    props.onActionChange(newAction);
                                }}
                            />
                        }
                        {
                            'change-author' === selectedAction
                            &&
                            <Fragment>
                                <FieldDropdown
                                    options={ wprm_admin_modal.options.author.filter( ( author ) => 'same' !== author.actual ) }
                                    value={ props.action.options.author }
                                    onChange={ (author) => {
                                        const newAction = {
                                            ...props.action,
                                            options: {
                                                author,
                                                author_name: '',
                                                author_link: '',
                                            }
                                        }
                                        props.onActionChange(newAction);
                                    }}
                                    width={ 300 }
                                    custom={{
                                        menuPlacement: 'top',
                                        maxMenuHeight: 150,
                                    }}
                                />
                                {
                                    'custom' === wprm_admin_modal.options.author.find((option) => option.value === props.action.options.author ).actual
                                    &&
                                    <Fragment>
                                        &nbsp;
                                        <FieldText
                                            name="author-name"
                                            placeholder={ __wprm( 'Author Name' ) }
                                            value={ props.action.options.author_name }
                                            onChange={ (author_name) => {
                                                const newAction = {
                                                    ...props.action,
                                                    options: {
                                                        ...props.action.options,
                                                        author_name,
                                                    }
                                                }
                                                props.onActionChange(newAction);
                                            }}
                                        />
                                        &nbsp;
                                        <FieldText
                                            name="author-link"
                                            placeholder="https://bootstrapped.ventures"
                                            type="url"
                                            value={ props.action.options.author_link }
                                            onChange={ (author_link) => {
                                                const newAction = {
                                                    ...props.action,
                                                    options: {
                                                        ...props.action.options,
                                                        author_link,
                                                    }
                                                }
                                                props.onActionChange(newAction);
                                            }}
                                        />
                                    </Fragment>
                                }
                            </Fragment>
                        }
                        {
                            ( 'add-terms' === selectedAction || 'remove-terms' === selectedAction )
                            &&
                            <Fragment>
                                <FieldDropdown
                                    options={ taxonomyOptions }
                                    value={ props.action.options.taxonomy }
                                    onChange={ (taxonomy) => {
                                        const newAction = {
                                            ...props.action,
                                            options: {
                                                taxonomy,
                                                terms: [],
                                            }
                                        }
                                        props.onActionChange(newAction);
                                    }}
                                    width={ 200 }
                                    custom={{
                                        menuPlacement: 'top',
                                        maxMenuHeight: 150,
                                    }}
                                />
                                &nbsp;
                                <FieldCategory
                                    id={ props.action.options.taxonomy }
                                    value={ props.action.options.terms }
                                    onChange={(terms) => {
                                        const newAction = {
                                            ...props.action,
                                            options: {
                                                taxonomy: props.action.options.taxonomy,
                                                terms,
                                            }
                                        }
                    
                                        props.onActionChange(newAction);
                                    }}
                                    custom={{
                                        menuPlacement: 'top',
                                        maxMenuHeight: 200,
                                    }}
                                />
                            </Fragment>
                        }
                    </div>
                </Fragment>
            }
        </form>
    );
}
export default ActionsRecipe;