const manageEndpoint = wprm_admin.endpoints.manage;

import ApiWrapper from '../../shared/ApiWrapper';

export default {
    bulkEdit(route, type, ids, action) {
        const data = {
            type,
            ids,
            action,
        };

        return ApiWrapper.call( `${manageEndpoint}/${route}/bulk`, 'POST', data );
    },
};
