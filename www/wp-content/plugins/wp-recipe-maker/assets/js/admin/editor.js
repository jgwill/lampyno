// Opening Modal
jQuery(document).ready(function($) {
    jQuery(document).on('click', '.wprm-modal-menu-button', function() {
        let insertedRecipe = false;

        WPRM_Modal.open( 'menu', {
            insertCallback: ( shortcode ) => {
                const editorId = jQuery(this).data('editor');
                
                if ( editorId ) {
                    WPRM_Modal.addTextToEditor( shortcode, editorId );
                }
            },
            saveCallback: ( recipe ) => {
                const editorId = jQuery(this).data('editor');

                if ( editorId ) {
                    if ( ! insertedRecipe ) {
                        WPRM_Modal.addTextToEditor( '[wprm-recipe id="' + recipe.id + '"]', editorId );
                        insertedRecipe = true;
                    } else {
                        WPRM_Modal.refreshEditor( editorId );
                    }
                }
            },
        } );
    });
    
    // Edit Recipe button
    jQuery(document).on('click', '.wprm-modal-edit-button', function() {
        const recipeId = jQuery(this).data('recipe');

        WPRM_Modal.open( 'recipe', {
            recipeId,
            saveCallback: ( recipe ) => {
                const editorId = jQuery(this).data('editor');

                if ( editorId ) {
                    WPRM_Modal.refreshEditor( editorId );
                }
            },
        } );
    });
});