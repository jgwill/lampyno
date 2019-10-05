import React, { Component } from 'react';
import { Route } from 'react-router-dom';

import Menu from './Menu';
import Notices from './Notices';
import DataTable from './DataTable';
import ErrorBoundary from 'Shared/ErrorBoundary';

import '../../css/admin/manage/app.scss';
import defaultDatatables from './DataTableConfig';
const { hooks } = WPRecipeMaker.shared;

export default class App extends Component {
    render() {
        let datatables = hooks.applyFilters( 'datatables', defaultDatatables );

        return (
            <ErrorBoundary module="Manage">
                <div id="wprm-admin-manage-header">
                    <Menu
                        datatables={ datatables }
                    />
                    <Notices />
                </div>
                <div id="wprm-admin-manage-content">
                    <Route path="/:type?" render={( {match} ) => {
                        let type = 'recipe';
                        if ( match.params.type && Object.keys(datatables).includes( match.params.type ) ) {
                            type = match.params.type;
                        }

                        if ( ! datatables.hasOwnProperty( type ) ) {
                            return null;
                        }
                        
                        return (
                            <DataTable
                                type={ type }
                                options={ datatables[ type ] }
                            />
                        )
                    }} />
                </div>
            </ErrorBoundary>
        );
    }
}
