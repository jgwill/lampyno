const recipeEndpoint = wprm_admin.endpoints.recipe;
const noticeEndpoint = wprm_admin.endpoints.notices;

import ApiWrapper from './ApiWrapper';

export default {
    getRecipe(id) {
        return ApiWrapper.call( `${recipeEndpoint}/${id}` );
    },
    saveRecipe(recipe) {
        const data = {
            recipe,
        };

        // Default to create new recipe.
        let url = recipeEndpoint;
        let method = 'POST';

        // Recipe ID set? Update an existing one.
        const recipeId = recipe.id ? parseInt(recipe.id) : false;
        if ( recipeId ) {
            url += `/${recipeId}`
            method = 'PUT';
        }

        return ApiWrapper.call( url, method, data );
    },
    updateRecipeStatus(recipeId, status) {
        const data = {
            status,
        };

        return ApiWrapper.call( `${recipeEndpoint}/${recipeId}`, 'PUT', data );
    },
    deleteRecipe(id, permanently = false) {
        let endpoint = `${recipeEndpoint}/${id}`;
        
        if ( permanently ) {
            endpoint += '?force=true';
        }

        return ApiWrapper.call( endpoint, 'DELETE' );
    },
    deleteRecipeRevision(recipe_id, revision_id) {
        return ApiWrapper.call( `${recipeEndpoint}/${recipe_id}/revisions/${revision_id}?force=true`, 'DELETE' );
    },
    dismissNotice(id) {
        const data = {
            id,
        };

        return ApiWrapper.call( noticeEndpoint, 'DELETE', data );
    },
};
