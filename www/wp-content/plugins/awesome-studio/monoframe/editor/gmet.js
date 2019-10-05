(function($) {
	
	$(document).ready(function() {
    	var $bar = $('<div></div>');
        $bar.addClass('quicktags-toolbar');
        $wrap = $('#gmet_content_wrap');
        $wrap.children().css('padding', '5px 15px');
        $wrap.prepend($bar);
        $('#wp-content-editor-tools #content-html').after(
          '<button type="button" id="content-gmet" class="wp-switch-editor switch-code">' + gmetData.tabTitle + '</button>'
        );
	});
	
	$(document).on('click', '#content-gmet', function(e) {
		e.preventDefault();
		var id = 'content';
		var ed = tinyMCE.get(id);
		var dom = tinymce.DOM;
		$('#wp-content-editor-container, #post-status-info').hide();
		
		var editor = ace.edit("ace_ui_code");

		if($('div.wp-editor-wrap').hasClass('html-active')){
			editor.setValue(wp.editor.autop( jQuery('#content').val() ));
		}
		else if($('div.wp-editor-wrap').hasClass('tmce-active')){
			editor.setValue(tinyMCE.activeEditor.getContent());
		}
		
		dom.removeClass('wp-content-wrap', 'html-active');
		dom.removeClass('wp-content-wrap', 'tmce-active');
		$(this).addClass('active');
		$('#gmet_content_wrap').show();
	});
	
	$(document).on('click', '#content-tmce, #content-html', function(e) {
		e.preventDefault();
		if($('#content-gmet').hasClass('active')){
			$('#content-gmet').removeClass('active');
			$('#gmet_content_wrap').hide();
			var ace_editor = ace.edit("ace_ui_code");
			
			//if($('div.wp-editor-wrap').hasClass('html-active')){
				
			//}
			//else if($('div.wp-editor-wrap').hasClass('tmce-active')){
			//	editor.setValue(tinyMCE.activeEditor.getContent());
			//}
			//;
			
			//if(tinyMCE.activeEditor)
			$('#wp-content-editor-container, #post-status-info').show();
			
			console.log(tinyMCE.activeEditor);
			
			editor = typeof tinymce !== 'undefined' && tinymce.get('content');

			if ( editor && ! editor.isHidden() && typeof switchEditors !== 'undefined' ) {
				// Make sure there's an undo level in the editor
				editor.undoManager.add();
				editor.setContent(ace_editor.getValue());
			} else {
				// Make sure the Text editor is selected
				$( '#content-html' ).click();
				$( '#content' ).val( ace_editor.getValue() );
			}
			
			//tinyMCE.activeEditor.setContent(editor.getValue());
		}
		
	});
	
})(jQuery);