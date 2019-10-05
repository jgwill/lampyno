// External Dependencies
import React, { Component, Fragment } from 'react';

export default class Recipe extends Component {

    constructor() {
        super();
        this.slug = 'wprm_recipe';
    }

    render() {
        // const Content = this.props.content;

        return (
            <Fragment>
                <h1 className="simp-simple-header-heading">{this.props.heading}</h1>
                <p>
                    {this.props.content()}
                </p>
            </Fragment>
        );
    }
}
