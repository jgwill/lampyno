<div id="gmet_content_wrap" class="wp-editor-container">
    <?php
	 global $post;
	  /*
	   * Use get_post_meta() to retrieve an existing value
	   * from the database and use the value for the form.
	   */
	//  $value = get_post_meta( $post->ID, '_my_meta_value_key', true );


	  echo'<style>
	  .ace_editor.fullScreen {
			height: auto!important;
			width: auto!important;
			border: 0;
			margin: 0;
			position: fixed !important;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			z-index: 100000;
		}
		.fullScreen {
			overflow: hidden
		}</style>';
	  echo'<pre id="ace_ui_code" style="width:100%%;height:30em" ></pre>';
	  echo '<textarea id="aw_ui_code" name="aw_ui_code" rows="20" cols="100" />'.str_replace('<','__lt__',$post->post_content).'</textarea>';
	echo "<script>
	window.onload = function() {
	ace.require('ace/ext/language_tools');
	var dom = ace.require('ace/lib/dom');

	//add command to all new editor instaces
	ace.require('ace/commands/default_commands').commands.push({
		name: 'Toggle Fullscreen',
		bindKey: 'F11',
		exec: function(editor) {
			var fullScreen = dom.toggleCssClass(document.body, 'fullScreen')
			if(fullScreen)
			{
				editor.setOption('maxLines', 44);
			}
			else
			{	
				editor.setOption('maxLines', 'Infinity');
			}	
			dom.setCssClass(editor.container, 'fullScreen', fullScreen)
			editor.setAutoScrollEditorIntoView(!fullScreen)
			editor.resize()
		}
	},
	{
		name: 'saveFileNoRefresh',
		bindKey: {
		win: 'Ctrl-S',
		mac: 'Command-S',
		sender: 'editor|cli'
		},
		exec: function(env, args, request) {
			var b = false;
				if(jQuery('input#update-no-refresh').length == 1){
					b=jQuery('input#update-no-refresh');
				}
				else if(jQuery('input#publish').length == 1)
				{
					b = jQuery('input#publish');
				}
				
				if(b != false)
				{
					b.click();
				}
		}
	},
	{
		name: 'saveFile',
		bindKey: {
		win: 'Ctrl-Shift-S',
		mac: 'Command-Shift-S',
		sender: 'editor|cli'
		},
		exec: function(env, args, request) {
			var b = false;
				if(jQuery('input#save-post').length == 1)
				{
					b = jQuery('input#save-post');
				}
				else if(jQuery('input#publish').length == 1)
				{
					b = jQuery('input#publish');
				}
				if(b != false)
				{
					//var n = e.target.nodeName.toLowerCase();
					//if(n == 'textarea' || n == 'input')
					//{
						b.click();
					//	return false;
					//}
				}
		}
	});

	var editor = ace.edit('ace_ui_code');
	var textarea = jQuery('#aw_ui_code');
	textarea.hide();

	editor.setTheme('ace/theme/merbivore_soft_awui');
	editor.getSession().setMode('ace/mode/awui');
	//autocomplete
		var Autocomplete = ace.require('ace/autocomplete').Autocomplete;
		editor.completer = new Autocomplete;
		//editor.completer.keyboardHandler.removeCommand('Tab');
		editor.completer.liveAutocompletionAutoSelect = true;
		editor.completer.exactMatch = true;
		
		var shifteditCompleter = {
			getCompletions : function (editor, session, pos, prefix, callback) {
				var completions = (new shiftedit.autocomplete).run(editor, session, pos, prefix, callback, prefix !== '');
				if (completions) {
					callback(null, completions)
				}
			},
			getDocTooltip : function (selected) {
				if (selected.doc) {
					return {
						docHTML : selected.doc
					}
				}
			}
		};
		editor.completers = [shifteditCompleter]


	editor.setOptions({
		maxLines: Infinity,
		enableBasicAutocompletion: true,
		enableSnippets: true,
		enableLiveAutocompletion: true,
		autoScrollEditorIntoView: true
	});
	editor.getSession().setUseWrapMode('true');
	editor.getSession().setTabSize(2);
	editor.getSession().setUseSoftTabs(true);
	var content=textarea.val();
	content=content.replace(/__lt__/g, '<');
	editor.getSession().setValue(content);
	textarea.val(editor.getSession().getValue());
	editor.getSession().on('change', function(){
	  textarea.val(editor.getSession().getValue());
	});		
	}	

	</script>";

	?>
</div>