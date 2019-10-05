if (!global._babelPolyfill) { require('babel-polyfill'); }

// Global variables.
import { createHooks } from '@wordpress/hooks';
let hooks = createHooks();

export { hooks };