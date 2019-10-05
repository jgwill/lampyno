const ratingEndpoint = wprm_admin.endpoints.rating;

import ApiWrapper from '../ApiWrapper';

export default {
    update(rating) {
        const data = {
            rating,
        }

        return ApiWrapper.call( `${ratingEndpoint}`, 'POST', data );
    },
    delete(id) {
        return ApiWrapper.call( `${ratingEndpoint}/${id}`, 'DELETE' );
    },
};
