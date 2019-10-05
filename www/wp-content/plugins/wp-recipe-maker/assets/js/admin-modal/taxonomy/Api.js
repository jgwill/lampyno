const customTaxonomiesEndpoint = wprm_admin.endpoints.custom_taxonomies;

import ApiWrapper from '../../shared/ApiWrapper';

export default {
    saveCustomTaxonomy( editing, taxonomy ) {
        const data = {
            ...taxonomy,
        };

        const method = editing ? 'PUT' : 'POST';

        return ApiWrapper.call( customTaxonomiesEndpoint, method, data );
    },
    deleteCustomTaxonomy( key ) {
        const data = {
            key,
        };

        return ApiWrapper.call( customTaxonomiesEndpoint, 'DELETE', data );
    },
};
