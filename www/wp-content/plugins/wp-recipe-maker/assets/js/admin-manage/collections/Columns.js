import React from 'react';
import he from 'he';
 
import TextFilter from '../general/TextFilter';
import Api from './Api';
import Icon from '../../shared/Icon';
import { __wprm } from '../../shared/Translations';

export default {
    getColumns( datatable ) {
        let columns = [{
            Header: __wprm( 'Sort:' ),
            id: 'actions',
            headerClassName: 'wprm-admin-table-help-text',
            sortable: false,
            width: 100,
            Filter: () => (
                <div>
                    { __wprm( 'Filter:' ) }
                </div>
            ),
            Cell: row => (
                <div className="wprm-admin-manage-actions">
                    <Icon
                        type="pencil"
                        title={ __wprm( 'Edit Saved Collection' ) }
                        onClick={() => {
                            const url = `${wprm_admin_manage.collections_url}&id=${row.original.id}`;
                            window.location = url;
                        }}
                    />
                    <Icon
                        type="duplicate"
                        title={ __wprm( 'Duplicate Saved Collection' ) }
                        onClick={() => {
                            const url = `${wprm_admin_manage.collections_url}&action=duplicate&id=${row.original.id}`;
                            window.location = url;
                        }}
                    />
                    <Icon
                        type="trash"
                        title={ __wprm( 'Delete Saved Collection' ) }
                        onClick={() => {
                            if( confirm( `${ __wprm( 'Are you sure you want to delete' ) } "${row.original.name}"?` ) ) {
                                Api.deleteCollection(row.original.id).then(() => datatable.refreshData());
                            }
                        }}
                    />
                </div>
            ),
        },{
            Header: __wprm( 'ID' ),
            id: 'id',
            accessor: 'id',
            width: 65,
            Filter: (props) => (<TextFilter {...props}/>),
        },{
            Header: __wprm( 'Date' ),
            id: 'date',
            accessor: 'date',
            width: 150,
            Filter: (props) => (<TextFilter {...props}/>),
        },{
            Header: __wprm( 'Name' ),
            id: 'name',
            accessor: 'name',
            Filter: (props) => (<TextFilter {...props}/>),
            Cell: row => row.value ? he.decode(row.value) : null,
        },{
            Header: __wprm( '# Items' ),
            id: 'nbrItems',
            accessor: 'nbrItems',
            width: 65,
            Filter: (props) => (<TextFilter {...props}/>),
        }];

        return columns;
    }
};