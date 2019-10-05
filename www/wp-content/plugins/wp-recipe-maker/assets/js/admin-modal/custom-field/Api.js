const customFieldsEndpoint = wprm_admin.endpoints.custom_fields;

import ApiWrapper from '../../shared/ApiWrapper';

export default {
    saveCustomField( editing, field ) {
        const data = {
            ...field,
        };

        const method = editing ? 'PUT' : 'POST';

        return ApiWrapper.call( customFieldsEndpoint, method, data );
    },
    deleteCustomField( key ) {
        const data = {
            key,
        };

        return ApiWrapper.call( customFieldsEndpoint, 'DELETE', data );
    },
};
