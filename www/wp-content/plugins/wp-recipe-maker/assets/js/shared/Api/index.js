const { hooks } = WPRecipeMaker.shared;

import General from './General';
import Import from './Import';
import Manage from './Manage';
import Modal from './Modal';
import Rating from './Rating';
import Recipe from './Recipe';
import Settings from './Settings';
import Template from './Template';

const api = hooks.applyFilters( 'api', {
    general: General,
    import: Import,
    manage: Manage,
    modal: Modal,
    rating: Rating,
    recipe: Recipe,
    settings: Settings,
    template: Template,
} );

export default api;