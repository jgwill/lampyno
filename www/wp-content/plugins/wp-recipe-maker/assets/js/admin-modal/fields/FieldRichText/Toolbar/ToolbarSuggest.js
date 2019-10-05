import React, { Component, Fragment } from 'react';

import Api from 'Shared/Api';
import Loader from 'Shared/Loader';
import { __wprm } from 'Shared/Translations';

export default class ToolbarSuggest extends Component {
    constructor(props) {
		super(props);
		
		// Cache suggestions.
		window.wprm_admin_modal_suggestions = window.wprm_admin_modal_suggestions || {};
		if ( ! window.wprm_admin_modal_suggestions.hasOwnProperty( props.type ) ) {
			window.wprm_admin_modal_suggestions[ props.type ] = {};
		}

        this.state = {
			suggestions: [],
			loading: false,
		}
	}

	componentDidMount() {
		const search = this.props.richText.getHtmlFromValue( this.props.value );

		this.updateSuggestions( search );
	}

	componentDidUpdate(prevProps) {
		const search = this.props.richText.getHtmlFromValue( this.props.value );
		const prevSearch = this.props.richText.getHtmlFromValue( prevProps.value );

		if ( search !== prevSearch ) {
			this.updateSuggestions( search );
		}
	}
	
	updateSuggestions( search ) {
		if ( window.wprm_admin_modal_suggestions[ this.props.type ].hasOwnProperty( search ) ) {
			this.setState({
				suggestions: window.wprm_admin_modal_suggestions[ this.props.type ][ search ],
			});
		} else {
			this.setState({
				loading: true,
			});
	
			Api.modal.getSuggestions({
				type: this.props.type,
				search
			}).then(data => {
				if ( data ) {
					window.wprm_admin_modal_suggestions[ this.props.type ][ search ] = data.suggestions;

					this.setState({
						suggestions: data.suggestions,
						loading: false,
					});
				}
			});
		}
	}
  
    render() {
        return (
            <div className="wprm-admin-modal-toolbar-suggest">
				{
					! this.state.loading
					&& 0 === this.state.suggestions.length
					?
					<strong>{ __wprm( 'No suggestions found.' ) }</strong>
					:
					<Fragment>
						<strong>{ __wprm( 'Suggestions:' ) }</strong>
						{
							this.state.loading
							?
							<Loader/>
							:
							<Fragment>
								{
									this.state.suggestions.map((suggestion, index) => (
										<span
											className="wprm-admin-modal-toolbar-suggestion"
											onMouseDown={ (event) => {
												event.preventDefault();

												const newValue = this.props.richText.getValueFromHtml( suggestion.name );
												this.props.richText.onChange( { value: newValue } );
											} }
											key={ index }
										>
											<span className="wprm-admin-modal-toolbar-suggestion-text">{ suggestion.name } ({ suggestion.count})</span>
										</span>
									))
								}
							</Fragment>
						}
					</Fragment>
				}
			</div>
        );
    }
}
