const conversionEndpoint = wprm_admin.endpoints.unit_conversion;

import ApiWrapper from '../../../../../shared/ApiWrapper';

export default {
    getConversions(ingredients) {
        const data = {
            ingredients,
        };

        return ApiWrapper.call( `${conversionEndpoint}`, 'POST', data );
    },    
};
