const nutrientEndpoint = wprm_admin.endpoints.nutrient;

import ApiWrapper from '../../shared/ApiWrapper';

export default {
    updateNutrient(editing, nutrient) {
        const data = {
            key: nutrient.key,
            nutrient,
        }

        const method = editing ? 'PUT' : 'POST';

        return ApiWrapper.call( nutrientEndpoint, method, data );
    },
    deleteNutrient(key) {
        const data = {
            key,
        };

        return ApiWrapper.call( nutrientEndpoint, 'DELETE', data );
    },
};
