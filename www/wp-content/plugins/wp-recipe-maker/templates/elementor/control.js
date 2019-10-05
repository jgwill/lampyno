import ReactDOM from 'react-dom';
import React, { Component } from 'react';
import AsyncSelect from 'react-select/async';

jQuery(document).ready(function($) {
    elementor.hooks.addAction( 'panel/open_editor/widget/wprm-recipe', function( panel, model, view ) {
        const $placeholder = panel.$el.find( '#wprm-recipe-select-placeholder' );

        if ( $placeholder.length ) {
            ReactDOM.render(
                <SelectRecipe
                    value={ false }
                    onValueChange={(recipe) => {
                        const id = recipe ? recipe.id : false;
                        model.setSetting('wprm_recipe_id', id);
                    }}
                    options={[]}
                />,
                $placeholder[0]
            );            
        }
     } );
});

// Based on /admin-modal/select/SelectRecipe.js
class SelectRecipe extends Component {
    getOptions(input) {
        if (!input) {
			return Promise.resolve({ options: [] });
        }

		return fetch(wprm_elementor.ajax_url, {
                method: 'POST',
                credentials: 'same-origin',
                body: 'action=wprm_search_recipes&security=' + wprm_elementor.nonce + '&search=' + encodeURIComponent( input ),
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8',
                },
            })
            .then((response) => response.json())
            .then((json) => {
                return json.data.recipes_with_id;
            });
    }

    render() {
        return (
            <AsyncSelect
                placeholder={ 'Select or search a recipe' }
                value={this.props.value}
                onChange={this.props.onValueChange}
                getOptionValue={({id}) => id}
                getOptionLabel={({text}) => text}
                defaultOptions={this.props.options.concat(wprm_elementor.latest_recipes)}
                loadOptions={this.getOptions.bind(this)}
                noOptionsMessage={() => 'No recipes found' }
                clearable={false}
            />
        );
    }
}