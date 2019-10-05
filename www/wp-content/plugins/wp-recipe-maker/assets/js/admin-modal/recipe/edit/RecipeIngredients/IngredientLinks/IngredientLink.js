import React, { Fragment } from 'react';

import striptags from 'striptags';

import Loader from '../../../../../shared/Loader';
import { __wprm } from '../../../../../shared/Translations';
import FieldDropdown from '../../../../fields/FieldDropdown';
import FieldText from '../../../../fields/FieldText';

const IngredientLink = (props) => {
    const { ingredient } = props;

    let link = {
        url: '',
        nofollow: 'default',
    };
    let nofollowLabel = '';

    if ( 'global' === props.type || 'edit-global' === props.type ) {
        if ( ingredient.hasOwnProperty('globalLink') && false !== ingredient.globalLink ) {
            link = ingredient.globalLink;

            const nofollowOption = wprm_admin_modal.options.ingredient_link_nofollow.find((option) => option.value === link.nofollow );
            if ( nofollowOption ) {
                nofollowLabel = nofollowOption.label;
            }
        }
    } else {
        if ( ingredient.hasOwnProperty('link') ) {
            link = ingredient.link;
        }
    }

    const hasLink = link && link.url;

    return (
        <div className="wprm-admin-modal-field-ingredient-links-link-container">
            <div className="wprm-admin-modal-field-ingredient-links-link-ingredient">
                { striptags( ingredient.name ) }
                {
                    'edit-global' === props.type
                    && props.hasChanged
                    &&
                    <div className="wprm-admin-modal-field-ingredient-links-link-ingredient-count">
                        {
                            0 < link.count - 1
                            ?
                            `${link.count - 1} ${ __wprm( 'other recipe(s) affected' ) }`
                            :
                            __wprm( 'This can affect other recipes' )
                        }
                    </div>
                }
            </div>
            {
                'global' === props.type
                ?
                <Fragment>
                    {
                        props.isUpdating
                        ?
                        <Loader />
                        :
                        <Fragment>
                            <div
                                className={ `wprm-admin-modal-field-ingredient-links-link-url${ hasLink ? '' : ' wprm-admin-modal-field-ingredient-links-link-url-none'}` }
                            >{ hasLink ? link.url : __wprm( 'No link set' ) }</div>
                            <div className="wprm-admin-modal-field-ingredient-links-link-nofollow">{ hasLink ? nofollowLabel : '' }</div>
                        </Fragment>
                    }
                </Fragment>
                :
                <Fragment>
                    <FieldText
                        name="ingredient-link"
                        type="url"
                        value={ link.url }
                        onChange={ (url) => {
                            props.onLinkChange( {
                                ...link,
                                url,
                            } );
                        }}
                    />
                    <FieldDropdown
                        options={ wprm_admin_modal.options.ingredient_link_nofollow }
                        value={ link.nofollow }
                        onChange={ (nofollow) => {
                            props.onLinkChange( {
                                ...link,
                                nofollow,
                            } );
                        }}
                        width={ 200 }
                    />
                </Fragment>
            }
        </div>
    );
}
export default IngredientLink;