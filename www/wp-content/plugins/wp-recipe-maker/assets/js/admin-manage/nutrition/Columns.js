import React from 'react';
import he from 'he';
 
import TextFilter from '../general/TextFilter';
import Api from '../general/Api';
import Icon from '../../shared/Icon';
import { __wprm } from '../../shared/Translations';

import '../../../css/admin/manage/nutrition.scss';

export default {
    getColumns( datatable ) {
        let columns = [{
            Header: __wprm( 'Sort:' ),
            id: 'actions',
            headerClassName: 'wprm-admin-table-help-text',
            sortable: false,
            width: 70,
            Filter: () => (
                <div>
                    { __wprm( 'Filter:' ) }
                </div>
            ),
            Cell: row => (
                <div className="wprm-admin-manage-actions">
                    <Icon
                        type="pencil"
                        title={ __wprm( 'Edit Custom Ingredient' ) }
                        onClick={() => {
                            let ingredient = JSON.parse(JSON.stringify(row.original));
                            ingredient.id = ingredient.term_id;

                            WPRM_Modal.open( 'nutrition', {
                                ingredient,
                                saveCallback: () => datatable.refreshData(),
                            } );
                        }}
                    />
                    <Icon
                        type="trash"
                        title={ __wprm( 'Delete Custom Ingredient' ) }
                        onClick={() => {
                            if( confirm( `${ __wprm( 'Are you sure you want to delete' ) } "${row.original.name}"?` ) ) {
                                Api.deleteTerm('nutrition_ingredient', row.original.term_id).then(() => datatable.refreshData());
                            }
                        }}
                    />
                </div>
            ),
        },{
            Header: __wprm( 'ID' ),
            id: 'id',
            accessor: 'term_id',
            width: 65,
            Filter: (props) => (<TextFilter {...props}/>),
        },{
            Header: __wprm( 'Amount' ),
            id: 'amount',
            accessor: 'amount',
            width: 125,
            sortable: false,
            filterable: false,
            Cell: row => (<div>{ `${row.value} ${row.original.unit}` }</div>),
        },{
            Header: __wprm( 'Name' ),
            id: 'name',
            accessor: 'name',
            Filter: (props) => (<TextFilter {...props}/>),
            Cell: row => row.value ? he.decode(row.value) : null,
        },{
            Header: __wprm( 'Nutrition Facts' ),
            id: 'facts',
            accessor: 'facts',
            width: 250,
            sortable: false,
            filterable: false,
            Cell: row => (
                <div className="wprm-manage-nutrition-nutrition-container">
                    {
                        Object.keys(wprm_admin_modal.nutrition).map((nutrient, index ) => {
                            const options = wprm_admin_modal.nutrition[nutrient];
                            const value = row.value.hasOwnProperty(nutrient) ? row.value[nutrient] : false;
    
                            if ( false === value || '' === value ) {
                                return null;
                            }
    
                            if ( 'calories' !== nutrient && ! wprm_admin.addons.premium ) {
                                return null;
                            }
    
                            return (
                                <div
                                    className="wprm-manage-nutrition-nutrition"
                                    key={index}
                                >
                                    <div className="wprm-manage-nutrition-nutrition-label">{ options.label }</div>
                                    <div className="wprm-manage-nutrition-nutrition-value-unit">
                                        <span className="wprm-manage-nutrition-nutrition-value">{ value }</span>
                                        <span className="wprm-manage-nutrition-nutrition-unit">{ options.unit }</span>
                                    </div>
                                </div>
                            )
                        })
                    }
                </div>
            ),
        }];

        return columns;
    }
};