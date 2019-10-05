import React, { Component } from 'react';
import AsyncSelect from 'react-select/async';

import { __wprm } from '../../../shared/Translations';
import Api from './Api';

export default class StepCustomIngredient extends Component {
    getOptions(input) {
        input = input ? input : this.props.defaultSearch;

        if ( ! input ) {
			return Promise.resolve([]);
        }

        return Api.getCustomIngredients(input).then((data) => {
            if ( data ) {
                return data.ingredients;
            } else {
                return [];
            }
        });
    }

    render() {
        return (
            <AsyncSelect
                placeholder={ __wprm( 'Select or search for a saved ingredient' ) }
                value={this.props.value}
                onChange={this.props.onValueChange}
                getOptionValue={({id}) => id}
                getOptionLabel={({text}) => text}
                loadOptions={this.getOptions.bind(this)}
                defaultOptions={true}
                clearable={false}
                menuPlacement="top"
                styles={{
                    control: (provided) => ({
                        ...provided,
                        backgroundColor: 'white',
                    }),
                    container: (provided) => ({
                        ...provided,
                        width: '100%',
                        maxWidth: '440px',
                        marginBottom: '10px',
                    }),
                }}
            />
        );
    }
}