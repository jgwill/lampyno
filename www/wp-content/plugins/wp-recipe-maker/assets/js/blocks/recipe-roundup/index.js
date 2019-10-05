const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const {
    Button,
    Disabled,
    ServerSideRender,
    Toolbar,
} = wp.components;
const {
    BlockControls,
} = wp.editor;
const { Fragment } = wp.element;

import Sidebar from './Sidebar';

import '../../../css/blocks/recipe.scss';

const cleanUpShortcodeAttribute = (value) => {
    value = value.replace(/"/gm, '%22');
    value = value.replace(/\]/gm, '%5D');
    value = value.replace(/\r?\n|\r/gm, '%0A');
    return value;
}

registerBlockType( 'wp-recipe-maker/recipe-roundup-item', {
    title: __( 'WPRM Recipe Roundup Item' ),
    description: __( 'Output your Recipe Roundup as ItemList metadata.' ),
    icon: 'media-document',
    keywords: [ 'wprm', 'wp recipe maker' ],
    category: 'wp-recipe-maker',
    supports: {
		html: false,
    },
    transforms: {
        from: [
            {
                type: 'shortcode',
                tag: 'wprm-recipe-roundup-item',
                attributes: {
                    id: {
                        type: 'number',
                        shortcode: ( { named: { id = '' } } ) => {
                            const parsedId = parseInt( id.replace( 'id', '' ) );
                            return isNaN( parsedId ) ? 0 : parsedId;
                        },
                    },
                    link: {
                        type: 'string',
                        shortcode: ( { named: { link = '' } } ) => {
                            return link.replace( 'link', '' );
                        },
                    },
                    nofollow: {
                        type: 'string',
                        shortcode: ( { named: { nofollow = '' } } ) => {
                            return nofollow.replace( 'nofollow', '' );
                        },
                    },
                    newtab: {
                        type: 'string',
                        shortcode: ( { named: { newtab = '' } } ) => {
                            return newtab.replace( 'newtab', '' );
                        },
                    },
                    image: {
                        type: 'number',
                        shortcode: ( { named: { image = '' } } ) => {
                            const parsedImage = parseInt( image.replace( 'image', '' ) );
                            return isNaN( parsedImage ) ? 0 : parsedImage;
                        },
                    },
                    name: {
                        type: 'string',
                        shortcode: ( { named: { name = '' } } ) => {
                            return name.replace( 'name', '' );
                        },
                    },
                    summary: {
                        type: 'string',
                        shortcode: ( { named: { summary = '' } } ) => {
                            return summary.replace( 'summary', '' );
                        },
                    },
                    template: {
                        type: 'string',
                        shortcode: ( { named: { template = '' } } ) => {
                            return template.replace( 'template', '' );
                        },
                    },
                },
            },
        ]
    },
    edit: (props) => {
        const { attributes, setAttributes, isSelected, className } = props;

        const modalCallback = ( fields ) => {
            setAttributes({
                id: 'external' !== fields.type ? fields.recipe.id : 0,
                link: fields.link,
                nofollow: fields.nofollow ? '1' : '',
                newtab: fields.newtab ? '1' : '',
                image: parseInt( fields.image.id ),
                name: fields.name,
                summary: fields.summary.replace(/\r?\n|\r/gm, '%0A'),
            });
        }

        return (
            <div className={ className }>{
                attributes.id || attributes.link
                ?
                <Fragment>
                    <Sidebar {...props} />
                    <BlockControls>
                        <Toolbar
                            controls={[
                                {
                                    icon: 'edit',
                                    title: __( 'Edit Recipe' ),
                                    onClick: () => {
                                        WPRM_Modal.open( 'roundup', {
                                            fields: {
                                                roundup: attributes,
                                            },
                                            insertCallback: ( fields ) => {
                                                modalCallback( fields );
                                            },
                                        } );
                                    }
                                }
                            ]}
                        />
                    </BlockControls>
                    <Disabled>    
                        <ServerSideRender
                            block="wp-recipe-maker/recipe-roundup-item"
                            attributes={ attributes }
                        />
                    </Disabled>
                </Fragment>
                :
                <Fragment>
                    <h2>WPRM { __( 'Recipe Roundup Item' ) }</h2>
                    <Button
                        isLarge
                        onClick={ () => {
                            WPRM_Modal.open( 'roundup', {
                                insertCallback: ( fields ) => {
                                    modalCallback( fields );
                                },
                            } );
                        }}>
                        { __( 'Select Recipe' ) }
                    </Button>
                </Fragment>
            }</div>
        )
    },
    save: (props) => {
        const { attributes } = props;

        if ( attributes.id ) {
            let shortcode = `[wprm-recipe-roundup-item id="${attributes.id}"`;
            if ( attributes.template ) {
                shortcode += ` template="${attributes.template}"`;
            }
            shortcode += ']';
            return shortcode;
        } else if ( attributes.link ) {
            let shortcode = `[wprm-recipe-roundup-item link="${ cleanUpShortcodeAttribute( attributes.link )}"`;
            
            shortcode += attributes.nofollow ? ' nofollow="1"' : '';
            shortcode += attributes.newtab ? '' : ' newtab="0"';
            shortcode += attributes.image ? ` image="${ attributes.image }"` : '';
            shortcode += ` name="${ cleanUpShortcodeAttribute( attributes.name ) }"`;
            shortcode += ` summary="${ cleanUpShortcodeAttribute( attributes.summary ) }"`;
            
            shortcode += ']';
            return shortcode;
        } else {
            return null;
        }
    },
} );