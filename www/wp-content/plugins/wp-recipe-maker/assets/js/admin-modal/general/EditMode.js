import React from 'react';

import '../../../css/admin/modal/general/edit-mode.scss';

const EditMode = (props) => {
    if ( ! props.modes ) {
        return null;
    }

    return (
        <div
            className="wprm-admin-modal-field-edit-mode-container"
        >
            {
                Object.keys( props.modes ).map((id, index) => {
                    const mode = props.modes[id];

                    return (
                        <a
                            href="#"
                            className={ `wprm-admin-modal-field-edit-mode${ id === props.mode ? ' wprm-admin-modal-field-edit-mode-selected' : '' }` }
                            onClick={(e) => {
                                e.preventDefault();
                                props.onModeChange( id );
                            }}
                            key={index}
                        >
                            { mode.label }
                        </a>
                    )
                })
            }
        </div>
    );
}
export default EditMode;