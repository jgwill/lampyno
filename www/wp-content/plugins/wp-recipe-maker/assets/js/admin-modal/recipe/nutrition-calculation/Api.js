const nutritionEndpoint = wprm_admin.endpoints.nutrition;

import ApiWrapper from '../../../shared/ApiWrapper';

export default {
    getCalculated(nutrition) {
        const data = {
            nutrition,
        };

        return ApiWrapper.call( `${nutritionEndpoint}/calculated`, 'POST', data );
    },
    getMatches(ingredients) {
        const data = {
            ingredients,
        };

        return ApiWrapper.call( `${nutritionEndpoint}/matches`, 'POST', data );
    },
    getApiOptions(search) {
        const data = {
            search,
        };

        return ApiWrapper.call( `${nutritionEndpoint}/api/options`, 'POST', data );
    },
    getApiFacts(ingredients) {
        const data = {
            ingredients,
        };

        return ApiWrapper.call( `${nutritionEndpoint}/api/facts`, 'POST', data );
    },
    saveCustomIngredient( id, amount, unit, name, nutrients ) {
        const data = {
            amount,
            unit,
            name,
            nutrients,
        };

        id = parseInt( id );
        const endpoint = id ? `${nutritionEndpoint}/custom/${id}` : `${nutritionEndpoint}/custom`;
        const method = id ? 'PUT' : 'POST';

        return ApiWrapper.call( endpoint, method, data );
    },
    getCustomIngredient( id ) {
        return ApiWrapper.call( `${nutritionEndpoint}/custom/${id}` );
    },
    getCustomIngredients( search ) {
        const data = {
            search,
        };

        return ApiWrapper.call( `${nutritionEndpoint}/custom/search`, 'POST', data );
    },
};
