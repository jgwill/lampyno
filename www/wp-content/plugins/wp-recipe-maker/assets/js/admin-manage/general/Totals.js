import React, { Fragment } from 'react';

import { __wprm } from 'Shared/Translations';
 
const Totals = (props) => {
    if ( ! props.filtered && ! props.total ) {
        return <div className="wprm-admin-table-totals">&nbsp;</div>;
    }

    const isFiltered = false !== props.filtered && props.filtered != props.total;

    return (
        <div className="wprm-admin-table-totals">
            {
                props.total
                ?
                <Fragment>
                    {
                    isFiltered
                    ?
                    `${ __wprm( 'Showing' ) } ${ Number(props.filtered).toLocaleString() } ${ __wprm( 'filtered of' ) } ${ Number(props.total).toLocaleString() } ${ __wprm( 'total' ) }`
                    :
                    `${ __wprm( 'Showing' ) } ${ Number(props.total).toLocaleString() } ${ __wprm( 'total' ) }`
                }
                </Fragment>
                :
                `${ Number(props.filtered).toLocaleString() } ${ __wprm( 'rows' ) }`
            }
        </div>
    );
}
export default Totals;