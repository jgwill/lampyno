import React, { Component, Fragment } from 'react';
import { DragDropContext, Droppable } from 'react-beautiful-dnd';

import { __wprm } from 'Shared/Translations';
import FieldIngredient from '../../../fields/FieldIngredient';

export default class IngredientsEdit extends Component {
    constructor(props) {
        super(props);

        this.container = React.createRef();
    }

    shouldComponentUpdate(nextProps, nextState) {
        return this.props.type !== nextProps.type
               || JSON.stringify( this.props.ingredients ) !== JSON.stringify( nextProps.ingredients );
    }

    componentDidUpdate( prevProps ) {
        if ( this.props.ingredients.length > prevProps.ingredients.length ) {
            const inputs = this.container.current.querySelectorAll('.wprm-admin-modal-field-ingredient-group-name, .wprm-admin-modal-field-ingredient-amount');

            if ( inputs.length ) {
                inputs[ inputs.length - 1 ].focus();
            }
        }
    }

    onDragEnd(result) {
        if ( result.destination ) {
            let newFields = JSON.parse( JSON.stringify( this.props.ingredients ) );
            const sourceIndex = result.source.index;
            const destinationIndex = result.destination.index;

            const field = newFields.splice(sourceIndex, 1)[0];
            newFields.splice(destinationIndex, 0, field);

            this.props.onRecipeChange({
                ingredients_flat: newFields,
            });
        }
    }

    addField(type) {
        let newFields = JSON.parse( JSON.stringify( this.props.ingredients ) );
        let newField;

        if ( 'group' === type ) {
            newField = {
                type: 'group',
                name: '',
            };
        } else {
            newField = {
                type: 'ingredient',
                amount: '',
                unit: '',
                name: '',
                notes: '',
            }
        }

        // Give unique UID.
        let maxUid = Math.max.apply( Math, newFields.map( function(field) { return field.uid; } ) );
        maxUid = maxUid < 0 ? -1 : maxUid;
        newField.uid = maxUid + 1;

        newFields.push(newField);

        this.props.onRecipeChange({
            ingredients_flat: newFields,
        });
    }
  
    render() {
        return (
            <div
                className="wprm-admin-modal-field-ingredient-edit-container"
                ref={ this.container }
            >
                <DragDropContext
                    onDragEnd={ this.onDragEnd.bind(this) }
                >
                    <Droppable
                        droppableId="wprm-ingredients"
                    >
                        {(provided, snapshot) => (
                            <div
                                className={`${ snapshot.isDraggingOver ? ' wprm-admin-modal-field-ingredient-container-draggingover' : ''}`}
                                ref={provided.innerRef}
                                {...provided.droppableProps}
                            >
                                <div className="wprm-admin-modal-field-ingredient-header-container">
                                    <div className="wprm-admin-modal-field-ingredient-header">{ __wprm( 'Amount' ) }</div>
                                    <div className="wprm-admin-modal-field-ingredient-header">{ __wprm( 'Unit' ) }</div>
                                    <div className="wprm-admin-modal-field-ingredient-header">{ __wprm( 'Name' ) } <span className="wprm-admin-modal-field-ingredient-header-required">({ __wprm( 'required' ) })</span></div>
                                    <div className="wprm-admin-modal-field-ingredient-header">{ __wprm( 'Notes' ) }</div>
                                </div>
                                {
                                    this.props.ingredients.map((field, index) => (
                                        <FieldIngredient
                                            { ...field }
                                            recipeType={ this.props.type }
                                            index={ index }
                                            key={ `ingredient-${field.uid}` }
                                            onTab={(event) => {
                                                // Create new ingredient if we're tabbing in the last one.
                                                if ( index === this.props.ingredients.length - 1) {
                                                    event.preventDefault();
                                                    // Use timeout to fix focus problem (because of preventDefault?).
                                                    setTimeout(() => {
                                                        this.addField( 'ingredient' );
                                                    });
                                                }
                                            }}
                                            onChangeName={ ( name ) => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.ingredients ) );
                                                newFields[index].name = name;

                                                this.props.onRecipeChange({
                                                    ingredients_flat: newFields,
                                                });
                                            }}
                                            onChangeIngredient={ ( ingredient ) => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.ingredients ) );

                                                newFields[index] = {
                                                    ...newFields[index],
                                                    ...ingredient,
                                                }
                                                
                                                this.props.onRecipeChange({
                                                    ingredients_flat: newFields,
                                                });
                                            }}
                                            onDelete={() => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.ingredients ) );
                                                newFields.splice(index, 1);

                                                this.props.onRecipeChange({
                                                    ingredients_flat: newFields,
                                                });
                                            }}
                                        />
                                    ))
                                }
                                {provided.placeholder}
                            </div>
                        )}
                    </Droppable>
                </DragDropContext>
                <div
                    className="wprm-admin-modal-field-ingredient-actions"
                >
                    <button
                        className="button"
                        onClick={(e) => {
                            e.preventDefault();
                            this.addField( 'ingredient' );
                        } }
                    >{ 'howto' === this.props.type ? __wprm( 'Add Material' ) : __wprm( 'Add Ingredient' ) }</button>
                    <button
                        className="button"
                        onClick={(e) => {
                            e.preventDefault();
                            this.addField( 'group' );
                        } }
                    >{ 'howto' === this.props.type ? __wprm( 'Add Material Group' ) : __wprm( 'Add Ingredient Group' ) }</button>
                    <p>{ __wprm( 'Tip: use the TAB key to move from field to field and easily add ingredients.' ) }</p>
                </div>
            </div>
        );
    }
}
