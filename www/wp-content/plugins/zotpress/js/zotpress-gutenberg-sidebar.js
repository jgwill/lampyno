( function( wp ) {
    var registerPlugin = wp.plugins.registerPlugin;
    var PluginSidebar = wp.editPost.PluginSidebar;
    var el = wp.element.createElement;

    registerPlugin( 'zotpress-gutenberg-sidebar', {
        render: function() {
            return el( PluginSidebar,
                {
                    name: 'zotpress-gutenberg-sidebar',
                    icon: 'admin-post',
                    title: 'Zotpress',
                },
                'Meta field'
            );
        },
    } );
} )( window.wp );
