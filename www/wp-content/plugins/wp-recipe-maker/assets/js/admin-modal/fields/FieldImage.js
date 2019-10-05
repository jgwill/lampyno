import React from 'react';

import Media from '../general/Media';
import Button from 'Shared/Button';
import { __wprm } from 'Shared/Translations';
 
const FieldImage = (props) => {
    const hasImage = props.id > 0;

    const selectImage = (e) => {
        e.preventDefault();

        Media.selectImage((attachment) => {
            props.onChange( attachment.id, attachment.url );
        });
    }

    return (
        <div className="wprm-admin-modal-field-image">
            {
                hasImage
                ?
                <div className="wprm-admin-modal-field-image-preview">
                    <img
                        onClick={ selectImage }
                        src={ props.url }
                    />
                    <a
                        href="#"
                        tabIndex={ props.disableTab ? '-1' : null }
                        onClick={ (e) => {
                            e.preventDefault();
                            props.onChange( 0, '' );
                        } }
                    >{ __wprm( 'Remove Image' ) }</a>
                </div>
                :
                <Button
                    required={ props.required }
                    disableTab={ props.disableTab }
                    onClick={ selectImage }
                    
                >{ __wprm( 'Select Image' ) }</Button>
            }
        </div>
    );
}
export default FieldImage;