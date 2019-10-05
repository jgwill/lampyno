export function __wprm( text, domain = 'wp-recipe-maker' ) {
    if ( wprm_admin.translations.hasOwnProperty( text ) ) {
        return wprm_admin.translations[ text ];
    } else {
        return text;
    }
};
