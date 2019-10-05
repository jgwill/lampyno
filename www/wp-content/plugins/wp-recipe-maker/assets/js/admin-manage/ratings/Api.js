const ratingEndpoint = wprm_admin.endpoints.rating;

import ApiWrapper from '../../shared/ApiWrapper';

export default {
    updateRating(rating) {
        const data = {
            rating,
        }

        return ApiWrapper.call( `${ratingEndpoint}`, 'POST', data );
    },
    deleteRating(id) {
        return ApiWrapper.call( `${ratingEndpoint}/${id}`, 'DELETE' );
    },
};
