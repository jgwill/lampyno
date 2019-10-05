import React, { Component } from 'react';
import { DragDropContext, Droppable } from 'react-beautiful-dnd';

import '../../../../css/admin/modal/recipe/fields/instructions.scss';

import { __wprm } from 'Shared/Translations';
import FieldInstruction from '../../fields/FieldInstruction';

export default class RecipeInstructions extends Component {
    constructor(props) {
        super(props);

        this.container = React.createRef();
    }

    shouldComponentUpdate(nextProps) {
        return JSON.stringify( this.props.instructions ) !== JSON.stringify( nextProps.instructions );
    }

    componentDidUpdate( prevProps ) {
        if ( this.props.instructions.length > prevProps.instructions.length ) {
            const inputs = this.container.current.querySelectorAll('.wprm-admin-modal-field-richtext');

            if ( inputs.length ) {
                inputs[ inputs.length - 1 ].focus();
            }
        }
    }

    onDragEnd(result) {
        if ( result.destination ) {
            let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );
            const sourceIndex = result.source.index;
            const destinationIndex = result.destination.index;

            const field = newFields.splice(sourceIndex, 1)[0];
            newFields.splice(destinationIndex, 0, field);

            this.props.onRecipeChange({
                instructions_flat: newFields,
            });
        }
    }

    addField(type) {
        let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );
        let newField;

        if ( 'group' === type ) {
            newField = {
                type: 'group',
                name: '',
            };
        } else {
            newField = {
                type: 'instruction',
                text: '',
                image: 0,
                image_url: '',
            }
        }

        // Give unique UID.
        let maxUid = Math.max.apply( Math, newFields.map( function(field) { return field.uid; } ) );
        maxUid = maxUid < 0 ? -1 : maxUid;
        newField.uid = maxUid + 1;

        newFields.push(newField);

        this.props.onRecipeChange({
            instructions_flat: newFields,
        });
    }
  
    render() {
        return (
            <div
                className="wprm-admin-modal-field-instruction-container"
                ref={ this.container }
            >
                <DragDropContext
                    onDragEnd={this.onDragEnd.bind(this)}
                >
                    <Droppable
                        droppableId="wprm-instructions"
                    >
                        {(provided, snapshot) => (
                            <div
                                className={`${ snapshot.isDraggingOver ? ' wprm-admin-modal-field-instruction-container-draggingover' : ''}`}
                                ref={provided.innerRef}
                                {...provided.droppableProps}
                            >
                                {
                                    this.props.instructions.map((field, index) => (
                                        <FieldInstruction
                                            { ...field }
                                            index={ index }
                                            key={ `instruction-${field.uid}` }
                                            onTab={(event) => {
                                                // Create new instruction if we're tabbing in the last one.
                                                if ( index === this.props.instructions.length - 1) {
                                                    event.preventDefault();
                                                    // Use timeout to fix focus problem (because of preventDefault?).
                                                    setTimeout(() => {
                                                        this.addField( 'instruction' );
                                                    });
                                                }
                                            }}
                                            onChangeText={ ( text ) => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );

                                                if ( 'group' === field.type ) {
                                                    newFields[index].name = text;
                                                } else {
                                                    newFields[index].text = text;
                                                }
                                                
                                                this.props.onRecipeChange({
                                                    instructions_flat: newFields,
                                                });
                                            }}
                                            onChangeImage={ ( image, url ) => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );

                                                newFields[index].image = image;
                                                newFields[index].image_url = url;
                                                
                                                this.props.onRecipeChange({
                                                    instructions_flat: newFields,
                                                });
                                            }}
                                            onDelete={() => {
                                                let newFields = JSON.parse( JSON.stringify( this.props.instructions ) );
                                                newFields.splice(index, 1);

                                                this.props.onRecipeChange({
                                                    instructions_flat: newFields,
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
                    className="wprm-admin-modal-field-instruction-actions"
                >
                    <button
                        className="button"
                        onClick={(e) => {
                            e.preventDefault();
                            this.addField( 'instruction' );
                        } }
                    >{ __wprm( 'Add Instruction' ) }</button>
                    <button
                        className="button"
                        onClick={(e) => {
                            e.preventDefault();
                            this.addField( 'group' );
                        } }
                    >{ __wprm( 'Add Instruction Group' ) }</button>
                    <p>{ __wprm( 'Tip: use the TAB key to move from field to field and easily add instructions.' ) }</p>
                </div>
            </div>
        );
    }
}
