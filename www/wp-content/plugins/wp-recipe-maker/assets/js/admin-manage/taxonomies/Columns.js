import React from 'react';
import he from 'he';
 
import Media from 'Modal/general/Media';
import TextFilter from '../general/TextFilter';
import bulkEditCheckbox from '../general/bulkEditCheckbox';
import Api from 'Shared/Api';
import Icon from 'Shared/Icon';
import Tooltip from 'Shared/Tooltip';
import { __wprm } from 'Shared/Translations';

import '../../../css/admin/manage/taxonomies.scss';

export default {
    getColumns( datatable ) {
        const link_nofollow_options = wprm_admin_modal.options.hasOwnProperty( `${datatable.props.options.id}_link_nofollow` ) ? wprm_admin_modal.options[`${datatable.props.options.id}_link_nofollow`] : [];

        let columns = [
            bulkEditCheckbox( datatable, 'term_id' ),
            {
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
                            title={ `${ __wprm( 'Rename' ) } ${ datatable.props.options.label.singular }` }
                            onClick={() => {
                                let newName = prompt( `${ __wprm( 'What do you want to be the new name for' ) } "${row.original.name}"?`, row.original.name );
                                if( newName && newName.trim() ) {
                                    Api.manage.renameTerm(datatable.props.options.id, row.original.term_id, newName).then(() => datatable.refreshData());
                                }
                            }}
                        />
                        <Icon
                            type="merge"
                            title={ `${ __wprm( 'Merge into another' ) } ${ datatable.props.options.label.singular }` }
                            onClick={() => {
                                let newId = prompt( `${ __wprm( 'What is the ID of the term you want the merge' ) } "${row.original.name}" ${ __wprm( 'into' ) }?` );
                                if( newId && newId != row.original.term_id && newId.trim() ) {
                                    Api.manage.getTerm(datatable.props.options.id, newId).then(newTerm => {
                                        if ( newTerm ) {
                                            if ( confirm( `${ __wprm( 'Are you sure you want to merge' ) } "${row.original.name}" ${ __wprm( 'into' ) } "${newTerm.name}"?` ) ) {
                                                Api.manage.mergeTerm(datatable.props.options.id, row.original.term_id, newId).then(() => datatable.refreshData());
                                            }
                                        } else {
                                            alert( __wprm( 'We could not find a term with that ID.' ) );
                                        }
                                    });
                                }
                            }}
                        />
                        <Icon
                            type="trash"
                            title={ `${ __wprm( 'Delete' ) } ${ datatable.props.options.label.singular }` }
                            onClick={() => {
                                if( confirm( `${ __wprm( 'Are you sure you want to delete' ) } "${row.original.name}"?` ) ) {
                                    Api.manage.deleteTerm(datatable.props.options.id, row.original.term_id).then(() => datatable.refreshData());
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
                Header: __wprm( 'Name' ),
                id: 'name',
                accessor: 'name',
                Filter: (props) => (<TextFilter {...props}/>),
                Cell: row => row.value ? he.decode(row.value) : null,
            },{
                Header: __wprm( 'Recipes' ),
                id: 'count',
                accessor: 'count',
                filterable: false,
                width: 65,
            }
        ];

        if ( 'ingredient' === datatable.props.options.id && wprm_admin.addons.premium ) {
            columns.push({
                Header: __wprm( 'Shopping List Group' ),
                id: 'group',
                accessor: 'group',
                width: 200,
                Filter: (props) => (<TextFilter {...props}/>),
                Cell: row => {
                    return (
                        <div className="wprm-manage-ingredients-group-container">
                            <Icon
                                type="pencil"
                                title={ __wprm( 'Change Group' ) }
                                onClick={() => {
                                    const newGroup = prompt( `${ __wprm( 'What do you want to be the new group for' ) } "${row.original.name}"?`, row.value );
                                    if( false !== newGroup ) {
                                        Api.manage.updateTaxonomyMeta('ingredient', row.original.term_id, { group: newGroup }).then(() => datatable.refreshData());
                                    }
                                }}
                            />
                            {
                                row.value
                                ?
                                <span>{ row.value }</span>
                                :
                                null
                            }
                        </div>
                    )
                },
            });
        }

        if ( ( 'ingredient' === datatable.props.options.id || 'equipment' === datatable.props.options.id ) && wprm_admin.addons.premium ) {
            columns.push({
                Header: __wprm( 'Link' ),
                id: 'link',
                accessor: 'link',
                width: 300,
                Filter: (props) => (<TextFilter {...props}/>),
                Cell: row => {
                    return (
                        <div className="wprm-manage-ingredients-link-container">
                            <Icon
                                type="pencil"
                                title={ __wprm( 'Change Link' ) }
                                onClick={() => {
                                    const newLink = prompt( `${ __wprm( 'What do you want to be the new link for' ) } "${row.original.name}"?`, row.value );
                                    if( false !== newLink ) {
                                        Api.manage.updateTaxonomyMeta(datatable.props.options.id, row.original.term_id, { link: newLink }).then(() => datatable.refreshData());
                                    }
                                }}
                            />
                            {
                                row.value
                                ?
                                <a href={ row.value } target="_blank">{ row.value }</a>
                                :
                                null
                            }
                        </div>
                    )
                },
            },{
                Header: __wprm( 'Link Nofollow' ),
                id: 'link_nofollow',
                accessor: 'link_nofollow',
                width: 250,
                Filter: ({ filter, onChange }) => (
                    <select
                        onChange={event => onChange(event.target.value)}
                        style={{ width: '100%', fontSize: '1em' }}
                        value={filter ? filter.value : 'all'}
                    >
                        <option value="all">{ __wprm( 'Any Nofollow' ) }</option>
                        {
                            link_nofollow_options.map((option, index) => (
                                <option value={option.value} key={index}>{ option.label }</option>
                            ))
                        }
                    </select>
                ),
                Cell: row => {
                    return (
                        <div>
                            {
                                row.original.link
                                ?
                                <select
                                    onChange={event => {
                                        Api.manage.updateTaxonomyMeta(datatable.props.options.id, row.original.term_id, { link_nofollow: event.target.value }).then(() => datatable.refreshData());
                                    }}
                                    style={{ width: '100%', fontSize: '1em' }}
                                    value={row.value}
                                >
                                    {
                                        link_nofollow_options.map((option, index) => (
                                            <option value={option.value} key={index}>{ option.label }</option>
                                        ))
                                    }
                                </select>
                                :
                                null
                            }
                        </div>
                    )
                },
            });
        }

        if ( 'equipment' === datatable.props.options.id && wprm_admin.addons.premium ) {
            columns.push({
                Header: __wprm( 'Image' ),
                id: 'image_id',
                accessor: 'image_id',
                width: 110,
                sortable: false,
                Filter: ({ filter, onChange }) => (
                    <select
                        onChange={event => onChange(event.target.value)}
                        style={{ width: '100%', fontSize: '1em' }}
                        value={filter ? filter.value : 'all'}
                    >
                        <option value="all">{ __wprm( 'Show All' ) }</option>
                        <option value="yes">{ __wprm( 'Has Image' ) }</option>
                        <option value="no">{ __wprm( 'Does not have Image' ) }</option>
                    </select>
                ),
                Cell: row => {
                    const selectImage = (e) => {
                        e.preventDefault();
                                
                        Media.selectImage((attachment) => {
                            Api.manage.updateTaxonomyMeta('equipment', row.original.term_id, { image_id: attachment.id }).then(() => datatable.refreshData());
                        });
                    };

                    return (
                        <div className="wprm-manage-equipment-image-container">
                            {
                                row.value
                                ?
                                <div className="wprm-manage-equipment-image-preview">
                                    <Tooltip content={ __wprm( 'Edit Image' ) }>
                                        <img
                                            src={ row.original.image_url }
                                            width="80"
                                            onClick={ selectImage }
                                        />
                                    </Tooltip>
                                    <Icon
                                        type="trash"
                                        title={ __wprm( 'Remove Image' ) }
                                        onClick={ () => {
                                            Api.manage.updateTaxonomyMeta('equipment', row.original.term_id, { image_id: 0 }).then(() => datatable.refreshData());
                                        } }
                                    />
                                </div>
                                :
                                <Icon
                                    type="photo"
                                    title={ __wprm( 'Add Image' ) }
                                    onClick={ selectImage }
                                />
                            }
                        </div>
                    )
                },
            });
        }

        return columns;
    }
};