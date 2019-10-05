if (!global._babelPolyfill) { require('babel-polyfill'); }
import ReactDOM from 'react-dom';
import React from 'react';
import { HashRouter } from 'react-router-dom';

import App from './admin-manage/App';

let appContainer = document.getElementById( 'wprm-admin-manage' );

if (appContainer) {
	ReactDOM.render(
		<HashRouter>
    	    <App/>
  	    </HashRouter>,
		appContainer
	);
}