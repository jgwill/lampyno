( function( blocks, editor, i18n, element, components, _ ) {
    var el = element.createElement;
    var RichText = editor.RichText;
    var MediaUpload = editor.MediaUpload;


    blocks.registerBlockType( 'docxpresso-cut-paste/plugin', {
        title: 'Docxpresso',
        icon: 'media-document',
        category: 'widgets',
        attributes: {
                mediaID: {
                        type: 'number',
                },
                mediaURL: {
                        type: 'string',
                        source: 'attribute'
                },
                content: {
                        type: 'array',
                        source: 'children',
                        selector: 'p',
                },
        },
        edit: function( props ) {
                var attributes = props.attributes;

                var onSelectFile = function( media ) {
                    var extension = media.url.split('.').pop();
                    if (extension == 'odt' || extension == 'ods' ) {
                        return props.setAttributes( {
                                    mediaURL: media.url,
                                    mediaID: media.id,
                                    content: '[docxpresso file="' + media.url +'"]',
                            } );
                    } else {
                        alert('You need to use a .odt or .ods file');
                    }
                };

                return (
                            el( 'div', { className: props.className },
                                el( MediaUpload, {
                                    onSelect: onSelectFile,
                                    allowedTypes: 'application/vnd.oasis.opendocument.text, application/vnd.oasis.opendocument.spreadsheet',
                                    value: attributes.mediaID,
                                    render: function( obj ) {
                                        return el( components.Button, {
                                                    className: attributes.mediaID ? 'file-button' : 'button button-large',
                                                    onClick: obj.open
                                                },
                                                ! attributes.mediaID ? 'select File' : el(RichText,{tagName: 'p',className: props.className,onChange: onSelectFile,value: attributes.content,})
                                        );
                                    }
                                } )
                            )	
                        );	
            },
        save: function( props ) {
            var attributes = props.attributes;
            return (
                    el( 'div', { className: props.className },
                            el( RichText.Content, {tagName: 'p', value: props.attributes.content} ),
                            )
            );
        },
    } );

} )(
	window.wp.blocks,
	window.wp.editor,
	window.wp.i18n,
	window.wp.element,
	window.wp.components,
	window._,
);
