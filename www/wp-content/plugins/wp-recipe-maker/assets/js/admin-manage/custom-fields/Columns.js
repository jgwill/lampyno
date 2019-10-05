import React from 'react';
import he from 'he';
 
import Api from '../../admin-modal/custom-field/Api';
import Icon from '../../shared/Icon';
import { __wprm } from '../../shared/Translations';

export default {
    getColumns( datatable ) {
        let columns = [{
            Header: '',
            id: 'actions',
            headerClassName: 'wprm-admin-table-help-text',
            sortable: false,
            filterable: false,
            width: 70,
            Cell: row => (
                <div className="wprm-admin-manage-actions">
                    <Icon
                        type="pencil"
                        title={ __wprm( 'Edit Field' ) }
                        onClick={() => {
                            WPRM_Modal.open( 'custom-field', {
                                field: row.original,
                                saveCallback: () => datatable.refreshData(),
                            } );
                        }}
                    />
                    <Icon
                        type="trash"
                        title={ __wprm( 'Delete Field' ) }
                        onClick={() => {
                            if( confirm( `${ __wprm( 'Are you sure you want to delete' ) } "${row.original.key}"?` ) ) {
                                Api.deleteCustomField(row.original.key).then(() => datatable.refreshData());
                            }
                        }}
                    />
                </div>
            ),
        },{
            Header: __wprm( 'Key' ),
            id: 'key',
            accessor: 'key',
            sortable: false,
            filterable: false,
        },{
            Header: __wprm( 'Name' ),
            id: 'name',
            accessor: 'name',
            sortable: false,
            filterable: false,
            Cell: row => row.value ? he.decode(row.value) : null,
        },{
            Header: __wprm( 'Type' ),
            id: 'type',
            accessor: 'type',
            sortable: false,
            filterable: false,
            Cell: row => {
                const type = wprm_admin_modal.custom_fields.types.find((option) => option.value === row.value );
                    
                if ( ! type ) {
                    return (<div></div>);
                }

                return (
                    <div>{ type.label }</div>
                )
            },
        }];

        return columns;
    }
};