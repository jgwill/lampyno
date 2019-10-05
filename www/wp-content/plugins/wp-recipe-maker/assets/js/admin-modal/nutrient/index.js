import React, { Component, Fragment } from 'react';

import '../../../css/admin/modal/nutrient.scss';

import { __wprm } from '../../shared/Translations';
import Header from '../general/Header';
import Footer from '../general/Footer';

import FieldContainer from '../fields/FieldContainer';
import FieldDropdown from '../fields/FieldDropdown';
import FieldText from '../fields/FieldText';
import Api from './Api';

export default class Menu extends Component {
    constructor(props) {
        super(props);

        let nutrient = {
            key: '',
            type: 'custom',
            label: '',
            unit: '',
            daily: 0,
            active: true,
            calculation: '',
            precision: 0,
        }

        let editing = false;
        if ( props.args.hasOwnProperty( 'nutrient' ) ) {
            editing = true;
            nutrient = JSON.parse( JSON.stringify( props.args.nutrient ) );
        }

        this.state = {
            editing,
            nutrient,
            originalNutrient: JSON.parse( JSON.stringify( nutrient ) ),
            savingChanges: false,
        };

        this.changesMade = this.changesMade.bind(this);
        this.saveChanges = this.saveChanges.bind(this);
    }

    sanitizeSlug(text) {
        text = text.trim();
        text = text.toLowerCase();

        const from = "àáäâèéëêìíïîòóöôùúüûñçěščřžýúůďťň·/-,:;";
        const to   = "aaaaeeeeiiiioooouuuuncescrzyuudtn______";

        for ( let i=0, l=from.length ; i<l ; i++ )
        {
            text = text.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        text = text.replace('.', '-')
            .replace(/[^a-z0-9\s_]/g, '')
            .replace(/\s+/g, '_')
            .replace(/_+/g, '_');

        return text;
    }

    saveChanges() {
        if ( ! this.state.nutrient.key.trim() || ! this.state.nutrient.label.trim() ) {
            alert( __wprm( 'A label and key are required.' ) );
        } else {
            this.setState({
                savingChanges: true,
            }, () => {
                Api.updateNutrient( this.state.editing, this.state.nutrient ).then((nutrient) => {
                    if ( nutrient ) {
                        this.setState({
                            originalNutrient: JSON.parse( JSON.stringify( this.state.nutrient ) ),
                            savingChanges: false,
                        },() => {
                            if ( 'function' === typeof this.props.args.saveCallback ) {
                                this.props.args.saveCallback( this.state.nutrient );
                            }
                            this.props.maybeCloseModal();
                        });
                    } else {
                        if ( ! this.state.editing && false === nutrient ) {
                            alert( __wprm( 'Something went wrong. Make sure this key does not exist yet.' ) );
                        }
                        this.setState({
                            savingChanges: false,
                        });
                    }
                });
            })
        }
    }

    allowCloseModal() {
        return ! this.state.savingChanges && ( ! this.changesMade() || confirm( __wprm( 'Are you sure you want to close without saving changes?' ) ) );
    }

    changesMade() {
        return JSON.stringify( this.state.nutrient ) !== JSON.stringify( this.state.originalNutrient );
    }

    render() {
        return (
            <Fragment>
                <Header
                    onCloseModal={ this.props.maybeCloseModal }
                >
                    {
                        this.state.editing
                        ?
                        
                        `${ __wprm( 'Editing Nutrient' ) }${this.state.nutrient.key ? ` - ${this.state.nutrient.key}` : ''}`
                        :
                        `${ __wprm( 'Creating new Nutrient' ) }${this.state.nutrient.key ? ` - ${this.state.nutrient.key}` : ''}`
                    }
                </Header>
                <div className="wprm-admin-modal-nutrient-container">
                    {
                        false === this.state.editing
                        &&
                        <Fragment>
                            <FieldContainer id="type" label={ __wprm( 'Type' ) }>
                                <FieldDropdown
                                    options={[
                                        { value: 'custom', label: __wprm( 'Custom' ) },
                                        { value: 'calculated', label: __wprm( 'Calculated' ) },
                                    ]}
                                    value={ this.state.nutrient.type }
                                    onChange={ (type) => {
                                        this.setState({
                                            nutrient: {
                                                ...this.state.nutrient,
                                                type,
                                            }
                                        });
                                    }}
                                />
                            </FieldContainer>
                            <FieldContainer id="key" label={ __wprm( 'Key' ) }>
                                <FieldText
                                    placeholder={ __wprm( 'my-custom-nutrient' ) }
                                    value={ `${this.state.nutrient.key}` }
                                    onChange={ (key) => {
                                        this.setState({
                                            nutrient: {
                                                ...this.state.nutrient,
                                                key: this.sanitizeSlug( key ),
                                            }
                                        });
                                    }}
                                />
                            </FieldContainer>
                        </Fragment>
                    }
                    <FieldContainer id="label" label={ __wprm( 'Label' ) }>
                        <FieldText
                            placeholder={ __wprm( 'My Custom Nutrient' ) }
                            value={ this.state.nutrient.label }
                            onChange={ (label) => {
                                this.setState({
                                    nutrient: {
                                        ...this.state.nutrient,
                                        label,
                                    }
                                });
                            }}
                        />
                    </FieldContainer>
                    <FieldContainer id="unit" label={ __wprm( 'Unit' ) }>
                        <FieldText
                            placeholder={ __wprm( 'mg' ) }
                            value={ this.state.nutrient.unit }
                            onChange={ (unit) => {
                                this.setState({
                                    nutrient: {
                                        ...this.state.nutrient,
                                        unit,
                                    }
                                });
                            }}
                        />
                    </FieldContainer>
                    <FieldContainer id="daily" label={ __wprm( 'Daily Need' ) }>
                        <FieldText
                            type="number"
                            value={ 0 === this.state.nutrient.daily ? '' : this.state.nutrient.daily }
                            onChange={ (daily) => {
                                this.setState({
                                    nutrient: {
                                        ...this.state.nutrient,
                                        daily,
                                    }
                                });
                            }}
                        />
                    </FieldContainer>
                    {
                        'calculated' === this.state.nutrient.type
                        &&
                        <Fragment>
                            <FieldContainer id="calculation" label={ __wprm( 'Calculation' ) }>
                                <FieldText
                                    placeholder="carbohydrates - fiber"
                                    value={ this.state.nutrient.calculation }
                                    onChange={ (calculation) => {
                                        this.setState({
                                            nutrient: {
                                                ...this.state.nutrient,
                                                calculation,
                                            }
                                        });
                                    }}
                                />
                                <a href="https://help.bootstrapped.ventures/article/199-custom-and-calculated-nutrients" target="_blank">{ __wprm( 'Learn more' ) }</a>
                            </FieldContainer>
                            <FieldContainer id="precision" label={ __wprm( 'Decimal Precision' ) }>
                                <FieldText
                                    type="number"
                                    placeholder="0"
                                    value={ this.state.nutrient.precision }
                                    onChange={ (precision) => {
                                        this.setState({
                                            nutrient: {
                                                ...this.state.nutrient,
                                                precision,
                                            }
                                        });
                                    }}
                                />
                            </FieldContainer>
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