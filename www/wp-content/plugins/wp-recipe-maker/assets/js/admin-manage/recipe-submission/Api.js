const submissionEndpoint = wprm_admin.endpoints.recipe_submission;

import ApiWrapper from '../../shared/ApiWrapper';

export default {
    approveSubmission(id, createPost) {
        const data = {
            createPost,
        }

        return ApiWrapper.call( `${submissionEndpoint}/approve/${id}`, 'POST', data );
    },
};
