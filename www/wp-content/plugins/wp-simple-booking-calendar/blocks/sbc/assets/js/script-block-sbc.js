var el                = wp.element.createElement;
var ServerSideRender  = wp.components.ServerSideRender;
var PanelBody         = wp.components.PanelBody;
var SelectControl     = wp.components.SelectControl;
var registerBlockType = wp.blocks.registerBlockType;
var InspectorControls = wp.editor.InspectorControls;
var __                = wp.i18n.__;

// Register the block
registerBlockType( 'wp-simple-booking-calendar/sbc', {

    // The block's title
    title : 'Single Calendar',

    // The block's icon
    icon : 'calendar-alt',

    // The block category the block should be added to
    category : 'wp-simple-booking-calendar',

    // The block's attributes, needed to save the data
    attributes : {

        title : {
            type : 'string'
        }

    },

    edit : function( props ) {

        return [
            
            el( ServerSideRender, {
                block      : 'wp-simple-booking-calendar/sbc',
                attributes : props.attributes
            }),

            el( InspectorControls, { key : 'inspector' }, 

                el( PanelBody, {
                    title       : __( 'Calendar Options', 'wp-simple-booking-calendar' ),
                    initialOpen : true
                },

                    el( SelectControl, {

                        label   : __( 'Display Calendar Title', 'wp-simple-booking-calendar' ),
                        value   : props.attributes.title,
                        options : [
                            { value : 'yes', label : __( 'Yes', 'wp-simple-booking-calendar' ) },
                            { value : 'no', label : __( 'No', 'wp-simple-booking-calendar' ) }
                        ],
                        onChange : function( new_value ) {
                            props.setAttributes( { title : new_value } );
                        }
                    })

                )

            )

        ];

    },

    save : function() {
        return null;
    }

});