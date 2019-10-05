import { get_active_system } from '../../../../wp-recipe-maker-premium/addons-pro/unit-conversion/assets/js/shared/unit-conversion';

function print_recipe(recipe_id, servings, system) {
	const urlParts = wprm_public.home_url.split(/\?(.+)/);
	let printUrl = urlParts[0];

	if ( wprm_public.permalinks ) {
		printUrl += 'wprm_print/' + recipe_id;

		if ( urlParts[1] ) {
			printUrl += '?' + urlParts[1];
		}
	} else {
		printUrl += '?wprm_print=' + recipe_id;

		if ( urlParts[1] ) {
			printUrl += '&' + urlParts[1];
		}
	}

	var print_window = window.open(printUrl, '_blank');
	print_window.onload = function() {
		print_window.focus();
		print_window.document.title = document.title;
		print_window.history.pushState('', 'Print Recipe', location.href.replace(location.hash,""));
		print_window.set_print_system(system);
		print_window.set_print_servings(servings);

		setTimeout(function() {
			print_window.print();
		}, 250);
	};
};

jQuery(document).ready(function($) {
	jQuery(document).on('click', '.wprm-recipe-print, .wprm-print-recipe-shortcode', function(e) {

		var recipe_id = jQuery(this).data('recipe-id');

		// Backwards compatibility.
		if (!recipe_id) {
			recipe_id = jQuery(this).parents('.wprm-recipe-container').data('recipe-id');
		}

		// Follow the link if still no recipe id, otherwise override link functionality.
		if (recipe_id) {
			e.preventDefault();

			var servings = false,
				system = 1,
				recipe = jQuery('#wprm-recipe-container-' + recipe_id);

			if ( ! recipe.length ) {
				recipe = jQuery(this).parents('.wprm-recipe');
			}

			if (0 < recipe.length) {
				servings = parseInt(recipe.find('.wprm-recipe-servings').data('servings'));
				system = get_active_system(recipe);
			}

			print_recipe(recipe_id, servings, system);
		}
	});
});
