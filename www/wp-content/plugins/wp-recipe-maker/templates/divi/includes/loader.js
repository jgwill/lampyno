// Internal Dependencies
import modules from './modules';

jQuery(window).on('et_builder_api_ready', (event, API) => {
    console.log('register', modules);
    API.registerModules(modules);
});