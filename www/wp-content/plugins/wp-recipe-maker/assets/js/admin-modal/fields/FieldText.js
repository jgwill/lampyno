import React from 'react';
 
const FieldText = (props) => {
    const disabled = props.hasOwnProperty( 'disabled' ) ? props.disabled : false;
    const type = props.hasOwnProperty( 'type' ) ? props.type : 'text';

    return (
        <input
            type={ type }
            disabled={ disabled }
            name={props.name}
            value={props.value}
            placeholder={props.placeholder}
            onChange={(e) => {
                props.onChange( e.target.value );
            }}
            onKeyDown={(e) => {
                if ( props.onKeyDown ) {
                    props.onKeyDown(e);
                }
            }}
        />
    );
}
export default FieldText;