const ingredientLinksEndpoint = wprm_admin.endpoints.ingredient_links;

import ApiWrapper from '../../../../../shared/ApiWrapper';

export default {
    getGlobalLinks(ingredients) {
        const data = {
            ingredients,
        };

        return ApiWrapper.call( `${ingredientLinksEndpoint}`, 'POST', data );
    },
    saveGlobalLinks(links) {
        const data = {
            links,
        };

        return ApiWrapper.call( `${ingredientLinksEndpoint}`, 'PUT', data );
    },
};
