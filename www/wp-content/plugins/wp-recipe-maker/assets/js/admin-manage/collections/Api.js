const collectionsEndpoint = wprm_admin.endpoints.collections;

import ApiWrapper from '../../shared/ApiWrapper';

export default {
    deleteCollection(id) {
        return ApiWrapper.call( `${collectionsEndpoint}/${id}`, 'DELETE' );
    },
};
